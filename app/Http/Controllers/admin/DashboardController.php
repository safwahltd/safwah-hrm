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
            $year = Carbon::now()->year; // Store the current year for reuse

            // Query to retrieve all employee statistics in a single query
            $totalEmployees = UserInfos::where('status', 1)
                ->whereNotIn('user_id', [1])
                ->get(['user_id', 'gender']);

            // Categorize gender counts in one pass
            $totalEmployeeMale = $totalEmployees->where('gender', 1)->count();
            $totalEmployeeFeMale = $totalEmployees->where('gender', 2)->count();
            $totalEmployeeOther = $totalEmployees->whereNotIn('gender', [1, 2])->count();

            // Query attendance and calculate sums at once
            $atten = Attendance::where('year', $year)->get(['attend', 'late', 'absent']);
            $totalPresent = $atten->sum('attend');
            $totalLate = $atten->sum('late');
            $totalAbsent = $atten->sum('absent');
            // Calculate the leave applications for the current year
            $leaveApply = Leave::whereYear('created_at', $year)->count();

            // Retrieve holidays using simple pagination
            $holidays = Holiday::where('date_from', '>', Carbon::now())->latest()->simplePaginate(5);

            // Retrieve department, designation, and termination counts
            $departments = Department::where('soft_delete',0)->count();
            $designations = Designation::where('soft_delete',0)->count();
            $terminations = Termination::count();

            // Retrieve assets and calculate the total value
            $assets = Asset::where('status', 1)->get(['value']);
            $totalAssets = $assets->sum('value');

            // Retrieve user details excluding the one with id = 1
            $users = User::whereNotIn('id', [1])->where('status', 1)->get();

            // Calculate total salary payments
            $totalSalaryPayment = SalaryPayment::sum('paid_amount');

            // Return the data to the view
            return view('admin.dashboard.index', compact(
                'totalEmployees', 'totalEmployeeMale', 'totalEmployeeFeMale', 'totalEmployeeOther',
                'totalPresent', 'totalLate', 'totalAbsent', 'leaveApply', 'holidays', 'departments',
                'designations', 'terminations', 'assets', 'totalAssets', 'totalSalaryPayment', 'users'
            ));
        }
        else{
            $userId = auth()->user()->id;
            $year = Carbon::now()->year;

// Get the last 10 attendance records
            $attendances = Attendance::where('user_id', $userId)->latest()->take(10)->get();

// Get all attendance records for the current year
            $atten = Attendance::where('user_id', $userId)->where('year', $year)->get();
            $totalWorkingDay = $atten->sum('working_day');
            $totalAttend = $atten->sum('attend');
            $totalLate = $atten->sum('late');
            $totalAbsent = $atten->sum('absent');

// Get total holidays for the current year
            $totalHolidays = Holiday::whereYear('date_from', $year)->sum('total_day');

// Paginate holidays for the future
            $holidays = Holiday::where('date_from', '>', Carbon::now())->simplePaginate(10);

// Get pending leaves for the user for the current year
            $leavesPending = Leave::where('user_id', $userId)->whereYear('created_at', $year)->where('status', 0)->count();

// Retrieve leave balance for the user for the current year
            $leave = LeaveBalance::where('user_id', $userId)->where('year', $year)->first();

// Retrieve half-day leave balance with aggregation
            $leaveBalance = HalfDayLeaveBalance::where('user_id', $userId)->where('year', $year)
                ->selectRaw('SUM(half_day) as half_day_total, SUM(spent) as spent_total, SUM(`left`) as left_total')
                ->first();

// Retrieve asset details for the user
            $totalAssets = Asset::where('user_id', $userId)->get();

// Get all expenses for the user and filter by receipt type
            $expenses = Expense::where('user_id', $userId)
                ->where('soft_delete', 0)
                ->where('status', 1)
                ->whereYear('date', $year)
                ->get();

// Calculate totals for various expense receipt types in a single query
            $totalAdvanceAmount = $expenses->where('receipt_type', 'advance_money_receipt')->sum('amount');
            $totalMoneyAmount = $expenses->where('receipt_type', 'money_receipt')->sum('amount');
            $totalPayment = $expenses->where('receipt_type', 'money_receipt')->sum('payment');
            $totalDue = $expenses->where('receipt_type', 'money_receipt')->sum('due');

            // Pass the data to the view
            return view('admin.dashboard.index', compact(
                'leaveBalance', 'holidays', 'leave', 'attendances',
                'totalAttend', 'totalLate', 'totalAbsent', 'leavesPending',
                'totalWorkingDay', 'totalHolidays', 'totalAssets',
                'totalAdvanceAmount', 'totalMoneyAmount', 'totalPayment', 'totalDue'
            ));
        }
    }
    public function hrIndex(){
        if(auth()->user()->hasPermission('hr dashboard')){
            $year = Carbon::now()->year;
            // Query to retrieve all employee statistics in a single query
            $totalEmployees = UserInfos::where('status', 1)
                ->whereNotIn('user_id', [1])
                ->get(['user_id', 'gender']);

            // Categorize gender counts in one pass
            $totalEmployeeMale = $totalEmployees->where('gender', 1)->count();
            $totalEmployeeFeMale = $totalEmployees->where('gender', 2)->count();
            $totalEmployeeOther = $totalEmployees->whereNotIn('gender', [1, 2])->count();

            // Query attendance and calculate sums at once
            $atten = Attendance::where('year', $year)->get(['attend', 'late', 'absent']);
            $totalPresent = $atten->sum('attend');
            $totalLate = $atten->sum('late');
            $totalAbsent = $atten->sum('absent');
            // Calculate the leave applications for the current year
            $leaveApply = Leave::whereYear('created_at', $year)->count();

            // Retrieve holidays using simple pagination
            $holidays = Holiday::where('date_from', '>', Carbon::now())->simplePaginate(5);

            // Retrieve department, designation, and termination counts
            $departments = Department::where('soft_delete',0)->count();
            $designations = Designation::where('soft_delete',0)->count();
            $terminations = Termination::count();

            // Retrieve assets and calculate the total value
            $assets = Asset::where('status', 1)->get(['value']);
            $totalAssets = $assets->sum('value');

            // Retrieve user details excluding the one with id = 1
            $users = User::whereNotIn('id', [1])->where('status', 1)->get();

            // Calculate total salary payments
            $totalSalaryPayment = SalaryPayment::sum('paid_amount');

            // Return the data to the view
            return view('admin.dashboard.hr-dashboard', compact(
                'totalEmployees', 'totalEmployeeMale', 'totalEmployeeFeMale', 'totalEmployeeOther',
                'totalPresent', 'totalLate', 'totalAbsent', 'leaveApply', 'holidays', 'departments',
                'designations', 'terminations', 'assets', 'totalAssets', 'totalSalaryPayment', 'users'
            ));
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
    public function allFilter(Request $request){
        $userId = auth()->user()->id;
        $month = $request->month;
        $year = $request->year;

// Get all attendance records for the current year
        $atten = Attendance::where('user_id', $userId)->when($month, function ($q) use ($month) {
            return $q->where('month', $month);
        })->when($year, function ($q) use ($year) {
                return $q->where('year', $year);
        })->get();
        $totalWorkingDay = $atten->sum('working_day');
        $totalAttend = $atten->sum('attend');
        $totalLate = $atten->sum('late');
        $totalAbsent = $atten->sum('absent');

// Get total holidays for the current year
        $totalHolidays = Holiday::when($month, function ($q) use ($month) {
            return $q->whereMonth('date_from', $month);
        })->when($year, function ($q) use ($year) {
                return $q->whereYear('date_from', $year);
        })->sum('total_day');

// Get pending leaves for the user for the current year
        $leavesPending = Leave::where('user_id', $userId)->when($month, function ($q) use ($month) {
            return $q->whereMonth('created_at', $month);
        })->when($year, function ($q) use ($year) {
            return $q->whereYear('created_at', $year);
        })->where('status', 0)->count();

// Retrieve leave balance for the user for the current year
        $leave = LeaveBalance::where('user_id', $userId)->when($year, function ($q) use ($year) {
            return $q->where('year', $year);
        })->first();

// Retrieve half-day leave balance with aggregation
        $leaveBalance = HalfDayLeaveBalance::where('user_id', $userId)->when($month, function ($q) use ($month) {
                return $q->where('month', $month);
            })->when($year, function ($q) use ($year) {
                return $q->where('year', $year);
            })
            ->selectRaw('SUM(half_day) as half_day_total, SUM(spent) as spent_total, SUM(`left`) as left_total')
            ->first();

// Retrieve asset details for the user
        $totalAssets = Asset::where('user_id', $userId)->get();

// Get all expenses for the user and filter by receipt type
        $expenses = Expense::where('user_id', $userId)
            ->where('soft_delete', 0)
            ->where('status', 1)
            ->when($month, function ($q) use ($month) {
                return $q->whereMonth('date', $month);
            })->when($year, function ($q) use ($year) {
                return $q->whereYear('date', $year);
            })
            ->get();

// Calculate totals for various expense receipt types in a single query
        $totalAdvanceAmount = $expenses->where('receipt_type', 'advance_money_receipt')->sum('amount');
        $totalMoneyAmount = $expenses->where('receipt_type', 'money_receipt')->sum('amount');
        $totalPayment = $expenses->where('receipt_type', 'money_receipt')->sum('payment');
        $totalDue = $expenses->where('receipt_type', 'money_receipt')->sum('due');

        // Pass the data to the view
        $html = view('admin.dashboard.all-filter', compact(
            'leaveBalance', 'leave',
            'totalAttend', 'totalLate', 'totalAbsent', 'leavesPending',
            'totalWorkingDay', 'totalHolidays', 'totalAssets',
            'totalAdvanceAmount', 'totalMoneyAmount', 'totalPayment', 'totalDue'
        ))->render();
        return response()->json(['html' => $html]);
    }
}
