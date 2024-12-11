<?php

namespace App\Http\Controllers;

use App\Events\EmployeeNotificationEvent;
use App\Events\GeneralNotificationEvent;
use App\Models\HalfDayLeaveBalance;
use App\Models\Leave;
use App\Models\LeaveBalance;
use App\Models\LeaveType;
use App\Models\Permission;
use App\Models\RolePermission;
use App\Models\User;
use App\Models\UserInfos;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;
use function PHPUnit\Framework\fail;
use Barryvdh\DomPDF\Facade\Pdf;

class LeaveController extends Controller
{
    public function employeeLeaveIndex(){
        if (auth()->user()->hasPermission('employee leave')){
            $leaves = Leave::where('user_id',auth()->user()->id)->latest()->paginate(100);
            return view('employee.leave.index',compact('leaves'));
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function employeeLeaveRequest(Request $request){
        if (auth()->user()->hasPermission('employee leave request')){
            try {
                $leave = Leave::where('user_id',auth()->user()->id)->whereJsonContains('dates',$request->start_date)->orWhereJsonContains('dates',$request->end_date)->where('status',1)->first();
                if (!$leave){
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
                    // Step 1: Find the permission ID for 'admin leave requests'
                    $permission = Permission::where('name', 'admin leave requests')->first();
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

                    /* Total days count */
                    $startDate = Carbon::parse($request->start_date);
                    $endDate = Carbon::parse($request->end_date);
                    $total = $startDate->diff($endDate);
                    $dates = collect();

                    $currentDate = $startDate->copy();
                    while ($currentDate->lte($endDate)) {
                        $dates->push($currentDate->toDateString());
                        $currentDate->addDay();
                    }


                    $leaveRequest = new Leave();
                    $leaveRequest->user_id = auth()->user()->id;
                    $leaveRequest->leave_type = $request->leave_type;
                    $leaveRequest->days_taken = count($dates);

                    if ($request->leave_type == 'sick'){
                        $leaveBalance = LeaveBalance::where('user_id',auth()->user()->id)->where('year',Carbon::parse($request->start_date)->format('Y'))->first();
                        if ($leaveBalance->sick_left > 0){
                            if ($leaveBalance->sick_left >= $leaveRequest->days_taken){
                                $leaveRequest->reason = $request->reason;
                                $leaveRequest->start_date = $request->start_date;
                                $leaveRequest->end_date = $request->end_date;
                                $leaveRequest->dates = json_encode($dates);
                                $leaveRequest->address_contact = $request->address_contact;
                                $leaveRequest->concern_person = $request->concern_person;
                                $leaveRequest->save();

                                // Trigger event
                                event(new GeneralNotificationEvent(
                                    'new_leave_request',
                                    ucwords($leaveRequest->leave_type),
                                    [
                                        'content' => $leaveRequest->reason,
                                        'user_id' => $leaveRequest->user_id,
                                        'url' => route('admin.leave.requests'),
                                    ]
                                ));
                                // Trigger event
                                foreach ($employees as $employee) {
                                    event(new EmployeeNotificationEvent(
                                        'new_leave_request',
                                        ucwords($leaveRequest->leave_type),
                                        $employee->id,
                                        [
                                            'content' => $leaveRequest->reason,
                                            'user_id' => $leaveRequest->user_id,
                                            'url' => route('admin.leave.requests'),
                                        ]
                                    ));
                                }

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
                        $leaveBalance = LeaveBalance::where('user_id',auth()->user()->id)->where('year',Carbon::parse($request->start_date)->format('Y'))->first();
                        if ($leaveBalance->casual_left > 0){
                            if ($leaveBalance->casual_left >= $leaveRequest->days_taken){
                                $leaveRequest->reason = $request->reason;
                                $leaveRequest->start_date = $request->start_date;
                                $leaveRequest->end_date = $request->end_date;
                                $leaveRequest->dates = json_encode($dates);
                                $leaveRequest->address_contact = $request->address_contact;
                                $leaveRequest->concern_person = $request->concern_person;
                                $leaveRequest->save();

                                // Trigger event
                                event(new GeneralNotificationEvent(
                                    'new_leave_request',
                                    ucwords($leaveRequest->leave_type),
                                    [
                                        'content' => $leaveRequest->reason,
                                        'user_id' => $leaveRequest->user_id,
                                        'url' => route('admin.leave.requests'),
                                    ]
                                ));
                                // Trigger event
                                foreach ($employees as $employee) {
                                    event(new EmployeeNotificationEvent(
                                        'new_leave_request',
                                        ucwords($leaveRequest->leave_type),
                                        $employee->id,
                                        [
                                            'content' => $leaveRequest->reason,
                                            'user_id' => $leaveRequest->user_id,
                                            'url' => route('admin.leave.requests'),
                                        ]
                                    ));
                                }
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
                        $leaveBalance = HalfDayLeaveBalance::where('user_id',auth()->user()->id)->where('year',Carbon::parse($request->start_date)->format('Y'))->where('month',Carbon::parse($request->start_date)->format('m'))->first();
                        if ($leaveBalance->left > 0){
                            if ($leaveBalance->left > $leavee){
                                $leaveRequest->start_time = $request->start_time;
                                $leaveRequest->end_time = $request->end_time;
                                $leaveRequest->start_date = today();
                                $leaveRequest->end_date = today();
                                $leaveRequest->dates = json_encode(today());
                                $leaveRequest->reason = $request->reason;
                                $leaveRequest->address_contact = $request->address_contact;
                                $leaveRequest->concern_person = $request->concern_person;
                                $leaveRequest->save();

                                // Trigger event
                                event(new GeneralNotificationEvent(
                                    'new_leave_request',
                                    ucwords($leaveRequest->leave_type),
                                    [
                                        'content' => $leaveRequest->reason,
                                        'user_id' => $leaveRequest->user_id,
                                        'url' => route('admin.leave.requests'),
                                    ]
                                ));
                                // Trigger event
                                foreach ($employees as $employee) {
                                    event(new EmployeeNotificationEvent(
                                        'new_leave_request',
                                        ucwords($leaveRequest->leave_type),
                                        $employee->id,
                                        [
                                            'content' => $leaveRequest->reason,
                                            'user_id' => $leaveRequest->user_id,
                                            'url' => route('admin.leave.requests'),
                                        ]
                                    ));
                                }
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
                else{
                    toastr()->error('Already Spent This Day/Days Leave.');
                    return back();
                }
            }
            catch (Exception $e){
                toastr()->error($e->getMessage());
                return back();
            }
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function employeeLeaveRequestUpdate(Request $request,$id){
        if (auth()->user()->hasPermission('employee leave request update')){
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
                $startDate = Carbon::parse($request->start_date);
                $endDate = Carbon::parse($request->end_date);
                $total = $startDate->diff($endDate);
                $dates = collect();

                $currentDate = $startDate->copy();

                while ($currentDate->lte($endDate)) {
                    $dates->push($currentDate->toDateString());  // Add the date to the collection
                    $currentDate->addDay();  // Move to the next day
                }

                $leaveRequest = Leave::find($id);
                $leaveRequest->user_id = auth()->user()->id;
                $leaveRequest->leave_type = $request->leave_type;
                $leaveRequest->days_taken = count($dates);
                if ($request->leave_type == 'sick'){
                    $leaveBalance = LeaveBalance::where('user_id',auth()->user()->id)->where('year',Carbon::parse($request->start_date)->format('Y'))->first();
                    if ($leaveBalance->sick_left > 0){
                        if ($leaveBalance->sick_left >= $leaveRequest->days_taken){
                            $leaveRequest->reason = $request->reason;
                            $leaveRequest->start_date = $request->start_date;
                            $leaveRequest->end_date = $request->end_date;
                            $leaveRequest->dates = json_encode($dates);
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
                    $leaveBalance = LeaveBalance::where('user_id',auth()->user()->id)->where('year',Carbon::parse($request->start_date)->format('Y'))->first();
                    if ($leaveBalance->casual_left > 0){
                        if ($leaveBalance->casual_left >= $leaveRequest->days_taken){
                            $leaveRequest->reason = $request->reason;
                            $leaveRequest->start_date = $request->start_date;
                            $leaveRequest->end_date = $request->end_date;
                            $leaveRequest->dates = json_encode($dates);
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
                    $leaveBalance = HalfDayLeaveBalance::where('user_id',auth()->user()->id)->where('year',Carbon::parse($request->start_date)->format('Y'))->where('month',Carbon::parse($request->start_date)->format('m'))->first();
                    if ($leaveBalance->half_day_leave > 0){
                        $leaveRequest->start_time = $request->start_time;
                        $leaveRequest->end_time = $request->end_time;
                        $leaveRequest->start_date = today();
                        $leaveRequest->end_date = today();
                        $leaveRequest->dates = json_encode(today());
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
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function employeeLeaveRequestCancel($id){
        if (auth()->user()->hasPermission('employee leave request cancel')){
            $leave = Leave::find($id);
            $leave->status = 3;
            $leave->save();
            toastr()->success('Request Cancel Success.');
            return back();
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function employeeLeaveRequestPrint($id)
    {
        if (auth()->user()->hasPermission('employee leave request print')){
            $data = Leave::find($id);

            if ($data->leave_type == 'casual' || $data->leave_type == 'sick'){
                $leaveBalance = LeaveBalance::where('user_id',$data->user_id)->where('year',Carbon::parse($data->start_date)->format('Y'))->first();
            }
            elseif ($data->leave_type == 'half_day'){
                $leaveBalance = HalfDayLeaveBalance::where('user_id',$data->user_id)->where('year', Carbon::parse($data->start_date)->format('Y'))->where('month', Carbon::parse($data->start_date)->format('m'))->first();
            }
//        return view('employee.leave.print', compact('data','leaveBalance'));
            $pdf = Pdf::loadView('employee.leave.print', compact('data','leaveBalance'));
            return $pdf->download($data->user->name.'_'.$data->id.'_leave_request.pdf');
        }else{
            toastr()->error('Permission Denied');
            return back();
        }
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
                if($leave->leave_type == 'sick' || $leave->leave_type == 'casual'){
                    $leaveBalance = LeaveBalance::where('user_id',$leave->user_id)
                        ->where('year',Carbon::parse($leave->start_date)->format('Y'))
                        ->first();
                }
                elseif ($leave->leave_type == 'half_day'){
                    $leaveBalance = HalfDayLeaveBalance::where('user_id',$leave->user_id)
                        ->where('year',Carbon::parse($leave->start_date)->format('Y'))
                        ->where('month',Carbon::parse($leave->start_date)->format('m'))
                        ->first();
                }

                if ($leave->status == 0){
                    if ($request->status == 1){
                        if($leave->leave_type == 'casual'){
                            if ($leaveBalance->casual_left >= $leave->days_taken){
                                $leave->status = $request->status;
                                $leaveBalance->casual_spent = ($leaveBalance->casual_spent + $leave->days_taken);
                                $leaveBalance->casual_left = ($leaveBalance->casual_left - $leave->days_taken);
                                $leave->approved_by = auth()->user()->id;
                                $leave->save();
                                $leaveBalance->save();
                                $status = ($request->status == 1 ? '':'');
                                // Trigger event
                                event(new EmployeeNotificationEvent(
                                        '',
                                        'Your Leave Request Approved.',
                                        $leave->user_id,
                                        [
                                            'content' => $status,
                                            'user_id' => $leave->approved_by,
                                            'url' => route('employee.leave'),
                                        ]
                                ));
                                toastr()->success('update successfully.');
                                return back();
                            }
                            else{
                                toastr()->error('Not Enough Leave Balance');
                                return back();
                            }
                        }
                        if($leave->leave_type == 'sick'){
                            if ($leaveBalance->sick_left >= $leave->days_taken){
                                $leave->status = $request->status;
                                $leaveBalance->sick_spent = ($leaveBalance->sick_spent + $leave->days_taken);
                                $leaveBalance->sick_left = ($leaveBalance->sick_left - $leave->days_taken);
                                $leave->approved_by = auth()->user()->id;
                                $leave->save();
                                $leaveBalance->save();
                                $status = ($request->status == 1 ? 'Your Leave Request Approved.':'');
                                // Trigger event
                                event(new EmployeeNotificationEvent(
                                    '',
                                    'Your Leave Request Approved.',
                                    $leave->user_id,
                                    [
                                        'content' => $status,
                                        'user_id' => $leave->approved_by,
                                        'url' => route('employee.leave'),
                                    ]
                                ));
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
                            $leaveBalance->spent = ($leaveBalance->spent + $leave->days_taken);
                            $leaveBalance->left = ($leaveBalance->left - $leave->days_taken);
                            $leave->save();
                            $leaveBalance->save();
                            if ($request->status == 1){
                                $status = 'Your Leave Request Approved.';
                            }
                            // Trigger event
                            event(new EmployeeNotificationEvent(
                                '',
                                ucwords($status),
                                $leave->user_id,
                                [
                                    'content' => $status,
                                    'user_id' => $leave->approved_by,
                                    'url' => route('employee.leave'),
                                ]
                            ));
                            toastr()->success('update successfully.');
                            return back();
                        }
                    }
                    if ($request->status == 2 || $request->status == 3){
                        $leave->status = $request->status;
                        $leave->approved_by = auth()->user()->id;
                        $leave->save();
                        if ($request->status == 2){
                            $status = 'Your Leave Request Rejected.';
                        }
                        elseif ($request->status == 3){
                            $status =  'Your Leave Request Canceled.';
                        }
                        // Trigger event
                        event(new EmployeeNotificationEvent(
                            '',
                            ucwords($status),
                            $leave->user_id,
                            [
                                'content' => $status,
                                'user_id' => $leave->approved_by,
                                'url' => route('employee.leave'),
                            ]
                        ));
                        toastr()->success('update successfully.');
                        return back();
                    }
                }
                if ($leave->status == 1){
                    if ($request->status == 0 || $request->status == 2 || $request->status == 3){
                        if($leave->leave_type == 'casual'){
                            $leave->status = $request->status;
                            $leaveBalance->casual_spent = ($leaveBalance->casual_spent - $leave->days_taken);
                            $leaveBalance->casual_left = ($leaveBalance->casual_left + $leave->days_taken);
                            $leave->approved_by = auth()->user()->id;
                            $leave->save();
                            $leaveBalance->save();
                            if ($request->status == 2){
                                $status = 'Your Leave Request Rejected.';
                            }
                            elseif ($request->status == 3){
                                $status =  'Your Leave Request Canceled.';
                            }
                            // Trigger event
                            event(new EmployeeNotificationEvent(
                                '',
                                ucwords($status),
                                $leave->user_id,
                                [
                                    'content' => $status,
                                    'user_id' => $leave->approved_by,
                                    'url' => route('employee.leave'),
                                ]
                            ));
                            toastr()->success('update successfully.');
                            return back();
                        }
                        if($leave->leave_type == 'sick'){
                            $leave->status = $request->status;
                            $leaveBalance->sick_spent = ($leaveBalance->sick_spent - $leave->days_taken);
                            $leaveBalance->sick_left = ($leaveBalance->sick_left + $leave->days_taken);
                            $leave->approved_by = auth()->user()->id;
                            $leave->save();
                            $leaveBalance->save();
                            if ($request->status == 2){
                                $status = 'Your Leave Request Rejected.';
                            }
                            elseif ($request->status == 3){
                                $status =  'Your Leave Request Canceled.';
                            }
                            // Trigger event
                            event(new EmployeeNotificationEvent(
                                '',
                                ucwords($status),
                                $leave->user_id,
                                [
                                    'content' => $status,
                                    'user_id' => $leave->approved_by,
                                    'url' => route('employee.leave'),
                                ]
                            ));
                            toastr()->success('update successfully.');
                            return back();
                        }
                        if($leave->leave_type == 'half_day'){
                            $leave->status = $request->status;
                            $leave->approved_by = auth()->user()->id;
                            $leaveBalance->spent = ($leaveBalance->spent - $leave->days_taken);
                            $leaveBalance->left = ($leaveBalance->left + $leave->days_taken);
                            $leave->save();
                            $leaveBalance->save();
                            if ($request->status == 2){
                                $status = 'Your Leave Request Rejected.';
                            }
                            elseif ($request->status == 3){
                                $status =  'Your Leave Request Canceled.';
                            }
                            // Trigger event
                            event(new EmployeeNotificationEvent(
                                '',
                                ucwords($status),
                                $leave->user_id,
                                [
                                    'content' => $status,
                                    'user_id' => $leave->approved_by,
                                    'url' => route('employee.leave'),
                                ]
                            ));
                            toastr()->success('update successfully.');
                            return back();
                        }
                    }
                }
                if ($leave->status = 2){
                    if ($request->status = 1){
                        if($leave->leave_type == 'casual'){
                            if ($leaveBalance->casual_left >= $leave->days_taken){
                                $leave->status = $request->status;
                                $leaveBalance->casual_spent = ($leaveBalance->casual_spent + $leave->days_taken);
                                $leaveBalance->casual_left = ($leaveBalance->casual_left - $leave->days_taken);
                                $leave->approved_by = auth()->user()->id;
                                $leave->save();
                                $leaveBalance->save();
                                if ($request->status == 1){
                                    $status = 'Your Leave Request Approved.';
                                }
                                // Trigger event
                                event(new EmployeeNotificationEvent(
                                    '',
                                    ucwords($status),
                                    $leave->user_id,
                                    [
                                        'content' => $status,
                                        'user_id' => $leave->approved_by,
                                        'url' => route('employee.leave'),
                                    ]
                                ));
                                toastr()->success('update successfully.');
                                return back();
                            }
                            else{
                                toastr()->error('Not Enough Leave Balance');
                                return back();
                            }
                        }
                        if($leave->leave_type == 'sick'){
                            if ($leaveBalance->sick_left >= $leave->days_taken){
                                $leave->status = $request->status;
                                $leaveBalance->sick_spent = ($leaveBalance->sick_spent + $leave->days_taken);
                                $leaveBalance->sick_left = ($leaveBalance->sick_left - $leave->days_taken);
                                $leave->approved_by = auth()->user()->id;
                                $leave->save();
                                $leaveBalance->save();
                                if ($request->status == 1){
                                    $status = 'Your Leave Request Approved.';
                                }
                                // Trigger event
                                event(new EmployeeNotificationEvent(
                                    '',
                                    ucwords($status),
                                    $leave->user_id,
                                    [
                                        'content' => $status,
                                        'user_id' => $leave->approved_by,
                                        'url' => route('employee.leave'),
                                    ]
                                ));
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
                            $leaveBalance->spent = ($leaveBalance->spent + $leave->days_taken);
                            $leaveBalance->left = ($leaveBalance->left - $leave->days_taken);
                            $leave->save();
                            $leaveBalance->save();
                            if ($request->status == 1){
                                $status = 'Your Leave Request Approved.';
                            }
                            // Trigger event
                            event(new EmployeeNotificationEvent(
                                '',
                                ucwords($status),
                                $leave->user_id,
                                [
                                    'content' => $status,
                                    'user_id' => $leave->approved_by,
                                    'url' => route('employee.leave'),
                                ]
                            ));
                            toastr()->success('update successfully.');
                            return back();
                        }
                    }
                    if ($request->status == 0 || $request->status == 3){
                        $leave->status = $request->status;
                        $leave->approved_by = auth()->user()->id;
                        $leave->save();
                        if ($request->status == 3){
                            $status = 'Your Leave Request Canceled.';
                        }
                        // Trigger event
                        event(new EmployeeNotificationEvent(
                            '',
                            ucwords($status),
                            $leave->user_id,
                            [
                                'content' => $status,
                                'user_id' => $leave->approved_by,
                                'url' => route('employee.leave'),
                            ]
                        ));
                        toastr()->success('update successfully.');
                        return back();
                    }
                }
                if ($leave->status == 3){
                    if ($request->status == 1){
                        if($leave->leave_type = 'casual'){
                            if ($leaveBalance->casual_left >= $leave->days_taken){
                                $leave->status = $request->status;
                                $leaveBalance->casual_spent = ($leaveBalance->casual_spent + $leave->days_taken);
                                $leaveBalance->casual_left = ($leaveBalance->casual_left - $leave->days_taken);
                                $leave->approved_by = auth()->user()->id;
                                $leave->save();
                                $leaveBalance->save();
                                if ($request->status == 1){
                                    $status = 'Your Leave Request Approved.';
                                }
                                // Trigger event
                                event(new EmployeeNotificationEvent(
                                    '',
                                    ucwords($status),
                                    $leave->user_id,
                                    [
                                        'content' => $status,
                                        'user_id' => $leave->approved_by,
                                        'url' => route('employee.leave'),
                                    ]
                                ));
                                toastr()->success('update successfully.');
                                return back();
                            }
                        }
                        else{
                            toastr()->error('Not Enough Leave Balance');
                            return back();
                        }
                        if($leave->leave_type == 'sick'){
                            if($leaveBalance->sick_left >= $leave->days_taken){
                                $leave->status = $request->status;
                                $leaveBalance->sick_spent = ($leaveBalance->sick_spent + $leave->days_taken);
                                $leaveBalance->sick_left = ($leaveBalance->sick_left - $leave->days_taken);
                                $leave->approved_by = auth()->user()->id;
                                $leave->save();
                                $leaveBalance->save();
                                if ($request->status == 1){
                                    $status = 'Your Leave Request Approved.';
                                }
                                // Trigger event
                                event(new EmployeeNotificationEvent(
                                    '',
                                    ucwords($status),
                                    $leave->user_id,
                                    [
                                        'content' => $status,
                                        'user_id' => $leave->approved_by,
                                        'url' => route('employee.leave'),
                                    ]
                                ));
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
                            $leaveBalance->spent = ($leaveBalance->spent + $leave->days_taken);
                            $leaveBalance->left = ($leaveBalance->left - $leave->days_taken);
                            $leave->save();
                            $leaveBalance->save();
                            if ($request->status == 1){
                                $status = 'Your Leave Request Approved.';
                            }
                            // Trigger event
                            event(new EmployeeNotificationEvent(
                                '',
                                ucwords($status),
                                $leave->user_id,
                                [
                                    'content' => $status,
                                    'user_id' => $leave->approved_by,
                                    'url' => route('employee.leave'),
                                ]
                            ));
                            toastr()->success('update successfully.');
                            return back();
                        }
                    }
                    if ($request->status == 0 || $request->status == 2){
                        $leave->status = $request->status;
                        $leave->approved_by = auth()->user()->id;
                        $leave->save();
                        if ($request->status == 2){
                            $status = 'Your Leave Request Rejected.';
                        }
                        // Trigger event
                        event(new EmployeeNotificationEvent(
                            '',
                            ucwords($status),
                            $leave->user_id,
                            [
                                'content' => $status,
                                'user_id' => $leave->approved_by,
                                'url' => route('employee.leave'),
                            ]
                        ));
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
    public function management(){
        if(auth()->user()->hasPermission('admin leave management')){
            $users = User::whereNotIn('id',[1])->where('status',1)->get();
            $leaveBalances = LeaveBalance::orderBy('year','desc')->where('status',1)->simplePaginate(500);
            $halfDayLeaveBalances = HalfDayLeaveBalance::orderBy('year','desc')->orderBy('month','desc')->where('status',1)->simplePaginate(200);
            return view('admin.leave.management',compact('users','leaveBalances','halfDayLeaveBalances'));
        }else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function fullDay(Request $request){
        if(auth()->user()->hasPermission('admin full leave store')){
            try{
                $validate = Validator::make($request->all(),[
                    'year' => 'required',
                ]);
                if($validate->fails()){
                    toastr()->error($validate->messages());
                    return back();
                }
                if ($request->user_id){
                    $users = User::whereIn('id',$request->user_id)->where('status',1)->get('id');
                    foreach ($users as $user){
                        $balanceCheck = LeaveBalance::where('user_id',$user->id)->where('year',$request->year)->first();
                        if ($balanceCheck){
                            $balanceCheck->user_id = $user->id;
                            $balanceCheck->sick = $request->sick;
                            $balanceCheck->casual = $request->casual;
                            $balanceCheck->sick_spent =  $balanceCheck->sick_spent;
                            $balanceCheck->sick_left =  $request->sick - $balanceCheck->sick_spent;
                            $balanceCheck->casual_spent =  $balanceCheck->casual_spent;
                            $balanceCheck->casual_left =  $request->casual - $balanceCheck->casual_spent;
                            $balanceCheck->year = $request->year;
                            $balanceCheck->save();
                        }
                        else{
                            $leaveBalance = new LeaveBalance();
                            $leaveBalance->user_id = $user->id;
                            $leaveBalance->sick = $request->sick;
                            $leaveBalance->casual = $request->casual;
                            $leaveBalance->sick_spent =  0;
                            $leaveBalance->sick_left =  $request->sick;
                            $leaveBalance->casual_spent =  0;
                            $leaveBalance->casual_left =  $request->casual;
                            $leaveBalance->year = $request->year;
                            $leaveBalance->save();
                        }
                    }
                    toastr()->success('Full Day Leave Balance Save Success.');
                    return back();
                }
                else{
                    $users = User::whereNotIn('id',[1])->where('status',1)->get('id');
                    foreach ($users as $user){
                        $balanceCheck = LeaveBalance::where('user_id',$user->id)->where('year',$request->year)->first();
                        if ($balanceCheck){
                            $balanceCheck->user_id = $user->id;
                            $balanceCheck->sick = $request->sick;
                            $balanceCheck->casual = $request->casual;
                            $balanceCheck->sick_spent =  $balanceCheck->sick_spent;
                            $balanceCheck->sick_left =  $request->sick - $balanceCheck->sick_spent;
                            $balanceCheck->casual_spent =  $balanceCheck->casual_spent;
                            $balanceCheck->casual_left =  $request->casual - $balanceCheck->casual_spent;
                            $balanceCheck->year = $request->year;
                            $balanceCheck->save();
                        }
                        else{
                            $leaveBalance = new LeaveBalance();
                            $leaveBalance->user_id = $user->id;
                            $leaveBalance->sick = $request->sick;
                            $leaveBalance->casual = $request->casual;
                            $leaveBalance->sick_spent =  0;
                            $leaveBalance->sick_left =  $request->sick;
                            $leaveBalance->casual_spent =  0;
                            $leaveBalance->casual_left =  $request->casual;
                            $leaveBalance->year = $request->year;
                            $leaveBalance->save();
                        }
                    }
                    toastr()->success('Full Day Leave Balance Save Success.');
                    return back();
                }

            }
            catch(Exception $e){
                toastr()->error($e->getMessage());
                return back();
            }
        }else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function fullDayUpdate(Request $request,$id){
        if(auth()->user()->hasPermission('admin full leave update')){
            try{
                $validate = Validator::make($request->all(),[
                    'sick' => 'required',
                    'casual' => 'required',
                ]);
                if($validate->fails()){
                    toastr()->error($validate->messages());
                    return back();
                }
                $leaveBalance = LeaveBalance::find($id);
                $leaveBalance->user_id = $leaveBalance->user_id;
                $leaveBalance->sick = $request->sick;
                $leaveBalance->casual = $request->casual;
                $leaveBalance ->sick_spent =  $leaveBalance ->sick_spent;
                $leaveBalance ->sick_left =  $request->sick - $leaveBalance ->sick_spent;
                $leaveBalance ->casual_spent =  $leaveBalance ->casual_spent;
                $leaveBalance ->casual_left =  $request->casual - $leaveBalance ->casual_spent;
                $leaveBalance->year =$leaveBalance->year;
                $leaveBalance->save();
                toastr()->success('Update Full Day Leave Balance  Success.');
                return back();
            }
            catch(Exception $e){
                toastr()->error($e->getMessage());
                return back();
            }
        }else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function fullDaySoftDelete($id){
        if(auth()->user()->hasPermission('	admin full leave delete')){
            try{
                $leaveBalance = LeaveBalance::find($id);
                $leaveBalance->user_id = $leaveBalance->user_id;
                $leaveBalance->sick = $leaveBalance->sick;
                $leaveBalance->casual = $leaveBalance->casual;
                $leaveBalance->year = $leaveBalance->year;
                $leaveBalance->status = 0;
                $leaveBalance->save();
                toastr()->success('Delete Full Day Leave Balance Success.');
                return back();
            }
            catch(Exception $e){
                toastr()->error($e->getMessage());
                return back();
            }
        } else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function halfDay(Request $request){
        if(auth()->user()->hasPermission('admin half leave store')){
            try{
                $validate = Validator::make($request->all(),[
                    'month' => 'required | numeric',
                    'year' => 'required | numeric',
                    'half_day' => 'required',
                ]);
                if($validate->fails()){
                    toastr()->error($validate->messages());
                    return back();
                }
                if ($request->user_id){
                    $users = User::whereIn('id',$request->user_id)->where('status',1)->get('id');
                    foreach ($users as $user){
                        $balanceCheck = HalfDayLeaveBalance::where('user_id',$user->id)->where('year',$request->year)->where('month',$request->month)->first();
                        if ($balanceCheck){
                            $balanceCheck->user_id = $user->id;
                            $balanceCheck->month = $request->month;
                            $balanceCheck->year = $request->year;
                            $balanceCheck->half_day = $request->half_day;
                            $balanceCheck->left = ($request->half_day - $balanceCheck->spent);
                            $balanceCheck->save();
                        }
                        else{
                            $leaveBalance = new HalfDayLeaveBalance();
                            $leaveBalance->user_id = $user->id;
                            $leaveBalance->month = $request->month;
                            $leaveBalance->year = $request->year;
                            $leaveBalance->half_day = $request->half_day;
                            $leaveBalance->spent = 0;
                            $leaveBalance->left = $request->half_day;
                            $leaveBalance->save();
                        }
                    }
                    toastr()->success('Half Day Leave Balance Save Success.');
                    return back();
                }
                else{
                    $users = User::whereNotIn('id',[1])->where('status',1)->get('id');
                    foreach ($users as $user){
                        $balanceCheck = HalfDayLeaveBalance::where('user_id',$user->id)->where('year',$request->year)->where('month',$request->month)->first();
                        if ($balanceCheck){
                            $balanceCheck->user_id = $user->id;
                            $balanceCheck->month = $request->month;
                            $balanceCheck->year = $request->year;
                            $balanceCheck->half_day = $request->half_day;
                            $balanceCheck->left = ($request->half_day - $balanceCheck->spent);
                            $balanceCheck->save();
                        }
                        else{
                            $leaveBalance = new HalfDayLeaveBalance();
                            $leaveBalance->user_id = $user->id;
                            $leaveBalance->month = $request->month;
                            $leaveBalance->year = $request->year;
                            $leaveBalance->half_day = $request->half_day;
                            $leaveBalance->spent = 0;
                            $leaveBalance->left = $request->half_day;
                            $leaveBalance->save();
                        }
                    }
                    toastr()->success('Half Day Leave Balance Save Success.');
                    return back();
                }

            }
            catch(Exception $e){
                toastr()->error($e->getMessage());
                return back();
            }
        }else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function halfDayUpdate(Request $request,$id){
        if(auth()->user()->hasPermission('admin half leave update')){
            try{
                $validate = Validator::make($request->all(),[
                    'half_day' => 'required',
                ]);
                if($validate->fails()){
                    toastr()->error($validate->messages());
                    return back();
                }
                $leaveBalance = HalfDayLeaveBalance::find($id);
                $leaveBalance->user_id = $leaveBalance->user_id;
                $leaveBalance->month = $leaveBalance->month;
                $leaveBalance->year = $leaveBalance->year;
                $leaveBalance->half_day = $request->half_day;
                $leaveBalance->spent = $leaveBalance->spent;
                $leaveBalance->left = ($request->half_day - $leaveBalance->spent);
                $leaveBalance->save();
                toastr()->success('Update Half Day Leave Balance  Success.');
                return back();
            }
            catch(Exception $e){
                toastr()->error($e->getMessage());
                return back();
            }
        }else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function halfDaySoftDelete($id){
        if(auth()->user()->hasPermission('admin half leave delete')){
            try{
                $leaveBalance = HalfDayLeaveBalance::find($id);
                $leaveBalance->user_id = $leaveBalance->user_id;
                $leaveBalance->month = $leaveBalance->month;
                $leaveBalance->year = $leaveBalance->year;
                $leaveBalance->half_day = $leaveBalance->half_day;
                $leaveBalance->spent = $leaveBalance->spent;
                $leaveBalance->left = ($leaveBalance->half_day - $leaveBalance->spent);
                $leaveBalance->status = 0;
                $leaveBalance->save();
                toastr()->success('Delete Half Day Leave Balance Success.');
                return back();
            }
            catch(Exception $e){
                toastr()->error($e->getMessage());
                return back();
            }
        }else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
}
