<?php

namespace App\Http\Controllers;

use App\Models\Leave;
use App\Models\LeaveType;
use App\Models\User;
use App\Models\UserInfos;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Exception;
use function PHPUnit\Framework\fail;
use Barryvdh\DomPDF\Facade\Pdf;

class LeaveController extends Controller
{
    public function employeeLeaveIndex(){
        $leaves = Leave::where('user_id',auth()->user()->id)->latest()->paginate(20);
        return view('employee.leave.index',compact('leaves'));
    }
    public function employeeLeaveRequest(Request $request){
        try {
            $validate = Validator::make($request->all(),[
               'leave_type' => 'required' ,
               'reason' => 'required',
               'address_contact' => 'required',
               'concern_person' => 'required',
            ]);
            if ($validate->fails()){
                toastr()->error($validate->messages());
                return back();
            }
            /* Total days count */
            $startDate = new \DateTime($request->start_date);
            $endDate = new \DateTime($request->end_date);
            $total = $startDate->diff($endDate);

            $leaveRequest = new Leave();
            $leaveRequest->user_id = auth()->user()->id;
            $leaveRequest->leave_type = $request->leave_type;

            if ($startDate == $endDate){
                $leaveRequest->days_taken = 1;
            }
            else{
                $leaveRequest->days_taken = $total->days + 1;
            }
            $leaveBalance = UserInfos::where('user_id',auth()->user()->id)->first();
            if ($request->leave_type == 'sick'){
                if ($leaveBalance->sick_leave > 0){
                    if ($leaveBalance->sick_leave >= $leaveRequest->days_taken){
                        $leaveRequest->reason = $request->reason;
                        $leaveRequest->start_date = $request->start_date;
                        $leaveRequest->end_date = $request->end_date;
                        $leaveRequest->address_contact = $request->address_contact;
                        $leaveRequest->concern_person = $request->concern_person;
                        $leaveRequest->save();
                        toastr()->success('Leave Request Send Success.');
                        return back();
                    }
                    else{
                        toastr()->error('Not Enough Leave Balance.');
                        return back();
                    }
                }
                else{
                    toastr()->error('Not Enough Leave Balance.');
                    return back();
                }
            }
            if ($request->leave_type == 'casual'){
                if ($leaveBalance->casual_leave > 0){
                    if ($leaveBalance->casual_leave >= $leaveRequest->days_taken){
                        $leaveRequest->reason = $request->reason;
                        $leaveRequest->start_date = $request->start_date;
                        $leaveRequest->end_date = $request->end_date;
                        $leaveRequest->address_contact = $request->address_contact;
                        $leaveRequest->concern_person = $request->concern_person;
                        $leaveRequest->save();
                        toastr()->success('Leave Request Send Success.');
                        return back();
                    }
                    else{
                        toastr()->error('Not Enough Leave Balance.');
                        return back();
                    }
                }
                else{
                    toastr()->error('Not Enough Leave Balance.');
                    return back();
                }
            }
            if ($request->leave_type == 'half_day'){
                $startOfMonth = Carbon::now()->startOfMonth();
                $endOfMonth = Carbon::now()->endOfMonth();
                $leavee = Leave::where('user_id',auth()->user()->id)->whereNot('start_time',null)->whereBetween('created_at', [$startOfMonth, $endOfMonth])->where('status',1)->count();
                if ($leaveBalance->half_day_leave > 0){
                    if ($leaveBalance->half_day_leave > $leavee){
                        $leaveRequest->start_time = $request->start_time;
                        $leaveRequest->end_time = $request->end_time;
                        $leaveRequest->start_date = today();
                        $leaveRequest->end_date = today();
                        $leaveRequest->reason = $request->reason;
                        $leaveRequest->address_contact = $request->address_contact;
                        $leaveRequest->concern_person = $request->concern_person;
                        $leaveRequest->save();
                        toastr()->success('Leave Request Send Success.');
                        return back();
                    }
                    else{
                        toastr()->error('Not Enough Leave Balance.');
                        return back();
                    }
                }
                else{
                    toastr()->error('Not Enough Leave Balance.');
                    return back();
                }
            }
        }
        catch (Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }
    }
    public function employeeLeaveRequestUpdate(Request $request,$id){
        try {
            $validate = Validator::make($request->all(),[
                'leave_type' => 'required' ,
                'reason' => 'required',
                'address_contact' => 'required',
                'concern_person' => 'required',
            ]);
            if ($validate->fails()){
                toastr()->error($validate->messages());
                return back();
            }
            /* Total days count */
            $startDate = new \DateTime($request->start_date);
            $endDate = new \DateTime($request->end_date);
            $total = $startDate->diff($endDate);

            $leaveRequest = Leave::find($id);
            $leaveRequest->user_id = auth()->user()->id;
            $leaveRequest->leave_type = $request->leave_type;
            if ($startDate == $endDate){
                $leaveRequest->days_taken = 1;
            }
            else{
                $leaveRequest->days_taken = $total->days + 1;
            }
            $leaveBalance = UserInfos::where('user_id',auth()->user()->id)->first();
            if ($request->leave_type == 'sick'){
                if ($leaveBalance->sick_leave > 0){
                    if ($leaveBalance->sick_leave >= $leaveRequest->days_taken){
                        $leaveRequest->reason = $request->reason;
                        $leaveRequest->start_date = $request->start_date;
                        $leaveRequest->end_date = $request->end_date;
                        $leaveRequest->address_contact = $request->address_contact;
                        $leaveRequest->concern_person = $request->concern_person;
                        $leaveRequest->save();
                        toastr()->success('Leave Request Send Success.');
                        return back();
                    }
                    else{
                        toastr()->error('Not Enough Leave Balance.');
                        return back();
                    }
                }
                else{
                    toastr()->error('Not Enough Leave Balance.');
                    return back();
                }
            }
            if ($request->leave_type == 'casual'){
                if ($leaveBalance->casual_leave > 0){
                    if ($leaveBalance->casual_leave >= $leaveRequest->days_taken){
                        $leaveRequest->reason = $request->reason;
                        $leaveRequest->start_date = $request->start_date;
                        $leaveRequest->end_date = $request->end_date;
                        $leaveRequest->address_contact = $request->address_contact;
                        $leaveRequest->concern_person = $request->concern_person;
                        $leaveRequest->save();
                        toastr()->success('Leave Request Send Success.');
                        return back();
                    }
                    else{
                        toastr()->error('Not Enough Leave Balance.');
                        return back();
                    }
                }
                else{
                    toastr()->error('Not Enough Leave Balance.');
                    return back();
                }
            }
            if ($request->leave_type == 'half_day'){
                if ($leaveBalance->half_day_leave > 0){
                    $leaveRequest->start_time = $request->start_time;
                    $leaveRequest->end_time = $request->end_time;
                    $leaveRequest->start_date = today();
                    $leaveRequest->end_date = today();
                    $leaveRequest->reason = $request->reason;
                    $leaveRequest->address_contact = $request->address_contact;
                    $leaveRequest->concern_person = $request->concern_person;
                    $leaveRequest->save();
                    toastr()->success('Leave Request Send Success.');
                    return back();
                }
                else{
                    toastr()->error('Not Enough Leave Balance.');
                    return back();
                }
            }
        }
        catch (Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }
    }
    public function employeeLeaveRequestCancel($id){
        $leave = Leave::find($id);
        $leave->status = 3;
        $leave->save();
        toastr()->success('Request Cancel Success.');
        return back();
    }
    public function employeeLeaveRequestPrint($id)
    {
        $data = Leave::find($id);
        $pdf = Pdf::loadView('employee.leave.print', compact('data'));
//        return view('employee.leave.print', compact('data'));
        return $pdf->download($data->user->name.'_'.$data->id.'_leave_request.pdf');
    }
    public function adminIndex(){
        if(auth()->user()->hasPermission('admin leave requests')){
            $leaves = Leave::latest()->paginate(20);
            return view('admin.leave.index',compact('leaves'));
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function AdminRequestUpdate(Request $request,$id){
        if(auth()->user()->hasPermission('admin leave update')){
            try{
                $validate = Validator::make($request->all(),[
                    'status' => 'required',
                ]);
                if($validate->fails()){
                    toastr()->error($validate->messages());
                    return back();
                }
                $leave = Leave::find($id);
                $leaveBalance = UserInfos::where('user_id',$leave->user_id)->first();
                if ($leave->status == 0){
                    if ($request->status == 1){
                        if($leave->leave_type == 'casual'){
                            if ($leaveBalance->casual_leave >= $leave->days_taken){
                                $leave->status = $request->status;
                                $leaveBalance->casual_leave = ($leaveBalance->casual_leave - $leave->days_taken);
                                $leave->approved_by = auth()->user()->id;
                                $leave->save();
                                $leaveBalance->save();
                                toastr()->success('update successfully.');
                                return back();
                            }
                            else{
                                toastr()->error('Not Enough Leave Balance');
                                return back();
                            }
                        }
                        if($leave->leave_type == 'sick'){
                            if ($leaveBalance->sick_leave >= $leave->days_taken){
                                $leave->status = $request->status;
                                $leaveBalance->sick_leave = ($leaveBalance->sick_leave - $leave->days_taken);
                                $leave->approved_by = auth()->user()->id;
                                $leave->save();
                                $leaveBalance->save();
                                toastr()->success('update successfully.');
                                return back();
                            }else{
                                toastr()->error('Not Enough Leave Balance');
                                return back();
                            }
                        }
                        if($leave->leave_type == 'half_day'){
                            $leave->status = $request->status;
                            $leave->approved_by = auth()->user()->id;
                            $leaveBalance->half_day_leave = ($leaveBalance->half_day_leave - 1);
                            $leave->save();
                            $leaveBalance->save();
                            toastr()->success('update successfully.');
                            return back();
                        }
                    }
                    if ($request->status == 2 || $request->status == 3){
                        $leave->status = $request->status;
                        $leave->approved_by = auth()->user()->id;
                        $leave->save();
                        toastr()->success('update successfully.');
                        return back();
                    }
                }
                if ($leave->status == 1){
                    if ($request->status == 0 || $request->status == 2 || $request->status == 3){
                        if($leave->leave_type == 'casual'){
                            $leave->status = $request->status;
                            $leaveBalance->casual_leave = ($leaveBalance->casual_leave + $leave->days_taken);
                            $leave->approved_by = auth()->user()->id;
                            $leave->save();
                            $leaveBalance->save();
                            toastr()->success('update successfully.');
                            return back();
                        }
                        if($leave->leave_type == 'sick'){
                            $leave->status = $request->status;
                            $leaveBalance->sick_leave = ($leaveBalance->sick_leave + $leave->days_taken);
                            $leave->approved_by = auth()->user()->id;
                            $leave->save();
                            $leaveBalance->save();
                            toastr()->success('update successfully.');
                            return back();
                        }
                        if($leave->leave_type == 'half_day'){
                            $leave->status = $request->status;
                            $leave->approved_by = auth()->user()->id;
                            $leaveBalance->half_day_leave = ($leaveBalance->half_day_leave + 1);
                            $leave->save();
                            $leaveBalance->save();
                            toastr()->success('update successfully.');
                            return back();
                        }
                    }
                }
                if ($leave->status = 2){
                    if ($request->status = 1){
                        if($leave->leave_type == 'casual'){
                            if ($leaveBalance->casual_leave >= $leave->days_taken){
                                $leave->status = $request->status;
                                $leaveBalance->casual_leave = ($leaveBalance->casual_leave - $leave->days_taken);
                                $leave->approved_by = auth()->user()->id;
                                $leave->save();
                                $leaveBalance->save();
                                toastr()->success('update successfully.');
                                return back();
                            }
                            else{
                                toastr()->error('Not Enough Leave Balance');
                                return back();
                            }
                        }
                        if($leave->leave_type == 'sick'){
                            if ($leaveBalance->sick_leave >= $leave->days_taken){
                                $leave->status = $request->status;
                                $leaveBalance->sick_leave = ($leaveBalance->sick_leave - $leave->days_taken);
                                $leave->approved_by = auth()->user()->id;
                                $leave->save();
                                $leaveBalance->save();
                                toastr()->success('update successfully.');
                                return back();
                            }
                            else{
                                toastr()->error('Not Enough Leave Balance');
                                return back();
                            }
                        }
                        if($leave->leave_type == 'half_day'){
                            $leave->status = $request->status;
                            $leave->approved_by = auth()->user()->id;
                            $leaveBalance->half_day_leave = ($leaveBalance->half_day_leave - 1);
                            $leave->save();
                            $leaveBalance->save();
                            toastr()->success('update successfully.');
                            return back();
                        }
                    }
                    if ($request->status == 0 || $request->status == 3){
                        $leave->status = $request->status;
                        $leave->approved_by = auth()->user()->id;
                        $leave->save();
                        toastr()->success('update successfully.');
                        return back();
                    }
                }
                if ($leave->status == 3){
                    if ($request->status == 1){
                        if($leave->leave_type = 'casual'){
                            if ($leaveBalance->casual_leave >= $leave->days_taken){
                                $leave->status = $request->status;
                                $leaveBalance->casual_leave = ($leaveBalance->casual_leave - $leave->days_taken);
                                $leave->approved_by = auth()->user()->id;
                                $leave->save();
                                $leaveBalance->save();
                                toastr()->success('update successfully.');
                                return back();
                            }
                        }
                        else{
                            toastr()->error('Not Enough Leave Balance');
                            return back();
                        }
                        if($leave->leave_type == 'sick'){
                            if($leaveBalance->sick_leave >= $leave->days_taken){
                                $leave->status = $request->status;
                                $leaveBalance->sick_leave = ($leaveBalance->sick_leave - $leave->days_taken);
                                $leave->approved_by = auth()->user()->id;
                                $leave->save();
                                $leaveBalance->save();
                                toastr()->success('update successfully.');
                                return back();
                            }

                        }else{
                            toastr()->error('Not Enough Leave Balance');
                            return back();
                        }
                        if($leave->leave_type == 'half_day'){
                            $leave->status = $request->status;
                            $leave->approved_by = auth()->user()->id;
                            $leaveBalance->half_day_leave = ($leaveBalance->half_day_leave - 1);
                            $leave->save();
                            $leaveBalance->save();
                            toastr()->success('update successfully.');
                            return back();
                        }
                    }
                    if ($request->status == 0 || $request->status == 2){
                        $leave->status = $request->status;
                        $leave->approved_by = auth()->user()->id;
                        $leave->save();
                        toastr()->success('update successfully.');
                        return back();
                    }
                }

            }
            catch(Exception $e){
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
