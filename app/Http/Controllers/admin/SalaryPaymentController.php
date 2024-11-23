<?php

namespace App\Http\Controllers\admin;

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
                })->latest()->paginate(50);
                $salaries = Salary::where('status', '1')->get();
                $salaryPaymentInputs = SalarySetting::where('status',1)->where('type','payment')->get();
                $salaryDeductInputs = SalarySetting::where('status',1)->where('type','deduct')->get();
                return view('admin.salary.payment', compact('payments','salaries','year', 'month','day','salaryPaymentInputs','salaryDeductInputs'));
            }
            else{
                $year = 0;
                $month = 0;
                $day = 0;
                $payments = SalaryPayment::with('user', 'salary')->latest()->paginate(20);
                $salaries = Salary::where('status', '1')->get();
                $salaryPaymentInputs = SalarySetting::where('status',1)->where('type','payment')->get();
                $salaryDeductInputs = SalarySetting::where('status',1)->where('type','deduct')->get();
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
                $user_id = Salary::find($request->salary_id);
                $payment = new SalaryPayment();
                $payment->user_id = $user_id->user_id;
                $payment->salary_id = $request->salary_id;
                $payment->paid_amount = $request->paid_amount;
                $payment->payment_date = $request->payment_date;
                $payment->payment_method = $request->payment_method;
                $payment->payment_reference = $request->payment_reference;
                $payment->log_id = auth()->user()->id;
                $payment->saveOrFail();
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
            $payment->delete();
            toastr()->success('Salary Payment Delete Successfully.');
            return back();
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function download($id){
        $salary = Salary::find($id);
        $totalAttendance = collect(Attendance::where('user_id', $salary->user_id)
            ->whereMonth('clock_in', $salary->month)
            ->whereYear('clock_in', $salary->year)
            ->get());

        $totalAttendance = $totalAttendance->unique('clock_in_date')->count();
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

        $net = ($salary->basic_salary + $salary->house_rent + $salary->medical_allowance + $salary->conveyance_allowance + $salary->others + $salary->mobile_allowance + $salary->bonus + $pay) - ($salary->meal_deduction + $salary->income_tax + $salary->other_deduction + $salary->attendance_deduction + $deduct);
        $netWords = $this->numberToWords($net);
        $workingDay = WorkingDay::where('month',$salary->month)->where('year',$salary->year)->first()->working_day ?? 0;
//        return view('admin.salary.pdf',compact('salary','totalAttendance','net','netWords','workingDay','salaryPaymentInputs','salaryDeductInputs'));
        $pdf = Pdf::loadView('admin.salary.pdf', compact('salary','totalAttendance','net','netWords','workingDay','salaryPaymentInputs','salaryDeductInputs'));
        $pdf->setPaper('A4', 'portrait');
        return $pdf->download($salary->user->userInfo->employee_id.'_salary_slip.pdf');
    }
}
