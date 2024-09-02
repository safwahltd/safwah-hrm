<?php

namespace App\Http\Controllers;

use App\Models\LeaveType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;
use function PHPUnit\Framework\fail;

class LeaveController extends Controller
{
    public function leaveTypeIndex(){
        $leaveTypes = LeaveType::latest()->paginate(20);
        return view('admin.leave.type',compact('leaveTypes'));
    }
    public function leaveTypeStore(Request $request){
        try {
            $validate = Validator::make($request->all(),[
                'name' => 'required'
            ]);
            if ($validate->fails()){
                toastr()->warning($validate->messages());
                return back();
            }
            $leaveTypes = new LeaveType();
            $leaveTypes->name = $request->name;
            $leaveTypes->days_per_year = $request->days_per_year;
            $leaveTypes->days_per_month = $request->days_per_month;
            $leaveTypes->status = $request->status;
            $leaveTypes->save();
            toastr()->success('Leave Type Added Successfully.');
            return back();
        }
        catch (Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }
    }
    public function leaveTypeUpdate(Request $request){
        try {
            $validate = Validator::make($request->all(),[
                'name' => 'required'
            ]);
            if ($validate->fails()){
                toastr()->warning($validate->messages());
                return back();
            }
            $leaveTypes = LeaveType::find($request->id);
            $leaveTypes->name = $request->name;
            $leaveTypes->days_per_year = $request->days_per_year;
            $leaveTypes->days_per_month = $request->days_per_month;
            $leaveTypes->status = $request->status;
            $leaveTypes->save();
            toastr()->success('Leave Type Update Successfully.');
            return back();
        }
        catch (Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }
    }
    public function leaveTypeDestroy($id){
        try {
            $leaveTypes = LeaveType::find($id);
            $leaveTypes->delete();
            toastr()->success('Leave Type Delete Successfully.');
            return back();
        }
        catch (Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }

    }

}
