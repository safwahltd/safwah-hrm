<?php

namespace App\Http\Controllers\admin;

use App\Models\OfficeExpense;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class OfficeExpenseController extends Controller
{
    public function index(){
        if(auth()->user()->hasPermission('admin office expenses index')){
            try {
                $officeExpenses = OfficeExpense::where('soft_delete',0)->paginate(500);
                return view('admin.office-expense.index',compact('officeExpenses'));
            }
            catch (\Exception $exception){
                toastr()->error($exception->getMessage());
                return back();
            }

        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function store(Request $request){
        if(auth()->user()->hasPermission('admin office expenses store')){
            try{
                $validate = Validator::make($request->all(),[
                    'purpose' => 'required',
                    'date' => 'required',
                    'amount' => 'required',
                ]);
                if($validate->fails()){
                    toastr()->error($validate->messages());
                    return back();
                }
                $expense = new OfficeExpense();
                $expense->user_id = auth()->user()->id;
                $expense->purpose = $request->purpose;
                $expense->date = $request->date;
                $expense->amount = $request->amount;
                $expense->payment_type = $request->payment_type;
                $expense->remarks = $request->remarks;
                $expense->status = $request->status;
                $expense->save();
                toastr()->success('Office Expense Create Successfully.');
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
    public function update(Request $request,$id){
        if(auth()->user()->hasPermission('admin office expenses update')){
            try{
                $validate = Validator::make($request->all(),[
                    'purpose' => 'required',
                    'date' => 'required',
                    'amount' => 'required',
                ]);
                if($validate->fails()){
                    toastr()->error($validate->messages());
                    return back();
                }
                $expense = OfficeExpense::find($id);
                $expense->user_id = auth()->user()->id;
                $expense->purpose = $request->purpose;
                $expense->date = $request->date;
                $expense->amount = $request->amount;
                $expense->payment_type = $request->payment_type;
                $expense->remarks = $request->remarks;
                $expense->status = $request->status;
                $expense->save();
                toastr()->success('Office Expense Update Successfully.');
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
        try{
            $expense = OfficeExpense::find($id);
            $expense->delete();
            toastr()->success('Delete Successfully.');
            return back();
        }
        catch(\Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }

    }
}
