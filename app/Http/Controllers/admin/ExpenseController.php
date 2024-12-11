<?php

namespace App\Http\Controllers\admin;

use App\Events\EmployeeNotificationEvent;
use App\Events\GeneralNotificationEvent;
use App\Models\Expense;
use App\Models\Permission;
use App\Models\RolePermission;
use App\Models\User;
use App\Models\UserRole;
use App\Notifications\AdminNotification;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Validator;
use Barryvdh\Snappy\Facades\SnappyPdf;
use function Brick\Math\sum;

class ExpenseController extends Controller
{

    /* Admin Start */
    public function index(){
        if(auth()->user()->hasPermission('admin expense index')){
            try {
                $expenses = Expense::latest()->where('soft_delete',0)->paginate(100);
                return view('admin.expense.index',compact('expenses'));
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
    public function create(){
        if(auth()->user()->hasPermission('admin expense create')){
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
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function store(Request $request){
        if(auth()->user()->hasPermission('admin expense store')){
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

                // Step 1: Find the permission ID for 'admin leave requests'
                $permission = Permission::where('name', 'admin expense index')->first();
                if ($permission){
                    // Step 2: Find all role IDs that have this permission
                    $roleIds = RolePermission::where('permission_id', $permission->id)->pluck('role_id');
                    if ($roleIds){
                        // Step 3: Find all users with roles associated with these role IDs
                        $userIds = UserRole::whereIn('role_id', $roleIds)->pluck('user_id');
                        $f = [$userIds,[$expense->user_id]];
                        if ($userIds){
                            $employees = User::whereIn('id',Arr::flatten($f))->get();
                        }
                    }
                }

                if ($expense->receipt_type == 'advance_money_receipt'){
                    if ($expense->status == 0){
                        $status = 'New Advance Money Request Created.';
                    }
                    if ($expense->status == 1){
                        $status = 'New Advance Money Request Created & Approved.';
                    }
                    if ($expense->status == 2){
                        $status = 'New Advance Money Request Created & Rejected.';
                    }
                    // Trigger event
                    event(new GeneralNotificationEvent(
                        'advance_money_request',
                        $expense->advance_payment_type." ".$expense->amount,
                        [
                            'content' => $expense->reason,
                            'user_id' => $expense->user_id,
                            'url' => route('admin.expense.index'),
                        ]
                    ));
                    // Trigger event
                    foreach ($employees as $employee) {
                        event(new EmployeeNotificationEvent(
                            '',
                            $status,
                            $employee->id,
                            [
                                'content' => $expense->reason,
                                'user_id' => auth()->user()->id,
                                'url' => $employee->id == $expense->user_id ? route('employee.advance.money.index') : route('admin.expense.index'),
                            ]
                        ));
                    }


                }
                elseif ($expense->receipt_type == 'money_receipt'){
                    if ($expense->status == 0){
                        $status = 'New Money Receipt Created.';
                    }
                    if ($expense->status == 1){
                        $status = 'New Money Receipt Created & Approved.';
                    }
                    if ($expense->status == 2){
                        $status = 'New Money Receipt Created & Rejected.';
                    }

                    // Trigger event
                    event(new GeneralNotificationEvent(
                        'money_receipt',
                        $expense->advance_payment_type." ".$expense->amount,
                        [
                            'content' => $expense->reason,
                            'user_id' => $expense->user_id,
                            'url' => route('admin.expense.index'),
                        ]
                    ));
                    // Trigger event
                    foreach ($employees as $employee) {
                        event(new EmployeeNotificationEvent(
                            '',
                            $status,
                            $employee->id,
                            [
                                'content' => $expense->reason,
                                'user_id' => auth()->user()->id,
                                'url' => $employee->id == $expense->user_id ? route('employee.advance.money.index') : route('admin.expense.index'),
                            ]
                        ));
                    }
                }
                toastr()->success('Expense Create Successfully.');
                return redirect()->route('admin.expense.index');

            }
            catch(\Exception $e){
                toastr()->error($e->getMessage());
                return back();
            }
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function edit($id){
        if(auth()->user()->hasPermission('admin expense edit')){
            try {
                $users = User::orderBy('name','asc')->get();
                $receipts = Expense::latest()->where('receipt_type','advance_money_receipt')->get();
                $expense = Expense::find($id);
                return view('admin.expense.edit',compact('users','receipts','expense'));
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
    public function update(Request $request,$id){
        if(auth()->user()->hasPermission('admin expense update')){
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

                if ($expense->receipt_type == 'advance_money_receipt'){
                    if ($expense->status == 1){
                        $status = 'Your Advance Money Request Approved.';
                    }
                    if ($expense->status == 2){
                        $status = 'Your Advance Money Request Rejected.';
                    }
                    event(new EmployeeNotificationEvent(
                        '',
                        $status,
                        $expense->user_id,
                        [
                            'content' => $expense->reason,
                            'user_id' => auth()->user()->id,
                            'url' => route('employee.advance.money.index'),
                        ]
                    ));
                }
                elseif ($expense->receipt_type == 'money_receipt'){
                    if ($expense->status == 1){
                        $status = 'Your Money Receipt Approved.';
                    }
                    if ($expense->status == 2){
                        $status = 'Your Money Receipt Rejected.';
                    }
                    event(new EmployeeNotificationEvent(
                        '',
                        $status,
                        $expense->user_id,
                        [
                            'content' => $expense->reason,
                            'user_id' => auth()->user()->id,
                            'url' => route('employee.advance.money.index'),
                        ]
                    ));
                }
                toastr()->success('Expense Update Successfully.');
                return back();
            }
            catch(\Exception $e){
                toastr()->error($e->getMessage());
                return back();
            }
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }


    }
    public function destroy($id){
        if(auth()->user()->hasPermission('admin expense destroy')){
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
        else{
            toastr()->error('Permission Denied');
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
        if(auth()->user()->hasPermission('admin expense download')){
            try {
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
    /* Admin End */

    /* Employee Start */
    public function indexAdvance(){
        if(auth()->user()->hasPermission('employee advance money index')){
            try{
                $expenses = Expense::latest()->where('soft_delete',0)->where('user_id',auth()->user()->id)->get();
                $totalAdvanceAmount = $expenses->where('status',1)->where('receipt_type', 'advance_money_receipt')->sum('amount');
                $totalMoneyAmount = $expenses->where('status',1)->where('receipt_type', 'money_receipt')->sum('amount');
                $totalPayment = $expenses->where('status',1)->where('receipt_type', 'money_receipt')->sum('payment');
                $totalDue = $expenses->where('status',1)->where('receipt_type', 'money_receipt')->sum('due');
                return view('employee.advance-money.index',compact('expenses','totalAdvanceAmount','totalMoneyAmount','totalPayment','totalDue'));
            }
            catch(\Exception $e){
                toastr()->error($e->getMessage());
                return back();
            }
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function storeAdvance(Request $request){
        if(auth()->user()->hasPermission('employee advance money store')){
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
                // Step 1: Find the permission ID for 'admin leave requests'
                $permission = Permission::where('name', 'admin expense index')->first();
                if ($permission){
                    // Step 2: Find all role IDs that have this permission
                    $roleIds = RolePermission::where('permission_id', $permission->id)->pluck('role_id');
                    if ($roleIds){
                        // Step 3: Find all users with roles associated with these role IDs
                        $userIds = UserRole::whereIn('role_id', $roleIds)->pluck('user_id');
                        if ($userIds){
                            $employees = User::whereIn('id', $userIds)->get();
                        }
                    }
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

                // Trigger event
                event(new GeneralNotificationEvent(
                    'advance_money_request',
                    $expense->advance_payment_type." ".$expense->amount,
                    [
                        'content' => $expense->reason,
                        'user_id' => $expense->user_id,
                        'url' => route('admin.expense.index'),
                    ]
                ));
                // Trigger event
                foreach ($employees as $employee) {
                    event(new EmployeeNotificationEvent(
                        'advance_money_request',
                        $expense->advance_payment_type." ".$expense->amount,
                        $employee->id,
                        [
                            'content' => $expense->reason,
                            'user_id' => $expense->user_id,
                            'url' => route('admin.expense.index'),
                        ]
                    ));
                }

                toastr()->success('Advance Money Receipt Create Successfully.');
                return redirect()->route('employee.advance.money.index');
            }
            catch(\Exception $e){
                toastr()->error($e->getMessage());
                return back();
            }
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }


    }
    public function updateAdvance(Request $request,$id){
        if(auth()->user()->hasPermission('employee advance money update')){
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
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function destroyAdvance($id){
        if(auth()->user()->hasPermission('employee advance money destroy')){
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
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
}

