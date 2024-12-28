<?php

namespace App\Http\Controllers\admin;

use App\Events\GeneralNotificationEvent;
use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\Department;
use App\Models\Designation;
use App\Models\Role;
use App\Models\User;
use App\Models\UserInfos;
use App\Models\UserRole;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        try {
            if(auth()->user()->hasPermission('admin employees index')){
                if ($request->all()){
                    $user_id = $request->user_id;
                    $status = $request->status;
                    $designation_id = $request->designation;
                    $type = $request->type;
                    if ($status == ''){
                        $users = User::whereNotIn('role',['admin'])
                            ->when($user_id, function ($q) use ($user_id) {
                                return $q->where('id', $user_id);
                            })->when($status, function ($q) use ($status) {
                                return $q->where('status', $status);
                            })->when($designation_id, function ($q) use ($designation_id) {
                                return $q->whereHas('userInfo', function ($q) use ($designation_id) {
                                    $q->where('designation', $designation_id);
                                });
                            })->when($type, function ($q) use ($type) {
                                return $q->whereHas('userInfo', function ($q) use ($type) {
                                    $q->where('employee_type', $type);
                                });
                            })
                            ->latest()->get();
                    }
                    else{
                        $users = User::whereNotIn('role',['admin'])
                            ->when($user_id, function ($q) use ($user_id) {
                                return $q->where('id', $user_id);
                            })
                            ->where('status', $status)
                            ->when($designation_id, function ($q) use ($designation_id) {
                                return $q->whereHas('userInfo', function ($q) use ($designation_id) {
                                    $q->where('designation', $designation_id);
                                });
                            })->when($type, function ($q) use ($type) {
                                return $q->whereHas('userInfo', function ($q) use ($type) {
                                    $q->where('employee_type', $type);
                                });
                            })->latest()->get();
                    }
                    $designations = Designation::where('status',1)->get();
                    $roles = Role::where('status',1)->get();
                    $userss = User::whereNotIn('role',['admin'])->get();
                    $status = $request->status ?? 2;
                    return view('admin.user.index',compact('designations','users','roles','userss','user_id','designation_id','type','status'));
                }
                $user_id = 0;
                $status = 2;
                $type = 0;
                $designation_id = 0;
                $designations = Designation::where('status',1)->get();
                $userss = User::latest()->whereNotIn('role',['admin'])->get();
                $users = $userss;
                $roles = Role::where('status',1)->get();
                return view('admin.user.index',compact('designations','users','roles','userss','user_id','designation_id','type','status'));
            }
            else{
                toastr()->error('Permission Denied');
                return back();
            }
        }
        catch (Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }


    }
    public function employees()
    {
        try {
            $designations = Designation::where('status',1)->get();
            $users = User::latest()->whereNotIn('role',['admin'])->get();
            return view('admin.user.index',compact('designations','users'));
        }
        catch (Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }
    }
    public function store(Request $request)
    {
        if(auth()->user()->hasPermission('employees store')){
//            try {
                $validate = Validator::make($request->all(),[
                    "name" => "required|min:3",
                    "join" => "required",
                    "designation" => "required",
                    "gender" => "required",
                    "employee_id" => "required | unique:user_infos,employee_id",
                    "employee_type" => "required",
                    "email" => "required | unique:users,email",
                    'password' => 'required|min:8|required_with:confirm_password|same:confirm_password',
                    'confirm_password' => 'required|min:8'
                ]);
                if($validate->fails())
                {
                    toastr()->error($validate->messages());
                    return redirect()->back();
                }

                $user = new User();
                $user->name = $request->name;
                $user->email = $request->email;
                $user->password = bcrypt($request->password);
                $user->role = 'employee';
                $user->status = $request->status;
                $user->save();
                if ($request->role_id){
                    foreach ($request->role_id as $role) {
                        $userRole = new UserRole();
                        $userRole->user_id = $user->id;
                        $userRole->role_id = $role;
                        $userRole->saveOrFail();
                    }
                }

                $userInfo = new UserInfos();
                $userInfo->user_id = $user->id;
                $userInfo->name = $user->name;
                $userInfo->email = $user->email;
                $userInfo->employee_id = $request->employee_id;
                $userInfo->employee_type = $request->employee_type;
                $userInfo->join = $request->join;
                $userInfo->mobile = $request->phone;
                $userInfo->designation = $request->designation;
                $userInfo->gender = $request->gender;
                $userInfo->status = $request->status;
                $userInfo->save();

                // Trigger event
                event(new GeneralNotificationEvent(
                    'new_employee_created',
                    $user->name.' ('.$userInfo->employee_id.') ',
                    [
                        'content' => "<span> Name : ".$user->name."</span><br>
                                      <span> EIN : SL".$userInfo->employee_id."</span><br>
                                      <span> Designation : ".$user->userInfo->designations->name."</span><br>
                                      <span> Department : ".$user->userInfo->designations->department->department_name."</span><br>
                                      <span> Email : ".$user->email."</span><br>
                                      <span> Employee Type : ".str_replace('_',' ',$userInfo->employee_type)."</span><br>
                                      <span> Joining Date : ".$userInfo->join."</span><br>
                                      <span> Gender : ".ucfirst($userInfo->gender)."</span><br>
                                      <span> Role : ".ucfirst($user->role)."</span><br>
                                      ",
                        'user_id' => auth()->user()->id,
                        'url' => route('employee.profile',$user->id),
                    ]
                ));
                toastr()->success('Employee Added Success.');
                return back();
//            }
//            catch (Exception $exception){
//                toastr()->error($exception->getMessage());
//                return back();
//            }
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function update(Request $request, $id)
    {
        if(auth()->user()->hasPermission('employees update')){
            $user = User::find($id);
            try {
                $validate = Validator::make($request->all(),[
                    "name" => "required|min:3",
                    "join" => "required",
                    "designation" => "required",
                    "gender" => "required",
                    "employee_type" => "required",
                    "employee_id" => [
                        'required',
                        Rule::unique('user_infos')->ignore($user->userInfo->id),
                    ],
                    "email" => [
                        'required',
                        'email',
                        Rule::unique('users')->ignore($user->id),
                        Rule::unique('user_infos')->ignore($user->userInfo->id),
                    ],
                ]);
                if($validate->fails())
                {
                    toastr()->error($validate->messages());
                    return redirect()->back();
                }
                $user->name = $request->name;
                $user->email = $request->email;
                $user->role = 'employee';
                $user->status = $request->status;
                $user->save();

                if ($request->role_id){
                    $userRoles = UserRole::where('user_id',$id)->whereNotIn('role_id',$request->role_id)->pluck('id')->toArray();
                    UserRole::destroy($userRoles);
                    foreach ($request->role_id as $role){
                        $permit = UserRole::where('user_id',$id)->where('role_id',$role)->first();
                        if (!$permit){
                            $permit = new UserRole();
                            $permit->user_id = $user->id;
                            $permit->role_id = $role;
                            $permit->save();
                        }
                    }
                }
                $userInfo = UserInfos::where('user_id',$user->id)->first();
                $userInfo->user_id = $user->id;
                $userInfo->name = $user->name;
                $userInfo->email = $user->email;
                $userInfo->employee_id = $request->employee_id;
                $userInfo->employee_type = $request->employee_type;
                $userInfo->join = $request->join;
                $userInfo->mobile = $request->phone;
                $userInfo->designation = $request->designation;
                $userInfo->gender = $request->gender;
                $userInfo->status = $request->status;
                $userInfo->save();
                toastr()->success('Employee Update Success.');
                return back();
            }
            catch (Exception $exception){
                toastr()->error($exception->getMessage());
                return back();
            }
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function destroy(User $user)
    {
        if (auth()->user()->hasPermission('employees destroy')){
            try{
                $user = User::find($user->id);
                $userRolesIds = UserRole::where('user_id',$user->id)->pluck('id')->toArray();
                UserRole::destroy($userRolesIds);
                $user->delete();
                toastr()->success('Delete Successfully.');
                return back();
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
    public function banUnbanUSer(Request $request,$id){
        try {
            $user = User::find($id);
            $user->status = $request->status;
            $user->save();

            $userInfo = UserInfos::where('user_id',$user->id)->first();
            $userInfo->status = $request->status;
            $userInfo->save();

            toastr()->success('Status Update Success.');
            return back();
        }
        catch (Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }

    }
    public function employeeProfile($id){
        try {
            $user = User::find($id);
            $assets = Asset::where('user_id',$user->id)->latest()->get();
            return view('admin.user.profile',compact('user','assets'));
        }
        catch (Exception $e){
            toastr()->error('Profile Not Found');
            return back();
        }
    }
}
