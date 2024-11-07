<?php

namespace App\Http\Controllers\admin;

use App\Models\WorkingDay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Exception;

class WorkingDayController extends Controller
{
    public function index(){
        $workingDays = WorkingDay::latest()->whereNotIn('soft_delete',[0])->paginate(1000);
        return view('admin.working-day.index',compact('workingDays'));
    }
    public function store(Request $request){
        try{
            $validate = Validator::make($request->all(),[
                'month' => 'required',
                'year' => 'required',
                'days_in_month' => 'required',
                'working_day' => 'required',
            ]);
            if($validate->fails()){
                toastr()->error($validate->messages());
                return back();
            }
            $working = WorkingDay::where('month',$request->month)->where('year',$request->year)->first();
            if (!$working){
                $workingDay = new WorkingDay();
                $workingDay->month = $request->month;
                $workingDay->year = $request->year;
                $workingDay->days_in_month = $request->days_in_month;
                $workingDay->working_day = $request->working_day;
                $workingDay->status = $request->status;
                $workingDay->saveOrFail();
                toastr()->success('Create Success.');
                return back();
            }
            else{
                toastr()->error('Already Have This Data.');
                return back();
            }

        }
        catch(Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }

    }
    public function update(Request $request,$id){
        try{
            $validate = Validator::make($request->all(),[
                'month' => 'required',
                'year' => 'required',
                'days_in_month' => 'required',
                'working_day' => 'required',
            ]);
            if($validate->fails()){
                toastr()->error($validate->messages());
                return back();
            }
            $working = WorkingDay::where('month',$request->month)->where('year',$request->year)->whereNotIn('id',[$id])->first();
            if (!$working){
                $workingDay = WorkingDay::find($id);
                $workingDay->month = $request->month;
                $workingDay->year = $request->year;
                $workingDay->days_in_month = $request->days_in_month;
                $workingDay->working_day = $request->working_day;
                $workingDay->status = $request->status;
                $workingDay->saveOrFail();
                toastr()->success('Update Success.');
                return back();
            }
            else{
                toastr()->error('Already Have This Data.');
                return back();
            }
        }
        catch(Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }

    }
    public function destroy($id){
        $workingDay = WorkingDay::find($id);
        $workingDay->month = $workingDay->month;
        $workingDay->year = $workingDay->year;
        $workingDay->days_in_month = $workingDay->days_in_month;
        $workingDay->working_day = $workingDay->working_day;
        $workingDay->status = $workingDay->status;
        $workingDay->soft_delete = 0;
        $workingDay->saveOrFail();
        toastr()->success('Delete Success.');
        return back();
    }
}
