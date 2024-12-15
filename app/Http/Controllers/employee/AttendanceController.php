<?php

namespace App\Http\Controllers\employee;

use App\Events\EmployeeNotificationEvent;
use App\Exports\AttendanceExport;
use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\Leave;
use App\Models\User;
use App\Models\UserInfos;
use App\Models\WorkingDay;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Exception;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use DateTime;
use DateTimeZone;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;


class AttendanceController extends Controller
{
    public function index(){
        if(auth()->user()->hasPermission('admin attendance index')){
            $attendances = Attendance::latest()->paginate(30);
            $users = User::where('status',1)->whereNotIn('id',[1])->get();
            return view('admin.attendance.index',compact('attendances','users'));
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function store(Request $request){
        if(auth()->user()->hasPermission('admin attendance store')){
            try{
                $validate = Validator::make($request->all(),[
                    'user_id' => 'required',
                    'month' => 'required',
                    'year' => 'required',
                    'working_day' => 'required',
                    'attend' => 'required',
                    'late' => 'required',
                    'absent' => 'required',
                ]);
                if($validate->fails()){
                    toastr()->error($validate->messages());
                    return back();
                }
                $user = UserInfos::where('user_id',$request->user_id)->first();
                $attend = Attendance::where('user_id',$request->user_id)->where('month',$request->month)->where('year',$request->year)->first();
                if (!$attend){
                    $attendance = new Attendance();
                    $attendance->user_id = $request->user_id;
                    $attendance->month = $request->month;
                    $attendance->year = $request->year;
                    $attendance->working_day = $request->working_day;
                    $attendance->attend = $request->attend;
                    $attendance->late = $request->late;
                    $attendance->absent = $request->absent;
                    /* File Upload Start */
                    if ($request->file('attachment')){
                        $fileExtension = $request->file('attachment')->getClientOriginalExtension();
                        $fileName = $user->employee_id.'_'.date('F', mktime(0, 0, 0, $request->month, 1)).'_'.$request->year.'.'.$fileExtension;
                        $path = 'upload/attendance/';
                        $request->file('attachment')->move($path,$fileName);
                        $url = $path.$fileName;
                        $attendance->attachment = $url;
                    }
                    /* File Upload End */

                    $attendance->save();

                    event(new EmployeeNotificationEvent(
                        '',
                        'Check your attendance report Of '.date('F', mktime(0, 0, 0, $attendance->month, 1)).', '.$attendance->year,
                        $attendance->user_id,
                        [
                            'content' => 'Working Day : '.$attendance->working_day.', Attend : '.$attendance->attend.' , Late : '.$attendance->late.' , Absent : '.$attendance->absent,
                            'user_id' => $attendance->user_id,
                            'url' => route('employee.attendance.list'),
                        ]
                    ));
                    toastr()->success('Attendance Create Successfully.');
                    return back();
                }
                else{
                    toastr()->error('Already Have This Attendance Data.');
                    return back();
                }
            }
            catch(Exception $e){
                toastr()->error($e->getMessage());
                return back();
            }
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function update(Request $request,$id){
        if(auth()->user()->hasPermission('admin attendance update')){
            try{
                $attendance = Attendance::find($id);
                $validate = Validator::make($request->all(),[
                    'month' => 'required',
                    'year' => 'required',
                    'working_day' => 'required',
                    'attend' => 'required',
                    'late' => 'required',
                    'absent' => 'required',
                ]);
                if($validate->fails()){
                    toastr()->error($validate->messages());
                    return back();
                }
                $user = UserInfos::where('user_id',$attendance->user_id)->first();
                $attend = Attendance::where('user_id',$attendance->user_id)->where('month',$request->month)->where('year',$request->year)->whereNotIn('id',[$id])->first();
                if (!$attend){
                    $attendance->user_id = $attendance->user_id;
                    $attendance->month = $request->month;
                    $attendance->year = $request->year;
                    $attendance->working_day = $request->working_day;
                    $attendance->attend = $request->attend;
                    $attendance->late = $request->late;
                    $attendance->absent = $request->absent;
                    /* File Upload Start */
                    if ($request->file('attachment')){
                        if (isset($attendance->attachment)){
                            unlink($attendance->attachment);
                        }
                        $fileExtension = $request->file('attachment')->getClientOriginalExtension();
                        $fileName = $user->employee_id.'_'.date('F', mktime(0, 0, 0, $request->month, 1)).'_'.$request->year.'.'.$fileExtension;
                        $path = 'upload/attendance/';
                        $request->file('attachment')->move($path,$fileName);
                        $url = $path.$fileName;
                        $attendance->attachment = $url;
                    }
                    /* File Upload End */

                    $attendance->save();
                    toastr()->success('Attendance Update Successfully.');
                    return back();
                }
                else{
                    toastr()->error('Already Have This Attendance Data.');
                    return back();
                }
            }
            catch(Exception $e){
                toastr()->error($e->getMessage());
                return back();
            }
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function destroy($id){
        if(auth()->user()->hasPermission('admin attendance destroy')){
            try{
                $attendance = Attendance::find($id);
                if (isset($attendance->attachment)){
                    unlink($attendance->attachment);
                }
                $attendance->delete();
                toastr()->success('Delete Successfully.');
                return back();
            }
            catch(Exception $e){
                toastr()->error($e->getMessage());
                return back();
            }
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function showFile($id)
    {
        if(auth()->user()->hasPermission('admin attendance showfile')){
            $attend = Attendance::findOrFail($id);
            $filePath = $attend->attachment;
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            // Handle PDF and image files
            if (in_array($extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'bmp','webp','svg','docx', 'doc', 'xlsx', 'xls'])) {
                return response()->file($filePath);
            }
            abort(404, 'File format not supported');
            return response()->file($filePath);
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function attendanceList(){
        $attendances = Attendance::where('user_id',auth()->user()->id)->latest()->paginate(100);
        return view('employee.attendance.index',compact('attendances'));
    }
    public function adminAttendanceList(){
        if(auth()->user()->hasPermission('admin attendance list')){
            $attendances = Attendance::latest()->paginate(30);
            return view('admin.attendance.index',compact('attendances'));
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
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
        if(auth()->user()->hasPermission('admin attendance report')){
            if ($request->year){
                // Get the filter parameters
                $year = $request->input('year');
                $month = $request->input('month');
                $day = $request->input('day', null);

                // Fetch all users with attendances for the specified month (and day if provided)
                $users = User::whereNotIn('id',[1])->with(['attendances' => function ($query) use ($year, $month, $day) {
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
                $currentMonth = Carbon::now()->month;
                $currentYear = Carbon::now()->year;
                $users = User::whereNotIn('id',[1])->with(['attendances' => function ($query) use ($currentMonth, $currentYear) {
                    $query->whereMonth('clock_in', $currentMonth)
                        ->whereYear('clock_in', $currentYear);
                }])->get();

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
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function getEvents()
    {
        $attendances = Attendance::where('user_id',auth()->user()->id)->get();

        $events = $attendances->map(function($attendance) {
            $clock_in = Carbon::parse($attendance->clock_in)->format('H:m');
            $clock_out = Carbon::parse($attendance->clock_out)->format('H:m');
            return [
                'title' => "In: $clock_in,Out: $clock_out",
                'start' => $attendance->clock_in_date . 'T' . $clock_in,
                'end' => $attendance->clock_in_date . 'T' . $clock_out,
            ];
        });

        return response()->json($events);
    }
    public function exportAttendance(Request $request)
    {
        if(auth()->user()->hasPermission('admin attendance report export')){
            $day = $request->input('day',null);
            $year = $request->input('year');
            $month = $request->input('month');
            $fileName = "attendance_report_{$year}_{$month}.xlsx";
            return Excel::download(new AttendanceExport($year, $month,$day), $fileName);
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function details(){
        $users = User::orderBy('name','asc')->where('status',1)->whereNotIn('id',[1])->get();
        return view('admin.attendance.details.month',compact('users'));
    }
    public function attendanceMonthly(Request $request){
        if(auth()->user()->hasPermission('admin attendance month details')){
            try {
            $validate = Validator::make($request->all(),[
                'user_id' => 'required',
                'month' => 'required',
                'year' => 'required',
            ]);
            if ($validate->fails()){
                toastr()->error($validate->messages());
                return back();
            }
            $user_id = $request->input('user_id');
            $month = $request->input('month', Carbon::now()->month);
            $year = $request->input('year');
            $daysInaMonth = Carbon::create($year, $month, 1)->daysInMonth;
            $startDate = Carbon::create($year, $month, 1);
            $endDate = $startDate->copy()->endOfMonth();
            $allDates = [];
            for ($date = $startDate; $date <= $endDate; $date->addDay()) {
                $allDates[] = $date->toDateString(); // Store the dates in an array
            }
            for ($day = 1; $day <= $daysInaMonth; $day++) {
                $attendancesForDay = Attendance::with('user')->where(function($query) use ($user_id, $year, $month, $day) {
                    $query->when($user_id, function($q) use ($user_id) {
                        $q->where('user_id', $user_id);
                    })->when($year, function($q) use ($year) {
                        $q->whereYear('clock_in', $year);
                    })->when($month, function($q) use ($month) {
                        $q->whereMonth('clock_in', $month);
                    });
                })->get()->groupBy(function ($item) {
                    return \Carbon\Carbon::parse($item->clock_in)->toDateString();
                });

                $attendanceData = collect($allDates)->mapWithKeys(function ($date) use ($attendancesForDay) {
                    return [$date => $attendancesForDay->get($date, collect())];
                });
            }
            $user = User::find($user_id);
            $present = count($attendancesForDay);
            $lateCount = [];
            foreach ($attendancesForDay as $attendance){
                foreach ($attendance as $att){
                    if (!in_array(\Carbon\Carbon::parse($att->clock_in)->format('y-m-d'),$lateCount)){
                        if ( \Carbon\Carbon::parse($att->clock_in)->format('H:i:s') > '09:15:00' ){
                            array_push($lateCount,\Carbon\Carbon::parse($att->clock_in)->format('y-m-d'));
                        }
                    }
                }
            }
            $workingDaysRecord = WorkingDay::where('year', $year)->where('month', $month)->first();
            /* start holiday */
            $holidays = Holiday::when($month, function($q) use ($month) {
                $q->whereMonth('date_from', $month);
            })->when($month, function($q) use ($month) {
                $q->whereMonth('date_to', $month);
            })->when($year, function($q) use ($year) {
                $q->whereYear('date_from', $year);
            })->when($month, function($q) use ($year) {
                $q->whereYear('date_to', $year);
            })->pluck('dates')->toArray();
            $holidayDates = [];
            if ($holidays){
                foreach ($holidays as $holiday){
                    foreach (json_decode($holiday) as $h){
                        if (!in_array($h,$holidayDates)){
                            array_push($holidayDates,$h);
                        }
                    }
                }
            }

            /* end Holiday */
            $leaves = Leave::where('user_id',$user->id)->when($month, function($q) use ($month) {
                $q->whereMonth('start_date', $month);
            })->when($year, function($q) use ($year) {
                $q->whereYear('start_date', $year);
            })->whereIn('leave_type',['sick','casual'])->where('status',1)->pluck('dates')->toArray();
            $leaveDates = [];
            if ($leaves){
                foreach ($leaves as $leave){
                    foreach (json_decode($leave) as $lev){
                        if (!in_array($lev,$leaveDates)){
                            array_push($leaveDates,$lev);
                        }
                    }
                }
            }
            return view('admin.attendance.details.month-wise-attendance', compact('attendanceData','holidayDates','workingDaysRecord','present', 'lateCount','leaveDates','year', 'month','user'));
            }
            catch (Exception $e){
                toastr()->error($e->getMessage());
                return back();
            }
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function attendanceMonthlyDownload(Request $request){
        if(auth()->user()->hasPermission('admin attendance details download')){
            try {
            $validate = Validator::make($request->all(),[
                'user_id' => 'required',
                'month' => 'required',
                'year' => 'required',
            ]);
            if ($validate->fails()){
                toastr()->error($validate->messages());
                return back();
            }
            $user_id = $request->input('user_id');
            $month = $request->input('month', Carbon::now()->month);
            $year = $request->input('year');
            $daysInaMonth = Carbon::create($year, $month, 1)->daysInMonth;
            $startDate = Carbon::create($year, $month, 1);
            $endDate = $startDate->copy()->endOfMonth();
            $allDates = [];
            for ($date = $startDate; $date <= $endDate; $date->addDay()) {
                $allDates[] = $date->toDateString(); // Store the dates in an array
            }
            for ($day = 1; $day <= $daysInaMonth; $day++) {
                $attendancesForDay = Attendance::with('user')->where(function($query) use ($user_id, $year, $month, $day) {
                    $query->when($user_id, function($q) use ($user_id) {
                        $q->where('user_id', $user_id);
                    })->when($year, function($q) use ($year) {
                        $q->whereYear('clock_in', $year);
                    })->when($month, function($q) use ($month) {
                        $q->whereMonth('clock_in', $month);
                    });
                })->get()->groupBy(function ($item) {
                    return \Carbon\Carbon::parse($item->clock_in)->toDateString();
                });

                $attendanceData = collect($allDates)->mapWithKeys(function ($date) use ($attendancesForDay) {
                    return [$date => $attendancesForDay->get($date, collect())];
                });
            }
            $user = User::find($user_id);
            $present = count($attendancesForDay);
            $lateCount = [];
            foreach ($attendancesForDay as $attendance){
                foreach ($attendance as $att){
                    if (!in_array(\Carbon\Carbon::parse($att->clock_in)->format('y-m-d'),$lateCount)){
                        if ( \Carbon\Carbon::parse($att->clock_in)->format('H:i:s') > '09:15:00' ){
                            array_push($lateCount,\Carbon\Carbon::parse($att->clock_in)->format('y-m-d'));
                        }
                    }
                }
            }
            $workingDaysRecord = WorkingDay::where('year', $year)->where('month', $month)->first();
            /* start holiday */
            $holidays = Holiday::when($month, function($q) use ($month) {
                $q->whereMonth('date_from', $month);
            })->when($month, function($q) use ($month) {
                $q->whereMonth('date_to', $month);
            })->when($year, function($q) use ($year) {
                $q->whereYear('date_from', $year);
            })->when($month, function($q) use ($year) {
                $q->whereYear('date_to', $year);
            })->pluck('dates')->toArray();
            $holidayDates = [];
            if ($holidays){
                foreach ($holidays as $holiday){
                    foreach (json_decode($holiday) as $h){
                        if (!in_array($h,$holidayDates)){
                            array_push($holidayDates,$h);
                        }
                    }
                }
            }

            /* end Holiday */
            $leaves = Leave::where('user_id',$user->id)->when($month, function($q) use ($month) {
                $q->whereMonth('start_date', $month);
            })->when($year, function($q) use ($year) {
                $q->whereYear('start_date', $year);
            })->whereIn('leave_type',['sick','casual'])->where('status',1)->pluck('dates')->toArray();
            $leaveDates = [];
            if ($leaves){
                foreach ($leaves as $leave){
                    foreach (json_decode($leave) as $lev){
                        if (!in_array($lev,$leaveDates)){
                            array_push($leaveDates,$lev);
                        }
                    }
                }
            }
//            return view('admin.attendance.details.month-wise-attendance-download', compact('attendanceData','holidayDates','workingDaysRecord','present', 'lateCount','leaveDates','year', 'month','user'));
            $pdf = Pdf::loadView('admin.attendance.details.month-wise-attendance-download', compact('attendanceData','holidayDates','workingDaysRecord','present', 'lateCount','leaveDates','year', 'month','user'));
            return $pdf->download('attendance_report.pdf');
            }
            catch (Exception $e){
                toastr()->error($e->getMessage());
                return back();
            }
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }

}
