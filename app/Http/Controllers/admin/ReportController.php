<?php

namespace App\Http\Controllers\admin;

use App\Exports\AttendanceExport;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Attendance;
use App\Models\Expense;
use App\Models\Holiday;
use App\Models\Leave;
use App\Models\Notice;
use App\Models\OfficeExpense;
use App\Models\Salary;
use App\Models\SalaryPayment;
use App\Models\SalarySetting;
use App\Models\Termination;
use App\Models\User;
use App\Models\WorkingDay;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use function PHPUnit\Framework\dataSetAsStringWithData;

class ReportController extends Controller
{
    public function daily(Request $request){
        if(auth()->user()->hasPermission('admin daily report')){
            return view('admin.report.daily.daily');
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function dailyReport(Request $request){
        if(auth()->user()->hasPermission('admin daily report')){
            $year = $request->input('year');
            $month = $request->input('month', Carbon::now()->month);
            $day = $request->input('day');
            $dayreport = $request->input('day');
            $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;
            $reportData = [];
            if ($day) {
                $currentDate = Carbon::create($year, $month, $day)->format('Y-m-d');
                $leaveReport = Leave::where(function($query) use ($year, $month, $day) {
                    $query->when($year, function($q) use ($year) {
                        $q->whereYear('created_at', $year);
                    })
                        ->when($month, function($q) use ($month) {
                            $q->whereMonth('created_at', $month);
                        })
                        ->when($day, function($q) use ($day) {
                            $q->whereDay('created_at', $day);
                        });
                })->count();
                $terminationReport = Termination::where(function($query) use ($year, $month, $day) {
                    $query->when($year, function($q) use ($year) {
                        $q->whereYear('created_at', $year);
                    })
                        ->when($month, function($q) use ($month) {
                            $q->whereMonth('created_at', $month);
                        })
                        ->when($day, function($q) use ($day) {
                            $q->whereDay('created_at', $day);
                        });
                })->count();
                $assetReport = Asset::where(function($query) use ($year, $month, $day) {
                    $query->when($year, function($q) use ($year) {
                        $q->whereYear('created_at', $year);
                    })
                        ->when($month, function($q) use ($month) {
                            $q->whereMonth('created_at', $month);
                        })
                        ->when($day, function($q) use ($day) {
                            $q->whereDay('created_at', $day);
                        });
                })->count();
                $salaryReport = SalaryPayment::where(function($query) use ($year, $month, $day) {
                    $query->when($year, function($q) use ($year) {
                        $q->whereYear('payment_date', $year);
                    })
                        ->when($month, function($q) use ($month) {
                            $q->whereMonth('payment_date', $month);
                        })
                        ->when($day, function($q) use ($day) {
                            $q->whereDay('payment_date', $day);
                        });
                })->count();
                $noticeReport = Notice::where(function($query) use ($year, $month, $day) {
                    $query->when($year, function($q) use ($year) {
                        $q->whereYear('created_at', $year);
                    })
                        ->when($month, function($q) use ($month) {
                            $q->whereMonth('created_at', $month);
                        })
                        ->when($day, function($q) use ($day) {
                            $q->whereDay('created_at', $day);
                        });
                })->count();
                $reportData[] = [
                    'date' => $currentDate,
                    'leave_count' => $leaveReport,
                    'termination_count' => $terminationReport,
                    'asset_count' => $assetReport,
                    'salary_count' => $salaryReport,
                    'notice_count' => $noticeReport,
                ];
            } else {
                // Loop through each day of the month if no specific day is given
                for ($day = 1; $day <= $daysInMonth; $day++) {
                    $currentDate = Carbon::create($year, $month, $day)->format('Y-m-d');
                    $leaveReport = Leave::where(function($query) use ($year, $month, $day) {
                        $query->when($year, function($q) use ($year) {
                            $q->whereYear('created_at', $year);
                        })
                            ->when($month, function($q) use ($month) {
                                $q->whereMonth('created_at', $month);
                            })
                            ->when($day, function($q) use ($day) {
                                $q->whereDay('created_at', $day);
                            });
                    })->count();
                    $terminationReport = Termination::where(function($query) use ($year, $month, $day) {
                        $query->when($year, function($q) use ($year) {
                            $q->whereYear('created_at', $year);
                        })
                            ->when($month, function($q) use ($month) {
                                $q->whereMonth('created_at', $month);
                            })
                            ->when($day, function($q) use ($day) {
                                $q->whereDay('created_at', $day);
                            });
                    })->count();
                    $assetReport = Asset::where(function($query) use ($year, $month, $day) {
                        $query->when($year, function($q) use ($year) {
                            $q->whereYear('created_at', $year);
                        })
                            ->when($month, function($q) use ($month) {
                                $q->whereMonth('created_at', $month);
                            })
                            ->when($day, function($q) use ($day) {
                                $q->whereDay('created_at', $day);
                            });
                    })->count();
                    $salaryReport = SalaryPayment::where(function($query) use ($year, $month, $day) {
                        $query->when($year, function($q) use ($year) {
                            $q->whereYear('payment_date', $year);
                        })
                            ->when($month, function($q) use ($month) {
                                $q->whereMonth('payment_date', $month);
                            })
                            ->when($day, function($q) use ($day) {
                                $q->whereDay('payment_date', $day);
                            });
                    })->count();
                    $noticeReport = Notice::where(function($query) use ($year, $month, $day) {
                        $query->when($year, function($q) use ($year) {
                            $q->whereYear('created_at', $year);
                        })
                            ->when($month, function($q) use ($month) {
                                $q->whereMonth('created_at', $month);
                            })
                            ->when($day, function($q) use ($day) {
                                $q->whereDay('created_at', $day);
                            });
                    })->count();
                    $reportData[] = [
                        'date' => $currentDate,
                        'leave_count' => $leaveReport,
                        'termination_count' => $terminationReport,
                        'asset_count' => $assetReport,
                        'salary_count' => $salaryReport,
                        'notice_count' => $noticeReport,
                    ];
                }
            }
            return view('admin.report.daily.daily-report', compact('reportData', 'year', 'month', 'dayreport'));

        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function dailyReportDownload(Request $request){
        if(auth()->user()->hasPermission('admin daily report')){
            $year = $request->input('year');
            $month = $request->input('month', Carbon::now()->month);
            $day = $request->input('day');
            $daysInMonth = Carbon::create($year, $month, 1)->daysInMonth;
            $reportData = [];
            if ($day) {
                $currentDate = Carbon::create($year, $month, $day)->format('Y-m-d');
                $leaveReport = Leave::where(function($query) use ($year, $month, $day) {
                    $query->when($year, function($q) use ($year) {
                        $q->whereYear('created_at', $year);
                    })->when($month, function($q) use ($month) {
                            $q->whereMonth('created_at', $month);
                    })->when($day, function($q) use ($day) {
                            $q->whereDay('created_at', $day);
                    });
                })->count();
                $terminationReport = Termination::where(function($query) use ($year, $month, $day) {
                    $query->when($year, function($q) use ($year) {
                        $q->whereYear('created_at', $year);
                    })
                        ->when($month, function($q) use ($month) {
                            $q->whereMonth('created_at', $month);
                        })
                        ->when($day, function($q) use ($day) {
                            $q->whereDay('created_at', $day);
                        });
                })->count();
                $assetReport = Asset::where(function($query) use ($year, $month, $day) {
                    $query->when($year, function($q) use ($year) {
                        $q->whereYear('created_at', $year);
                    })
                        ->when($month, function($q) use ($month) {
                            $q->whereMonth('created_at', $month);
                        })
                        ->when($day, function($q) use ($day) {
                            $q->whereDay('created_at', $day);
                        });
                })->count();
                $salaryReport = SalaryPayment::where(function($query) use ($year, $month, $day) {
                    $query->when($year, function($q) use ($year) {
                        $q->whereYear('created_at', $year);
                    })
                        ->when($month, function($q) use ($month) {
                            $q->whereMonth('created_at', $month);
                        })
                        ->when($day, function($q) use ($day) {
                            $q->whereDay('created_at', $day);
                        });
                })->count();
                $noticeReport = Notice::where(function($query) use ($year, $month, $day) {
                    $query->when($year, function($q) use ($year) {
                        $q->whereYear('created_at', $year);
                    })
                        ->when($month, function($q) use ($month) {
                            $q->whereMonth('created_at', $month);
                        })
                        ->when($day, function($q) use ($day) {
                            $q->whereDay('created_at', $day);
                        });
                })->count();
                $reportData[] = [
                    'date' => $currentDate,
                    'attendance_count' => $attendancesForDay,
                    'leave_count' => $leaveReport,
                    'termination_count' => $terminationReport,
                    'asset_count' => $assetReport,
                    'salary_count' => $salaryReport,
                    'notice_count' => $noticeReport,
                ];
            } else {
                // Loop through each day of the month if no specific day is given
                for ($day = 1; $day <= $daysInMonth; $day++) {
                    $currentDate = Carbon::create($year, $month, $day)->format('Y-m-d');
                    $leaveReport = Leave::where(function($query) use ($year, $month, $day) {
                        $query->when($year, function($q) use ($year) {
                            $q->whereYear('created_at', $year);
                        })
                            ->when($month, function($q) use ($month) {
                                $q->whereMonth('created_at', $month);
                            })
                            ->when($day, function($q) use ($day) {
                                $q->whereDay('created_at', $day);
                            });
                    })->count();
                    $terminationReport = Termination::where(function($query) use ($year, $month, $day) {
                        $query->when($year, function($q) use ($year) {
                            $q->whereYear('created_at', $year);
                        })
                            ->when($month, function($q) use ($month) {
                                $q->whereMonth('created_at', $month);
                            })
                            ->when($day, function($q) use ($day) {
                                $q->whereDay('created_at', $day);
                            });
                    })->count();
                    $assetReport = Asset::where(function($query) use ($year, $month, $day) {
                        $query->when($year, function($q) use ($year) {
                            $q->whereYear('created_at', $year);
                        })
                            ->when($month, function($q) use ($month) {
                                $q->whereMonth('created_at', $month);
                            })
                            ->when($day, function($q) use ($day) {
                                $q->whereDay('created_at', $day);
                            });
                    })->count();
                    $salaryReport = SalaryPayment::where(function($query) use ($year, $month, $day) {
                        $query->when($year, function($q) use ($year) {
                            $q->whereYear('created_at', $year);
                        })
                            ->when($month, function($q) use ($month) {
                                $q->whereMonth('created_at', $month);
                            })
                            ->when($day, function($q) use ($day) {
                                $q->whereDay('created_at', $day);
                            });
                    })->count();
                    $noticeReport = Notice::where(function($query) use ($year, $month, $day) {
                        $query->when($year, function($q) use ($year) {
                            $q->whereYear('created_at', $year);
                        })
                            ->when($month, function($q) use ($month) {
                                $q->whereMonth('created_at', $month);
                            })
                            ->when($day, function($q) use ($day) {
                                $q->whereDay('created_at', $day);
                            });
                    })->count();
                    $reportData[] = [
                        'date' => $currentDate,
                        'attendance_count' => $attendancesForDay,
                        'leave_count' => $leaveReport,
                        'termination_count' => $terminationReport,
                        'asset_count' => $assetReport,
                        'salary_count' => $salaryReport,
                        'notice_count' => $noticeReport,
                    ];
                }
            }
            $pdf = Pdf::loadView('admin.report.daily.daily-report-download', compact('reportData', 'year', 'month', 'daysInMonth','day'));
            return $pdf->download('daily_report.pdf');
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function leave(){
        if(auth()->user()->hasPermission('admin leave report')){
            $users = User::whereNotIn('id',[1])->orderBy('name','asc')->get();
            return view('admin.report.leave.leave',compact('users'));
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function leaveReportShow(Request $request){
        if(auth()->user()->hasPermission('admin leave report show')) {
            $month = $request->month;
            $year = $request->year;
            $user_id = $request->user_id;
            $type = $request->leave_type;
            $leaves = Leave::with('user')
                ->when($month, function ($q) use ($month) {
                    return $q->whereMonth('start_date', $month);
                })
                ->when($year, function ($q) use ($year) {
                    return $q->whereYear('start_date', $year);
                })
                ->when($user_id, function ($q) use ($user_id) {
                    return $q->where('user_id', $user_id);
                })
                ->when($type, function ($q) use ($type) {
                    return $q->where('leave_type', $type);
                })
                ->get();
            $users = User::whereNotIn('id',[1])
                ->when($user_id, function ($q) use ($user_id) {
                    return $q->where('id', $user_id);
                })->get();
            return view('admin.report.leave.leave-report',compact('leaves','users','month','year','type','user_id'));
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function leaveReportDownload(Request $request){
        if(auth()->user()->hasPermission('admin download leave report')) {
            $month = $request->month;
            $year = $request->year;
            $user_id = $request->user_id;
            $type = $request->type;
            $leaves = Leave::with('user')
                ->when($month, function ($q) use ($month) {
                    return $q->whereMonth('start_date', $month);
                })
                ->when($year, function ($q) use ($year) {
                    return $q->whereYear('start_date', $year);
                })
                ->when($user_id, function ($q) use ($user_id) {
                    return $q->where('user_id', $user_id);
                })
                ->when($type, function ($q) use ($type) {
                    return $q->where('leave_type', $type);
                })
                ->get();
            $users = User::whereNotIn('id',[1])
                ->when($user_id, function ($q) use ($user_id) {
                    return $q->where('id', $user_id);
                })->get();
//            return view('admin.report.leave.leave-report-download', compact('leaves','users','month','year','type'));
            $pdf = Pdf::loadView('admin.report.leave.leave-report-download', compact('leaves','users','month','year','type'));
            return $pdf->download('leave_report.pdf');
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function salary(){
        if(auth()->user()->hasPermission('admin salary report')){
            return view('admin.report.salary.salary');
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function salaryReportShow(Request $request){
        if(auth()->user()->hasPermission('admin salary report show')){
            $months = $request->input('month');
            $mon = $request->input('month');
            $years = $request->input('year');
            $yr = $request->input('year');
            $salaries = Salary::with('user')
                ->when($months, function ($q) use ($months) {
                    return $q->where('month', $months);
                })
                ->when($years, function ($q) use ($years) {
                    return $q->where('year', $years);
                })->get();

            $salaryPaymentInputs = SalarySetting::where('type','payment')->get();
            $salaryDeductInputs = SalarySetting::where('type','deduct')->get();
            $monthlyReport = [];
            foreach ($salaries as $salary) {
                $effectiveMonth = date('F', mktime(0, 0, 0, $salary->month, 1));
                $effectiveYear = $salary->year;
                $pay = 0;
                if($salary->payment != ''){
                    $payment = json_decode($salary->payment);
                    foreach($salaryPaymentInputs as $paymentInput){
                        $pay = $pay + ($payment->{$paymentInput->name} ?? 0);
                    }
                }
                $deduct = 0;
                if($salary->deduct != ''){
                    $deducts = json_decode($salary->deduct);
                    foreach($salaryDeductInputs as $deductsInput){
                        $deduct = $deduct + ($deducts->{$deductsInput->name} ?? 0);
                    }
                }
                if (!isset($monthlyReport[$effectiveYear][$effectiveMonth])) {
                    $monthlyReport[$effectiveYear][$effectiveMonth] = [];
                }
                // Add the salary data for the employee
                $monthlyReport[$effectiveYear][$effectiveMonth][] = [
                    'employee_id' => $salary->user->userInfo->employee_id,
                    'employee_name' => $salary->user->name,
                    'employee_designation' => $salary->user->userInfo->designations->name,
                    'basic_salary' => $salary->basic_salary,
                    'house_rent' => $salary->house_rent,
                    'medical_allowance' => $salary->medical_allowance,
                    'conveyance_allowance' => $salary->conveyance_allowance,
                    'others' => $salary->others,
                    'mobile_allowance' => $salary->mobile_allowance,
                    'bonus' => $salary->bonus,
                    'meal_deduction' => $salary->meal_deduction,
                    'income_tax' => $salary->income_tax,
                    'other_deduction' => $salary->other_deduction,
                    'attendance_deduction' => $salary->attendance_deduction,
                    'month' => $salary->month,
                    'year' => $salary->year,
                    'pay' => $pay,
                    'deduct' => $deduct,
                    'total_salary' => $salary->basic_salary + $salary->house_rent + $salary->medical_allowance + $salary->conveyance_allowance + $salary->others + $salary->mobile_allowance + $salary->bonus ,
                ];
            }
            return view('admin.report.salary.salary-report',compact('monthlyReport','mon','yr'));
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function salaryReportDownload(Request $request){
        if(auth()->user()->hasPermission('admin download salary report')){
            $month = $request->input('month');
            $year = $request->input('year');
            $salaries = Salary::with('user')
                ->when($month, function ($q) use ($month) {
                    return $q->where('month', $month);
                })
                ->when($year, function ($q) use ($year) {
                    return $q->where('year', $year);
                })->get();
            $salaryPaymentInputs = SalarySetting::where('type','payment')->get();
            $salaryDeductInputs = SalarySetting::where('type','deduct')->get();
            $monthlyReport = [];
            foreach ($salaries as $salary) {
                $effectiveMonth = date('F', mktime(0, 0, 0, $salary->month, 1));
                $effectiveYear = $salary->year;
                $pay = 0;
                if($salary->payment != ''){
                    $payment = json_decode($salary->payment);
                    foreach($salaryPaymentInputs as $paymentInput){
                        $pay = $pay + ($payment->{$paymentInput->name} ?? 0);
                    }
                }
                $deduct = 0;
                if($salary->deduct != ''){
                    $deducts = json_decode($salary->deduct);
                    foreach($salaryDeductInputs as $deductsInput){
                        $deduct = $deduct + ($deducts->{$deductsInput->name} ?? 0);
                    }
                }
                if (!isset($monthlyReport[$effectiveYear][$effectiveMonth])) {
                    $monthlyReport[$effectiveYear][$effectiveMonth] = [];
                }
                // Add the salary data for the employee
                $monthlyReport[$effectiveYear][$effectiveMonth][] = [
                    'employee_id' => $salary->user->userInfo->employee_id,
                    'employee_name' => $salary->user->name,
                    'employee_designation' => $salary->user->userInfo->designations->name,
                    'basic_salary' => $salary->basic_salary,
                    'house_rent' => $salary->house_rent,
                    'medical_allowance' => $salary->medical_allowance,
                    'conveyance_allowance' => $salary->conveyance_allowance,
                    'others' => $salary->others,
                    'mobile_allowance' => $salary->mobile_allowance,
                    'bonus' => $salary->bonus,
                    'meal_deduction' => $salary->meal_deduction,
                    'income_tax' => $salary->income_tax,
                    'other_deduction' => $salary->other_deduction,
                    'attendance_deduction' => $salary->attendance_deduction,
                    'month' => $salary->month,
                    'year' => $salary->year,
                    'pay' => $pay,
                    'deduct' => $deduct,
                    'total_salary' => $salary->basic_salary + $salary->house_rent + $salary->medical_allowance + $salary->conveyance_allowance + $salary->others + $salary->mobile_allowance + $salary->bonus ,
                ];
            }
            $pdf = Pdf::loadView('admin.report.salary.salary-report-download', compact('monthlyReport'));
            return $pdf->download('salary_report.pdf');
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function asset(){
        if(auth()->user()->hasPermission('admin asset report')){
            $users = User::orderBy('name','asc')->where('status',1)->get();
            return view('admin.report.asset.asset',compact('users'));
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function assetReportShow(Request $request){
        if(auth()->user()->hasPermission('admin asset report show')){
            $user_id = $request->input('user_id');
            $status = $request->status;
            if ($status == 0){
                $assets = Asset::where('status',$status)->when($user_id, function ($q) use ($user_id) {
                    return $q->where('user_id', $user_id);
                })
                    ->get();
            }
            if ($status == 1){
                $assets = Asset::where('status',$status)->when($user_id, function ($q) use ($user_id) {
                    return $q->where('user_id', $user_id);
                })
                    ->get();
            }
            if ($status == ''){
                $assets = Asset::when($user_id, function ($q) use ($user_id) {
                    return $q->where('user_id', $user_id);
                })
                    ->when($status, function ($q) use ($status) {
                        return $q->where('status', $status);
                    })
                    ->get();
            }

            return view('admin.report.asset.asset-report',compact('assets','user_id','status'));
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function assetReportDownload(Request $request){
        if(auth()->user()->hasPermission('admin download asset report')){
            $user_id = $request->input('user_id');
            $status = $request->input('status');
            if ($status == 0){
                $assets = Asset::where('status',$status)->when($user_id, function ($q) use ($user_id) {
                    return $q->where('user_id', $user_id);
                })
                    ->get();
            }
            if ($status == 1){
                $assets = Asset::where('status',$status)->when($user_id, function ($q) use ($user_id) {
                    return $q->where('user_id', $user_id);
                })
                    ->get();
            }
            if ($status == ''){
                $assets = Asset::when($user_id, function ($q) use ($user_id) {
                    return $q->where('user_id', $user_id);
                })
                    ->when($status, function ($q) use ($status) {
                        return $q->where('status', $status);
                    })
                    ->get();
            }
            $pdf = Pdf::loadView('admin.report.asset.asset-report-download', compact('assets'));
            return $pdf->download('asset_report.pdf');
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function attendance(){
        if(auth()->user()->hasPermission('admin attendance report')){
            $users = User::orderBy('name','asc')->whereNotIn('id',[1])->get();
            return view('admin.report.attendance.attendance',compact('users'));
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function attendanceReportShow(Request $request){
        if(auth()->user()->hasPermission('admin attendance report show')){
            $mon = $request->month;
            $months = $request->input('month') ? [$request->input('month')] : range(1, 12);
            $year = $request->year;
            $user_id = $request->user_id;
            $reportData = [];
            foreach ($months as $month) {
                /* Attendance Count Query */
                $attendanceQuery = Attendance::when($user_id, function($q) use ($user_id) {
                    return $q->where('user_id', $user_id);
                })->where('year', $year)
                    ->where('month', $month);
                $attendanceData = $attendanceQuery->get()->groupBy('user_id');
                $monthData = [];
                foreach ($attendanceData as $userId => $attendanceRecords) {
                    $user = User::find($userId);

                    // Count presents and absents for this user
                    $totalWorkingDays = $attendanceRecords->sum('working_day');
                    $totalPresents = $attendanceRecords->sum('attend');
                    $total_late = $attendanceRecords->sum('late');
                    $totalAbsents = $attendanceRecords->sum('absent');
                    $totalLeave = Leave::where('user_id',$userId)->whereMonth('start_date',$month)->whereYear('start_date',$year)->whereNotIn('leave_type',['half_day'])->where('status',1)->sum('days_taken');
                    $monthData[] = [
                        'user_name' => $user->name,
                        'user_id' => $user->userInfo->employee_id,
                        'designation' => $user->userInfo->designations->name,
                        'total_presents' => $totalPresents,
                        'total_absents' => $totalAbsents,
                        'total_late' => $total_late,
                        'total_working_days' => $totalWorkingDays,
                        'totalLeave' => $totalLeave,
                    ];
                }
                $reportData[$month] = $monthData;
            }
            return view('admin.report.attendance.attendance-report',compact('reportData','mon','year','user_id'));
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function attendanceReportDownload(Request $request){
        if(auth()->user()->hasPermission('admin download attendance report')){
            $mon = $request->month;
            $months = $request->input('month') ? [$request->input('month')] : range(1, 12);
            $year = $request->year;
            $user_id = $request->user_id;
            $reportData = [];
            foreach ($months as $month) {
                /* Attendance Count Query */
                $attendanceQuery = Attendance::when($user_id, function($q) use ($user_id) {
                    return $q->where('user_id', $user_id);
                })->where('year', $year)
                    ->where('month', $month);
                $attendanceData = $attendanceQuery->get()->groupBy('user_id');
                $monthData = [];
                foreach ($attendanceData as $userId => $attendanceRecords) {
                    $user = User::find($userId);

                    // Count presents and absents for this user
                    $totalWorkingDays = $attendanceRecords->sum('working_day');
                    $totalPresents = $attendanceRecords->sum('attend');
                    $total_late = $attendanceRecords->sum('late');
                    $totalAbsents = $attendanceRecords->sum('absent');
                    $totalLeave = Leave::where('user_id',$userId)->whereMonth('start_date',$month)->whereYear('start_date',$year)->whereNotIn('leave_type',['half_day'])->where('status',1)->sum('days_taken');

                    $monthData[] = [
                        'user_name' => $user->name,
                        'user_id' => $user->userInfo->employee_id,
                        'designation' => $user->userInfo->designations->name,
                        'total_presents' => $totalPresents,
                        'total_absents' => $totalAbsents,
                        'total_late' => $total_late,
                        'total_working_days' => $totalWorkingDays,
                        'totalLeave' => $totalLeave,
                    ];
                }
                $reportData[$month] = $monthData;
            }
            $pdf = Pdf::loadView('admin.report.attendance.attendance-report-download', compact('reportData','mon','year'));
            if (!empty($request->month)){
                return $pdf->stream(date('F', mktime(0, 0, 0, $mon, 1)).'_'.$year.'_attendance_report.pdf');
            }
            else{
                return $pdf->stream($year.'_all_month_attendance_report.pdf');
            }
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function excelExportAttendanceReport(Request $request)
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
    public function expense(){
        if(auth()->user()->hasPermission('admin expense report')){
            $users = User::orderBy('name','asc')->get();
            return view('admin.report.expense.expense',compact('users'));
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function expenseReportShow(Request $request){
        if(auth()->user()->hasPermission('admin expense report show')){
            $start_date = $request->input('start_date') ?? Carbon::now()->toDateString();
            $end_date = $request->input('end_date') ?? Carbon::now()->toDateString();
            $user_id = $request->user_id;
            $receipt_type = $request->receipt_type;
            $expenses = Expense::where('status',1)->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                $query->whereBetween('date', [$start_date, $end_date]);
            })
                ->when($user_id, function ($query) use ($user_id) {
                    $query->where('user_id', $user_id);
                })
                ->when($receipt_type, function ($query) use ($receipt_type) {
                    $query->where('receipt_type', $receipt_type);
                })
                ->get();

            return view('admin.report.expense.expense-report-show',compact('expenses','start_date','end_date','user_id','receipt_type'));
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function expenseReportDownload(Request $request){
        if(auth()->user()->hasPermission('admin download expense report')){
            try {
                $start_date = $request->input('start_date');
                $end_date = $request->input('end_date');
                $user_id = $request->user_id;
                $receipt_type = $request->receipt_type;

                $expenses = Expense::when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                    $query->whereBetween('date', [$start_date, $end_date]);
                })
                    ->when($user_id, function ($query) use ($user_id) {
                        $query->where('user_id', $user_id);
                    })
                    ->when($receipt_type, function ($query) use ($receipt_type) {
                        $query->where('receipt_type', $receipt_type);
                    })
                    ->get();
                $pdf = Pdf::loadView('admin.report.expense.expense-report-download', compact('expenses','start_date','end_date','receipt_type'));
                $pdf = $pdf->setPaper('A4','portrait');
                return $pdf->stream('expense_report.pdf');
            }
            catch (\Exception $e){
                toastr()->error($e->getMessage());
                return back();
            }
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function officeExpense(){
        if(auth()->user()->hasPermission('admin office expense report')){
            return view('admin.report.office-expense.office-expense');
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function officeExpenseReportShow(Request $request){
        if(auth()->user()->hasPermission('admin expense office report show')){
            $start_date = $request->input('start_date') ?? Carbon::now()->toDateString();
            $end_date = $request->input('end_date') ?? Carbon::now()->toDateString();
            $expenses = OfficeExpense::where('status',1)->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                $query->whereBetween('date', [$start_date, $end_date]);
            })->orderBy('date','asc')->get();

            return view('admin.report.office-expense.office-expense-report-show',compact('expenses','start_date','end_date'));
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function officeExpenseReportDownload(Request $request){
        if(auth()->user()->hasPermission('admin download office expense report')){
            try {
                $start_date = $request->input('start_date');
                $end_date = $request->input('end_date');
                $expenses = OfficeExpense::where('status',1)->when($start_date && $end_date, function ($query) use ($start_date, $end_date) {
                    $query->whereBetween('date', [$start_date, $end_date]);
                })->orderBy('date','asc')->get();
                $pdf = Pdf::loadView('admin.report.office-expense.office-expense-report-download', compact('expenses','start_date','end_date'));
                $pdf = $pdf->setPaper('A4','portrait');
                return $pdf->stream('office_expense_report.pdf');
            }
            catch (\Exception $e){
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
