<?php

namespace App\Http\Controllers\admin;

use App\Models\Expense;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Barryvdh\Snappy\Facades\SnappyPdf;
use function Brick\Math\sum;

class ExpenseController extends Controller
{

    /* Admin Start */
    public function index(){
        try {
            $expenses = Expense::latest()->where('soft_delete',0)->paginate(100);
            return view('admin.expense.index',compact('expenses'));
        }
        catch (\Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }

    }
    public function create(){
        try {
            $users = User::orderBy('name','asc')->get();
            $receipts = Expense::latest()->where('receipt_type','advance_money_receipt')->get();
            return view('admin.expense.add',compact('users','receipts'));
        }
        catch (\Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }
    }
    public function store(Request $request){
        try{
            if ($request->receipt_type == 'advance_money_receipt'){
                $validate = Validator::make($request->all(),[
                    'receipt_no' => 'required',
                    'receipt_type' => 'required',
                    'user_id' => 'required',
                    'date' => 'required',
                    'reason' => 'required',
                    'amount' => 'required',
                    'advance_payment_type' => 'required',
                ]);
                if($validate->fails()){
                    toastr()->error($validate->messages());
                    return back();
                }
            }
            elseif ($request->receipt_type == 'money_receipt'){
                $validate = Validator::make($request->all(),[
                    'receipt_no' => 'required',
                    'receipt_type' => 'required',
                    'user_id' => 'required',
                    'date' => 'required',
                    'reason' => 'required',
                    'money_payment_type' => 'required',
                    'amount' => 'required',
                    'payment' => 'required',
                    'due' => 'required',
                ]);
                if($validate->fails()){
                    toastr()->error($validate->messages());
                    return back();
                }
            }
            $receipt = Expense::latest()->first()->receipt_no;
            $receiptNo = $receipt + 1;

            $expense = new Expense();
            $expense->receipt_type = $request->receipt_type;
            $expense->receipt_no = $request->receipt_no;
            $expense->date = $request->date;
            $expense->user_id = $request->user_id;
            $expense->advance_payment_type = $request->advance_payment_type;
            $expense->money_payment_type = $request->money_payment_type;
            $expense->cheque_no = $request->cheque_no;
            $expense->cheque_bank = $request->cheque_bank;
            $expense->cheque_date = $request->cheque_date;
            $expense->mfs_sender_no = $request->mfs_sender_no;
            $expense->mfs_receiver_no = $request->mfs_receiver_no;
            $expense->mfs_transaction_no = $request->mfs_transaction_no;
            $expense->others = $request->others;
            $expense->adjusted_receipt_no = $request->adjusted_receipt_no;
            $expense->reason = $request->reason;
            $expense->amount = $request->amount;
            $expense->payment = $request->payment;
            $expense->due = $request->due;
            $expense->status = $request->status;
            if ($request->checked_by != null){
                $expense->checked_by = $request->checked_by;
                $expense->checked_date = Carbon::today()->toDateString();
            }
            if ($request->approved_by != null) {
                $expense->approved_by = $request->approved_by;
                $expense->approved_date = Carbon::today()->toDateString();
            }
            if ($request->received_by != null) {
                $expense->received_by = $request->received_by;
                $expense->received_date = Carbon::today()->toDateString();
            }
            $expense->save();
            toastr()->success('Expense Create Successfully.');
            return redirect()->route('admin.expense.index');

        }
        catch(\Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }

    }
    public function edit($id){
        $users = User::orderBy('name','asc')->get();
        $receipts = Expense::latest()->where('receipt_type','advance_money_receipt')->get();
        $expense = Expense::find($id);
        return view('admin.expense.edit',compact('users','receipts','expense'));
    }
    public function update(Request $request,$id){
        $expense = Expense::find($id);
        try{
            if ($expense->receipt_type == 'advance_money_receipt'){
                $validate = Validator::make($request->all(),[
                    'user_id' => 'required',
                    'date' => 'required',
                    'reason' => 'required',
                    'amount' => 'required',
                ]);
                if($validate->fails()){
                    toastr()->error($validate->messages());
                    return back();
                }
            }
            elseif ($expense->receipt_type == 'money_receipt'){
                $validate = Validator::make($request->all(),[
                    'user_id' => 'required',
                    'date' => 'required',
                    'reason' => 'required',
                    'amount' => 'required',
                    'payment' => 'required',
                    'due' => 'required',
                ]);
                if($validate->fails()){
                    toastr()->error($validate->messages());
                    return back();
                }
            }

            $expense->receipt_type = $expense->receipt_type;
            $expense->receipt_no = $request->receipt_no;
            $expense->date = $request->date;
            $expense->user_id = $request->user_id;
            $expense->advance_payment_type = $request->advance_payment_type;
            $expense->cheque_no = $request->cheque_no;
            $expense->cheque_bank = $request->cheque_bank;
            $expense->cheque_date = $request->cheque_date;
            $expense->mfs_sender_no = $request->mfs_sender_no;
            $expense->mfs_receiver_no = $request->mfs_receiver_no;
            $expense->mfs_transaction_no = $request->mfs_transaction_no;
            $expense->others = $request->others;
            $expense->adjusted_receipt_no = $request->adjusted_receipt_no;
            $expense->reason = $request->reason;
            $expense->amount = $request->amount;
            $expense->payment = $request->payment;
            $expense->due = $request->due;
            $expense->status = $request->status;
            if ($request->checked_by != null){
                $expense->checked_by = $request->checked_by;
                $expense->checked_date = Carbon::today()->toDateString();
            }
            if ($request->approved_by != null) {
                $expense->approved_by = $request->approved_by;
                $expense->approved_date = Carbon::today()->toDateString();
            }
            if ($request->received_by != null) {
                $expense->received_by = $request->received_by;
                $expense->received_date = Carbon::today()->toDateString();
            }
            $expense->save();
            toastr()->success('Expense Update Successfully.');
            return back();
        }
        catch(\Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }

    }
    public function destroy($id){
        try{
            $expense = Expense::find($id);
            $expense->soft_delete = 1;
            $expense->save();
            toastr()->success('Expense Delete Successfully.');
            return back();
        }
        catch(\Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }

    }
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
    public function printExpense($id){
        $expense = Expense::find($id);
        $netWords = $this->numberToWords($expense->amount);
        if ($expense->receipt_type == 'advance_money_receipt'){
            $pdf = Pdf::loadView('admin.expense.advance_print', compact('expense','netWords'));
            $pdf->setPaper('A4', 'portrait');
//            return view('admin.expense.advance_print',compact('expense','netWords'));
            return $pdf->stream($expense->receipt_no.'_advance_money_receipt.pdf');
        }
        elseif ($expense->receipt_type == 'money_receipt'){
            $pdf = Pdf::loadView('admin.expense.money_print', compact('expense','netWords'));
//            $pdf->setPaper('A4', 'portrait');
//            return view('admin.expense.money_print',compact('expense','netWords'));
            return $pdf->stream($expense->receipt_no.'_money_receipt.pdf');
        }

    }
    /* Admin End */

