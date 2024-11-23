<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\Designation;
use App\Models\HalfDayLeaveBalance;
use App\Models\Holiday;
use App\Models\Leave;
use App\Models\LeaveBalance;
use App\Models\Termination;
use App\Models\UserInfos;
use App\Models\WorkingDay;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    public function index(){
        if (auth()->user()->role == 'admin'){
            $totalEmployees = UserInfos::where('status',1)->whereNotIn('user_id',[1])->get('user_id');
            $totalEmployeeMale = UserInfos::where('status',1)->whereNotIn('user_id',[1])->where('gender',1)->count();
            $totalEmployeeFeMale = UserInfos::where('status',1)->whereNotIn('user_id',[1])->where('gender',2)->count();
            $totalEmployeeOther = UserInfos::where('status',1)->whereNotIn('user_id',[1])->whereNotIn('gender',[1,2])->count();
            $totalPresent = Attendance::whereDate('clock_in', today())->pluck('user_id');
            $absentEmployees = $totalEmployees->whereNotIn('user_id', $totalPresent)->count();
            $totalLateAttend = Attendance::whereDate('clock_in', today())->where('clock_in', '>', today()->setTime(9, 15))->count();
            $leaveApply = Leave::whereDate('created_at', today())->count();
            $holidays = Holiday::where('date_from', '>', \Illuminate\Support\Carbon::now())->latest()->simplePaginate(5);
            $departments = Department::count();
            $designations = Designation::count();
            $terminations = Termination::count();
            $assets = Asset::count();
            return view('admin.dashboard.index',compact(
                    'totalEmployees','totalEmployeeMale',
                    'totalEmployeeFeMale','totalEmployeeOther',
                    'totalPresent','totalLateAttend','absentEmployees',
                    'leaveApply','holidays','departments',
                    'designations','terminations','assets')
            );
        }
        else{
            $currentMonth = Carbon::now()->month;
            $totalWorkingDay = WorkingDay::whereDate('year', Carbon::now()->year )->latest()->sum('working_day');
            $attendance = Attendance::where('user_id', auth()->user()->id)->whereDate('clock_in', now()->toDateString())->latest()->first();
            $attendances = Attendance::where('user_id',auth()->user()->id)->latest()->whereMonth('created_at',Carbon::now()->month)->paginate(7);
            $totalAttend = Attendance::where('user_id',auth()->user()->id)->whereYear('created_at',Carbon::now()->year)->count();
            $totalHolidays = Holiday::whereYear('date_from',Carbon::now()->year)->sum('total_day');
            $holidays = Holiday::where('date_from', '>', \Illuminate\Support\Carbon::now())->latest()->simplePaginate(5);
            $leavesPending = Leave::where('user_id',auth()->user()->id)->whereYear('created_at',Carbon::now()->year)->where('status',0)->count();
            $leave = LeaveBalance::where('user_id',auth()->user()->id)->where('year',Carbon::now()->year)->first();
            $leaveBalance = HalfDayLeaveBalance::where('user_id',auth()->user()->id)->where('year',Carbon::now()->year)->select([
                                        \Illuminate\Support\Facades\DB::raw('SUM(half_day) as half_day_total'),
                                        \Illuminate\Support\Facades\DB::raw('SUM(spent) as spent_total'),
                                        \Illuminate\Support\Facades\DB::raw('SUM(`left`) as left_total'),
                                    ])->first();

            return view('admin.dashboard.index',compact('attendance','leaveBalance','holidays','leave','attendances','totalAttend','leavesPending','totalWorkingDay','totalHolidays'));
        }
    }
}
