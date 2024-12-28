<?php

namespace App\Http\Controllers\admin;

use App\Events\EmployeeNotificationEvent;
use App\Events\GeneralNotificationEvent;
use App\Helpers\helpers;
use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Salary;
use App\Models\SalaryPayment;
use App\Models\SalarySetting;
use App\Models\Termination;
use App\Models\User;
use App\Models\WorkingDay;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class SalaryPaymentController extends Controller
{
    public function index(Request $request)
    {
        if(auth()->user()->hasPermission('admin salary payment index')){
            if ($request->all()) {
                $year = $request->input('year');
                $month = $request->input('month');
                $day = $request->input('day', null);

                $payments = SalaryPayment::with('user', 'salary')->where(function($query) use ($year, $month, $day) {
                    $query->when($year, function($q) use ($year) {
                        $q->whereYear('payment_date', $year);
                    })
                        ->when($month, function($q) use ($month) {
                            $q->whereMonth('payment_date', $month);
                        })
                        ->when($day, function($q) use ($day) {
                            $q->whereDay('payment_date', $day);
                        });
                })->orderBy('id','desc')->where('soft_delete',0)->paginate(100);
                $salaries = Salary::where('status', '1')->get();
                $salaryPaymentInputs = SalarySetting::where('type','payment')->get();
                $salaryDeductInputs = SalarySetting::where('type','deduct')->get();
                return view('admin.salary.payment', compact('payments','salaries','year', 'month','day','salaryPaymentInputs','salaryDeductInputs'));
            }
            else{
                $year = 0;
                $month = 0;
                $day = 0;
                $payments = SalaryPayment::with('user', 'salary')->orderBy('id','desc')->where('soft_delete',0)->paginate(100);
                $salaries = Salary::where('status', '1')->get();
                $salaryPaymentInputs = SalarySetting::where('type','payment')->get();
                $salaryDeductInputs = SalarySetting::where('type','deduct')->get();
                return view('admin.salary.payment', compact('payments','salaries','year', 'month','day','salaryPaymentInputs','salaryDeductInputs'));
            }
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function store(Request $request)
    {
//        return $request;
        if(auth()->user()->hasPermission('admin salary payment store')){
            try {
                $validate = Validator::make($request->all(), [
                    'salary_id' => 'required|exists:salaries,id',
                    'paid_amount' => 'required|numeric',
                    'payment_date' => 'required|date',
                    'payment_method' => 'nullable|string',
                    'payment_reference' => 'nullable|string',
                ]);
                if ($validate->fails()) {
                    toastr()->error($validate->messages());
                    return back();
                }
                $salary = Salary::find($request->salary_id);
                if ($request->paid_amount <= $request->netPay){
                    $payment = new SalaryPayment();
                    $payment->user_id = $salary->user_id;
                    $payment->salary_id = $request->salary_id;
                    $payment->paid_amount = $request->paid_amount;
                    $payment->payment_date = $request->payment_date;
                    $payment->payment_method = $request->payment_method;
                    $payment->payment_reference = $request->payment_reference;
                    $payment->log_id = auth()->user()->id;
                    $payment->saveOrFail();
                    $user = User::find($salary->user_id);
                    // Trigger event
                    event(new GeneralNotificationEvent(
                        'new_salary_paid',
                        $user->name.' ৳'.$payment->paid_amount.' Salary Of '.date('F', mktime(0, 0, 0, $salary->month, 1)).', '.$salary->year.' Is Paid',
                        [
                            'content' => $user->name.' ৳'.$payment->paid_amount.' Salary Of '.date('F', mktime(0, 0, 0, $salary->month, 1)).', '.$salary->year.' Is Paid',
                            'user_id' => auth()->user()->id,
                            'url' => route('admin.salary.payment.index'),
                        ]
                    ));
                    event(new EmployeeNotificationEvent(
                        '',
                        'Your Salary Of '.date('F', mktime(0, 0, 0, $salary->month, 1)).', '.$salary->year.' Is Paid.',
                        $payment->user_id,
                        [
                            'content' => 'Your Salary Of '.date('F', mktime(0, 0, 0, $salary->month, 1)).', '.$salary->year.' ৳ '.$payment->paid_amount.' Is Paid',
                            'user_id' => auth()->user()->id,
                            'url' => route('employee.salary.index'),
                        ]
                    ));
                }
                else{
                    toastr()->error('Paid Amount Can Not Greater Than Net Pay Amount.');
                    return back();
                }
                toastr()->success('Salary Payment Successfully.');
                return back();
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
    public function update(Request $request,$id)
    {
        if(auth()->user()->hasPermission('admin salary payment update')){
            try {
                $validate = Validator::make($request->all(), [
                    'paid_amount' => 'required|numeric',
                    'payment_date' => 'required|date',
                    'payment_method' => 'nullable|string',
                    'payment_reference' => 'nullable|string',
                ]);
                if ($validate->fails()) {
                    toastr()->error($validate->messages());
                    return back();
                }
                $user_id = Salary::find($request->salary_id);
                $payment = SalaryPayment::find($id);
                $payment->user_id = $payment->user_id;
                $payment->salary_id = $payment->salary_id;
                $payment->paid_amount = $request->paid_amount;
                $payment->payment_date = $request->payment_date;
                $payment->payment_method = $request->payment_method;
                $payment->payment_reference = $request->payment_reference;
                $payment->log_id = auth()->user()->id;
                $payment->saveOrFail();
                toastr()->success('Salary Payment Update Successfully.');
                return back();
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
    public function destroy($id)
    {
        if(auth()->user()->hasPermission('admin salary payment destroy')){
            $payment = SalaryPayment::find($id);
            $payment->soft_delete = 1;
            $payment->save();
            toastr()->success('Salary Payment Delete Successfully.');
            return back();
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function download($id){
        $paid = SalaryPayment::find($id);
        $salary = Salary::find($paid->salary_id);
        $totalAttendance = Attendance::where('user_id', $salary->user_id)
            ->where('month', $salary->month)
            ->where('year', $salary->year)
            ->first();

        /* payment dynamic column */
        $salaryPaymentInputs = SalarySetting::where('status',1)->where('type','payment')->get();
        $pay = 0 ;
        if($salary->payment != ''){
            $payment = json_decode($salary->payment);
            foreach($salaryPaymentInputs as $paymentInput){
                $pay = $pay + ($payment->{$paymentInput->name} ?? 0);
            }
        }
        /* deduct Dynamic Column */
        $salaryDeductInputs = SalarySetting::where('status',1)->where('type','deduct')->get();
        $deduct = 0 ;
        if($salary->deduct != ''){
            $deducts = json_decode($salary->deduct);
            /*dd(gettype($deduct->expense));*/
            foreach($salaryDeductInputs as $deductsInput){
                $deduct = $deduct + ($deducts->{$deductsInput->name} ?? 0);
            }
        }

//        $net = ($salary->basic_salary + $salary->house_rent + $salary->medical_allowance + $salary->conveyance_allowance + $salary->others + $salary->mobile_allowance + $salary->bonus + $pay) - ($salary->meal_deduction + $salary->income_tax + $salary->other_deduction + $salary->attendance_deduction + $deduct);
        $net = $paid->paid_amount;
        $netWords = helpers::numberToWords( $net );
//        return view('admin.salary.pdf',compact('salary','totalAttendance','net','netWords','workingDay','salaryPaymentInputs','salaryDeductInputs'));
        $pdf = Pdf::loadView('admin.salary.pdf', compact('salary','totalAttendance','net','netWords','salaryPaymentInputs','salaryDeductInputs'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->stream($salary->user->userInfo->employee_id.'_salary_slip.pdf');
    }
}
