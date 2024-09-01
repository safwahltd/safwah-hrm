<?php

namespace App\Http\Controllers\employee;

use App\Models\Attendance;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DateTimeZone;

class AttendanceController extends Controller
{
    public function attendanceList(){
        $attendances = Attendance::where('user_id',auth()->user()->id)->latest()->paginate(30);
        return view('employee.attendance.index',compact('attendances'));
    }
     public function adminAttendanceList(){
        $attendances = Attendance::latest()->paginate(30);
        return view('admin.attendance.index',compact('attendances'));
    }

    public function getClockStatus()
    {
        $userId = auth()->user()->id;
        $today = now()->toDateString();

        // Check for clock-in record without clock-out for today
        $attendance = Attendance::where('user_id', $userId)
            ->whereDate('clock_in', $today)
            ->whereNull('clock_out')
            ->first();

        return response()->json([
            'isClockedIn' => $attendance ? true : false,
        ]);
    }
    public function clockIn(Request $request)
    {
        $userId = auth()->user()->id;
        $today = now()->toDateString();
        $dateTimeConvertAsia = new DateTime('now', new DateTimeZone('Asia/Dhaka'));
        $clockIn = Carbon::parse($dateTimeConvertAsia)->format('jS F Y, h:i a');
//        dd($today,now(),$dateTimeConvertAsia);

        // Check if the user has already clocked in today
        $attendance = Attendance::where('user_id', $userId)
            ->whereDate('clock_in', $today)
            ->whereNull('clock_out')
            ->first();

        if ($attendance) {
            return response()->json(['message' => 'Already clocked in today.'], 400);
        }

        // Create a new clock-in record
        $attendanceNew = new Attendance();
        $attendanceNew->user_id = $userId;
        $attendanceNew->clock_in = $dateTimeConvertAsia;
        $attendanceNew->clock_in_date = $today;
        $attendanceNew->save();

        return response()->json([
                'message' => 'Clocked in successfully.',
                'clockIn' => $clockIn,
            ]);
    }
    public function clockOut(Request $request)
    {
        $userId = auth()->user()->id;
        $today = now()->toDateString();
        $d = \Illuminate\Support\Carbon::now('Asia/Dhaka');

        $clockOut = Carbon::parse($d)->format('jS F Y, h:i a');
        // Check if the user has already clocked in today
        $attendance = Attendance::where('user_id', $userId)
            ->whereDate('clock_in', $today)
            ->whereNull('clock_out')
            ->first();
        if (!$attendance) {
            return response()->json(['message' => 'No clock-in record found for today.'], 400);
        }
        $workingTimeInSeconds = \Illuminate\Support\Carbon::now('Asia/Dhaka')->diffInSeconds($attendance->clock_in);
        $wroking_Time = gmdate('H:i:s',$workingTimeInSeconds);
//        $workingTimeFormatted = gmdate('H:i:s',\Illuminate\Support\Carbon::now('Asia/Dhaka')->diffInSeconds($attendance->clock_in));

        $attendance->clock_out = $d;
        $attendance->clock_out_date = $today;
        $attendance->working_time = $wroking_Time;
        $attendance->save();

        return response()->json([
            'message' => 'Clocked Out successfully.',
            'clockOut' => $clockOut,
            'working_time' => $wroking_Time,
        ]);
    }
    public function attendanceReport(){

        // Get the start and end dates of the current month
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        // Fetch attendance data
        $attendances = Attendance::whereBetween('clock_in', [$startOfMonth, $endOfMonth])
            ->with('user')
            ->get()
            ->groupBy(function($date) {
                return $date->clock_in; // Group by date
            });
        $datess = array();
        $dates = collect($attendances->keys())->sort()->values();
        foreach ($dates as $date){
            if (!in_array(\Illuminate\Support\Carbon::parse($date)->format('Y-m-d'),$datess)){
                array_push($datess,\Illuminate\Support\Carbon::parse($date)->format('Y-m-d'));
            }
        }
//        dd($datess);
        // Get the total number of days in the current month
        $totalDays = $endOfMonth->day;

      // Generate a list of all dates in the current month
        $datess = [];
        $currentDay = $startOfMonth->copy();
        while ($currentDay->lte($endOfMonth)) {
            $datess[] = $currentDay->format('Y-m-d');
            $currentDay->addDay();
        }
//        dd($startOfMonth,$endOfMonth,$totalDays,$currentDay,$dates);
        return view('employee.attendance.report',compact('datess','dates','attendances'));
    }
    public function adminAttendanceReport(Request $request){
        if ($request->year){
            // Get the filter parameters
            $year = $request->input('year');
            $month = $request->input('month');
            $day = $request->input('day', null);

            // Fetch all users with attendances for the specified month (and day if provided)
            $users = User::with(['attendances' => function ($query) use ($year, $month, $day) {
                $query->whereYear('clock_in', $year)
                    ->whereMonth('clock_in', $month);

                if ($day) {
                    $query->whereDay('clock_in', $day);
                }
            }])->get();

            // Generate dates for the selected month
            $dates = [];
            $totalDays = Carbon::createFromDate($year, $month)->daysInMonth;
            for ($d = 1; $d <= $totalDays; $d++) {
                $dates[] = Carbon::createFromDate($year, $month, $d)->toDateString();
            }
            return view('admin.attendance.report', compact('users', 'dates', 'year', 'month', 'day'));
        }
        else{
            // Get the current month
            $currentMonth = Carbon::now()->month;
            $currentYear = Carbon::now()->year;

            // Get all users
            $users = User::with(['attendances' => function ($query) use ($currentMonth, $currentYear) {
                $query->whereMonth('clock_in', $currentMonth)
                    ->whereYear('clock_in', $currentYear);
            }])->get();

            // Generate dates for the current month
            $dates = [];
            for ($day = 1; $day <= Carbon::now()->daysInMonth; $day++) {
                $dates[] = Carbon::createFromDate($currentYear, $currentMonth, $day)->toDateString();
            }
            $year = $currentYear;
            $month = $currentMonth;
            $day = Carbon::now()->day;
            return view('admin.attendance.report', compact('dates', 'users' , 'year', 'month', 'day'));
        }

    }
    public function getEvents()
    {
        $attendances = Attendance::where('user_id',auth()->user()->id)->get();

        $events = $attendances->map(function($attendance) {
            $clock_in = Carbon::parse($attendance->clock_in)->format('H:m:s');
            $clock_out = Carbon::parse($attendance->clock_out)->format('H:m:s');
            return [
                'title' => "In: {$clock_in},Out: {$clock_out}",
                'start' => $attendance->clock_in_date . 'T' . $clock_in,
                'end' => $attendance->clock_in_date . 'T' . $clock_out,
            ];
        });

        return response()->json($events);
    }
}
