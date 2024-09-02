<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Holiday;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class EmployeeDashboardController extends Controller
{
    public function dashboard(){
        $attendance = Attendance::where('user_id', auth()->user()->id)->whereDate('clock_in', now()->toDateString())->latest()->first();
        $holidays = Holiday::where('date_from', '>', \Illuminate\Support\Carbon::now())->latest()->simplePaginate(5);
        return view('employee.dashboard.index',compact('attendance','holidays'));
    }

}
