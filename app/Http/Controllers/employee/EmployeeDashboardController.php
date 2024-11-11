<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\Leave;
use App\Models\User;
use App\Models\WorkingDay;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EmployeeDashboardController extends Controller
{
    public function dashboard(){
        $currentMonth = Carbon::now()->month;
        $totalWorkingDay = WorkingDay::whereDate('year', Carbon::now()->year )->latest()->sum('working_day');
        $attendance = Attendance::where('user_id', auth()->user()->id)->whereDate('clock_in', now()->toDateString())->latest()->first();
        $attendances = Attendance::where('user_id',auth()->user()->id)->latest()->whereMonth('created_at',Carbon::now()->month)->paginate(7);
        $totalAttend = Attendance::where('user_id',auth()->user()->id)->whereYear('created_at',Carbon::now()->year)->count();
        $holidays = Holiday::where('date_from', '>', \Illuminate\Support\Carbon::now())->latest()->simplePaginate(5);
        $leavesPending = Leave::where('user_id',auth()->user()->id)->whereYear('created_at',Carbon::now()->year)->where('status',0)->count();
        return view('employee.dashboard.index',compact('attendance','holidays','attendances','totalAttend','leavesPending','totalWorkingDay'));
    }


}
