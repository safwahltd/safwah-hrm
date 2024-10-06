<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
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
    public function index()
    {
        $designations = Designation::where('status',1)->get();
        $users = User::latest()->whereNotIn('role',['admin'])->get();
        $roles = Role::where('status',1)->get();
        return view('admin.user.index',compact('designations','users','roles'));
    }
    public function employees()
    {
        $designations = Designation::where('status',1)->get();
        $users = User::latest()->whereNotIn('role',['admin'])->get();
        return view('admin.user.index',compact('designations','users'));
    }


    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(),[
                "name" => "required|min:3",
                "join" => "required",
                "designation" => "required",
                "gender" => "required",
                "employee_id" => "required|unique:user_infos,employee_id",
                "employee_type" => "required",
                "email" => "required|unique:users,email",
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
            toastr()->success('Employee Added Success.');
            return back();
        }
        catch (Exception $exception){
            toastr()->error($exception->getMessage());
            return back();
        }
    }
    public function update(Request $request, $id)
    {
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

    public function destroy(User $user)
    {
        if (auth()->user()->hasPermission('admin user destroy')){
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
            toastr()->error('You Have No Permission.');
            return back();
        }
    }
    public function banUnbanUSer(Request $request,$id){

        $user = User::find($id);
        $user->status = $request->status;
        $user->save();

        $userInfo = UserInfos::where('user_id',$user->id)->first();
        $userInfo->status = $request->status;
        $userInfo->save();

        toastr()->success('Status Update Success.');
        return back();
    }
    public function employeeProfile($id){
        $user = User::find($id);
        return view('admin.user.profile',compact('user'));
    }
}
