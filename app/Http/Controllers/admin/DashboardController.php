<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Holiday;
use App\Models\Leave;
use App\Models\Termination;
use App\Models\UserInfos;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(){
        $totalEmployees = UserInfos::get('user_id');
        $totalEmployeeMale = UserInfos::where('gender',1)->count();
        $totalEmployeeFeMale = UserInfos::where('gender',2)->count();
        $totalEmployeeOther = UserInfos::where('gender',3)->count();
        $totalPresent = Attendance::whereDate('clock_in', today())->pluck('user_id');
        $absentEmployees = $totalEmployees->whereNotIn('user_id', $totalPresent)->count();
        $totalLateAttend = Attendance::whereDate('clock_in', today())->where('clock_in', '>', today()->setTime(9, 15))->count();
        $leaveApply = Leave::where('status',1)->count();
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
}
