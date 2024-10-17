<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Salary;
use App\Models\SalaryPayment;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;

class SalaryController extends Controller
{
    public function index(Request $request)
    {
        if ($request->all()){
            $year = $request->input('year');
            $month = $request->input('month');
            $users = User::where('status',1)->whereNotIn('id',[1])->get();
            $salaries = Salary::with('user')->where(function($query) use ($year, $month) {
                $query->when($year, function($q) use ($year) {
                    $q->where('year', $year);
                })
                    ->when($month, function($q) use ($month) {
                        $q->where('month', $month);
                    });
            })->latest()->paginate(50);
            return view('admin.salary.index', compact('users', 'year', 'month', 'salaries'));
        }
        else{
            $year = 0;
            $month = 0;
            $users = User::where('status',1)->whereNotIn('id',[1])->get();
            $salaries = Salary::with('user')->latest()->paginate(20);
            return view('admin.salary.index', compact('users', 'year', 'month', 'salaries'));
        }

    }

    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'basic_salary' => 'required|numeric',
                'house_rent' => 'nullable|numeric',
                'medical_allowance' => 'nullable|numeric',
                'conveyance_allowance' => 'nullable|numeric',
                'others' => 'nullable|numeric',
                'mobile_allowance' => 'nullable|numeric',
                'bonus' => 'nullable|numeric',
                'meal_deduction' => 'nullable|numeric',
                'income_tax' => 'nullable|numeric',
                'other_deduction' => 'nullable|numeric',
                'attendance_deduction' => 'nullable|numeric',
                'month' => 'required|integer|between:1,12',
                'year' => 'required|integer|min:1900|max:'.date('Y'),
            ]);
            if ($validate->fails()) {
                toastr()->error($validate->messages());
                return back();
            }
            $checkSalary = Salary::where('user_id',$request->user_id)->where('month',$request->month)->where('year',$request->year)->first();
            if ($checkSalary){
                toastr()->error('Already Have This Salary.');
                return back();
            }
            $salary = new Salary();
            $salary->user_id = $request->user_id;
            $salary->month = $request->month;
            $salary->year = $request->year;
            $salary->basic_salary = $request->basic_salary;
            $salary->house_rent = $request->house_rent ? $request->house_rent:0;
            $salary->medical_allowance = $request->medical_allowance ? $request->medical_allowance:0;
            $salary->conveyance_allowance = $request->conveyance_allowance ? $request->conveyance_allowance:0;
            $salary->others = $request->others ? $request->others:0;
            $salary->mobile_allowance = $request->mobile_allowance ? $request->mobile_allowance:0;
            $salary->bonus = $request->bonus ? $request->bonus:0;
            $salary->meal_deduction = $request->meal_deduction ? $request->meal_deduction:0;
            $salary->income_tax = $request->income_tax ? $request->income_tax:0;
            $salary->other_deduction = $request->other_deduction ? $request->other_deduction:0;
            $salary->attendance_deduction = $request->attendance_deduction ? $request->attendance_deduction:0;
            $salary->status = $request->status;
            $salary->log_id = auth()->user()->id;
            $salary->saveOrFail();
            toastr()->success('Salary created successfully.');
            return back();
        }
        catch (\Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validate = Validator::make($request->all(), [
                'user_id' => 'required|exists:users,id',
                'basic_salary' => 'required|numeric',
                'house_rent' => 'nullable|numeric',
                'medical_allowance' => 'nullable|numeric',
                'conveyance_allowance' => 'nullable|numeric',
                'others' => 'nullable|numeric',
                'mobile_allowance' => 'nullable|numeric',
                'bonus' => 'nullable|numeric',
                'meal_deduction' => 'nullable|numeric',
                'income_tax' => 'nullable|numeric',
                'other_deduction' => 'nullable|numeric',
                'attendance_deduction' => 'nullable|numeric',
                'month' => 'required|integer|between:1,12',
                'year' => 'required|integer|min:1900|max:'.date('Y'),
            ]);
            if ($validate->fails()) {
                toastr()->error($validate->messages());
                return back();
            }

            $salary = Salary::find($id);
            $checkSalary = Salary::where('user_id',$request->user_id)->where('month',$request->month)->where('year',$request->year)->whereNotIn('id',[$salary->id])->first();
            if ($checkSalary){
                toastr()->error('Already Have This Salary.');
                return back();
            }
            $salary->user_id = $request->user_id;
            $salary->month = $request->month;
            $salary->year = $request->year;
            $salary->basic_salary = $request->basic_salary;
            $salary->house_rent = $request->house_rent ? $request->house_rent:0;
            $salary->medical_allowance = $request->medical_allowance ? $request->medical_allowance:0;
            $salary->conveyance_allowance = $request->conveyance_allowance ? $request->conveyance_allowance:0;
            $salary->others = $request->others ? $request->others:0;
            $salary->mobile_allowance = $request->mobile_allowance ? $request->mobile_allowance:0;
            $salary->bonus = $request->bonus ? $request->bonus:0;
            $salary->meal_deduction = $request->meal_deduction ? $request->meal_deduction:0;
            $salary->income_tax = $request->income_tax ? $request->income_tax:0;
            $salary->other_deduction = $request->other_deduction ? $request->other_deduction:0;
            $salary->attendance_deduction = $request->attendance_deduction ? $request->attendance_deduction:0;
            $salary->status = $request->status;
            $salary->log_id = auth()->user()->id;
            $salary->saveOrFail();
            toastr()->success('Salary updated successfully.');
            return back();
        }
        catch (\Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }
    }
    public function destroy($id)
    {
        $salary = Salary::find($id);
        $salary->delete();
        toastr()->success('Salary deleted successfully.');
        return back();
    }
    public function getSalaryDetails($id)
    {
        $salary = Salary::with('user')->find($id);
        return response()->json($salary);
    }
    public function getEmployees(Request $request)
    {
        $month = $request->input('month');
        $year = $request->input('year');
        $employees = Salary::where('month', $month)
            ->where('year', $year)
            ->with('user')
            ->with('userInfo')
            ->get();

        return response()->json($employees);
    }


    // Function to convert numbers to words
    function numberToWords($num) {
        $a = [
            '', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine', 'ten',
            'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'
        ];
        $b = ['', '', 'twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];
        $g = ['', 'thousand', 'million', 'billion', 'trillion'];

        if ($num < 0 || $num > 9999999999) {
            return 'number out of range';
        }

        if ($num == 0) return 'zero';
        if ($num < 20) return $a[$num];

        $thousands = floor($num / 1000);
        $Thousandfirst_character = substr($thousands, 0, 2);
        $num = $num - ($thousands*1000);
        $hundreds = floor($num / 100);
        $first_character = substr($hundreds, 0, 1);
        $remainder = $num % 100;

        $words = [];
        if ($thousands < 20) {
            $words[] = $a[$thousands] . ' thousand';
        }
        else{
            $Thousandfirst_character = substr($thousands, 0, 1);
            $Thousand2nd_character = substr($thousands, 1, 2);
            $words[] = $b[$Thousandfirst_character].$a[$Thousand2nd_character] . ' thousand';
        }

        if ($hundreds > 0) {
            $words[] = $a[$first_character] . ' hundred';
        }

        if ($remainder < 20) {
            $words[] = $a[$remainder];
        } else {
            $tens = floor($remainder / 10);
            $units = $remainder % 10;
            $words[] = $b[$tens];
            if ($units > 0) {
                $words[] = $a[$units];
            }
        }

        return implode(' ', $words);
    }

    public function download($id){
        $salary = Salary::find($id);
        /*$paymentDate = Carbon::parse($payment->payment_date);
        $previousMonthDate = $paymentDate->subMonth();
        $previous = Carbon::parse($payment->payment_date);
        $previousMonth = $previous->subMonth()->month;
        $currentYear = $previous->year;*/
        $totalAttendance = Attendance::where('user_id', $salary->user_id)
            ->whereMonth('clock_in', $salary->month)
            ->whereYear('clock_in', $salary->year)
            ->count();
        $net = ($salary->basic_salary + $salary->house_rent + $salary->medical_allowance + $salary->conveyance_allowance + $salary->others + $salary->mobile_allowance + $salary->bonus) - ($salary->meal_deduction + $salary->income_tax + $salary->other_deduction + $salary->attendance_deduction);
        $netWords = $this->numberToWords($net);

//        return view('admin.salary.pdf',compact('salary','totalAttendance','net','netWords'));
        $pdf = Pdf::loadView('admin.salary.pdf', compact('salary','totalAttendance','net','netWords'));
        return $pdf->download($salary->user->userInfo->employee_id.'_salary_slip.pdf');
    }
}
