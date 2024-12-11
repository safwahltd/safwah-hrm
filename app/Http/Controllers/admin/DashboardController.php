<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Attendance;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Expense;
use App\Models\HalfDayLeaveBalance;
use App\Models\Holiday;
use App\Models\Leave;
use App\Models\LeaveBalance;
use App\Models\Salary;
use App\Models\SalaryPayment;
use App\Models\Termination;
use App\Models\User;
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
            $atten = Attendance::where('year',Carbon::now()->year)->get();
            $totalPresent = $atten->sum('attend');
            $totalLate = $atten->sum('late');
            $totalAbsent = $atten->sum('absent');
            $absentEmployees = $totalEmployees->whereNotIn('user_id', $totalPresent)->count();
            $leaveApply = Leave::whereYear('created_at', Carbon::now()->year)->count();
            $holidays = Holiday::where('date_from', '>', \Illuminate\Support\Carbon::now())->latest()->simplePaginate(5);
            $departments = Department::count();
            $designations = Designation::count();
            $terminations = Termination::count();
            $assets = Asset::where('status',1)->get();
            $totalAssets = $assets->sum('value');
            $users = User::whereNotIn('id',[1])->where('status',1)->get();
            $totalSalaryPayment = SalaryPayment::sum('paid_amount');
            return view('admin.dashboard.index',compact(
                    'totalEmployees','totalEmployeeMale',
                    'totalEmployeeFeMale','totalEmployeeOther',
                    'totalPresent','totalLate','totalAbsent',
                    'leaveApply','holidays','departments',
                    'designations','terminations','assets','totalAssets','totalSalaryPayment','users')
            );
        }
        else{
            $attendances = Attendance::where('user_id',auth()->user()->id)->latest()->take(10)->get();
            $atten = Attendance::where('user_id',auth()->user()->id)->where('year',Carbon::now()->year)->get();
            $totalWorkingDay = $atten->sum('working_day');
            $totalAttend = $atten->sum('attend');
            $totalLate = $atten->sum('late');
            $totalAbsent = $atten->sum('absent');
            $totalHolidays = Holiday::whereYear('date_from',Carbon::now()->year)->sum('total_day');
            $holidays = Holiday::where('date_from', '>', \Illuminate\Support\Carbon::now())->latest()->simplePaginate(10);
            $leavesPending = Leave::where('user_id',auth()->user()->id)->whereYear('created_at',Carbon::now()->year)->where('status',0)->count();
            $leave = LeaveBalance::where('user_id',auth()->user()->id)->where('year',Carbon::now()->year)->first();
            $leaveBalance = HalfDayLeaveBalance::where('user_id',auth()->user()->id)->where('year',Carbon::now()->year)->select([
                                        \Illuminate\Support\Facades\DB::raw('SUM(half_day) as half_day_total'),
                                        \Illuminate\Support\Facades\DB::raw('SUM(spent) as spent_total'),
                                        \Illuminate\Support\Facades\DB::raw('SUM(`left`) as left_total'),
                                    ])->first();
            $totalAssets = $assets = Asset::where('user_id',auth()->user()->id)->get();
            $expenses = Expense::latest()->where('soft_delete',0)->where('user_id',auth()->user()->id)->get();
            $totalAdvanceAmount = $expenses->where('status',1)->where('receipt_type', 'advance_money_receipt')->sum('amount');
            $totalMoneyAmount = $expenses->where('status',1)->where('receipt_type', 'money_receipt')->sum('amount');
            $totalPayment = $expenses->where('status',1)->where('receipt_type', 'money_receipt')->sum('payment');
            $totalDue = $expenses->where('status',1)->where('receipt_type', 'money_receipt')->sum('due');

            return view('admin.dashboard.index',compact('leaveBalance','holidays','leave',
                'attendances','totalAttend','totalLate','totalAbsent','leavesPending','totalWorkingDay',
                'totalHolidays','totalAssets','totalAdvanceAmount','totalMoneyAmount','totalPayment','totalDue'));
        }
    }
    public function AttendanceFilter(Request $request){
        $month = $request->month;
        $user_id = $request->user_id;
        $year = $request->year;
        $attendances = Attendance::when($user_id, function ($q) use ($user_id) {
            return $q->where('user_id', $user_id);
        })->when($month, function ($q) use ($month) {
                return $q->where('month', $month);
        })->when($year, function ($q) use ($year) {
                return $q->where('year', $year);
        })->get();
        $totalAttend = $attendances->sum('attend');
        $totalLate = $attendances->sum('late');
        $totalAbsent = $attendances->sum('absent');
        $leaveApply = Leave::when($user_id, function ($q) use ($user_id) {
            return $q->where('user_id', $user_id);
        })->when($month, function ($q) use ($month) {
            return $q->whereMonth('created_at', $month);
        })->when($year, function ($q) use ($year) {
            return $q->whereYear('created_at', $year);
        })->count();
        $html = view('admin.dashboard.attendance', compact('totalAttend','totalLate','totalAbsent','leaveApply'))->render();
        return response()->json(['html' => $html]);
    }
}