    /* Employee Start */
    public function indexAdvance(){

        $expenses = Expense::latest()->where('soft_delete',0)->where('user_id',auth()->user()->id)->paginate(100);
        $totalAdvanceAmount = $expenses->where('status',1)->where('receipt_type', 'advance_money_receipt')->sum('amount');
        $totalMoneyAmount = $expenses->where('status',1)->where('receipt_type', 'money_receipt')->sum('amount');
        $totalPayment = $expenses->where('status',1)->where('receipt_type', 'money_receipt')->sum('payment');
        $totalDue = $expenses->where('status',1)->where('receipt_type', 'money_receipt')->sum('due');

//        dd($totalAmount,$totalPayment,$totalDue);

        return view('employee.advance-money.index',compact('expenses','totalAdvanceAmount','totalMoneyAmount','totalPayment','totalDue'));
    }
    public function storeAdvance(Request $request){
        try{
            $validate = Validator::make($request->all(),[
                    'receipt_no' => 'required',
                    'receipt_type' => 'required',
                    'user_id' => 'required',
                    'date' => 'required',
                    'reason' => 'required',
                    'amount' => 'required',
                    'advance_payment_type' => 'required',
                ]);
            if($validate->fails()){
                    toastr()->error($validate->messages());
                    return back();
                }
            $expense = new Expense();
            $expense->receipt_type = $request->receipt_type;
            $expense->receipt_no = $request->receipt_no;
            $expense->date = $request->date;
            $expense->user_id = auth()->user()->id;
            $expense->advance_payment_type = $request->advance_payment_type;
            $expense->reason = $request->reason;
            $expense->amount = $request->amount;
            $expense->save();
            toastr()->success('Advance Money Receipt Create Successfully.');
            return redirect()->route('employee.advance.money.index');
        }
        catch(\Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }

    }
    public function updateAdvance(Request $request,$id){
        $expense = Expense::find($id);
        try{
            $validate = Validator::make($request->all(),[
                    'date' => 'required',
                    'reason' => 'required',
                    'amount' => 'required',
                ]);
            if($validate->fails()){
                    toastr()->error($validate->messages());
                    return back();
                }
            $expense->receipt_type = $expense->receipt_type;
            $expense->receipt_no = $request->receipt_no;
            $expense->date = $request->date;
            $expense->user_id = $expense->user_id;
            $expense->advance_payment_type = $request->advance_payment_type;
            $expense->reason = $request->reason;
            $expense->amount = $request->amount;
            $expense->save();
            toastr()->success('Advance Money Receipt Update Successfully.');
            return back();
        }
        catch(\Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }

    }
    public function destroyAdvance($id){
        try{
            $expense = Expense::find($id);
            $expense->soft_delete = 1;
            $expense->save();
            toastr()->success('Advance Money Receipt Delete Successfully.');
            return back();
        }
        catch(\Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }

    }
}

