<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\Designation;
use App\Models\User;
use App\Models\UserInfos;
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
        return view('admin.user.index',compact('designations','users'));
    }

    public function create()
    {
        //
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

            $userInfo = new UserInfos();
            $userInfo->user_id = $user->id;
            $userInfo->name = $user->name;
            $userInfo->email = $user->email;
            $userInfo->employee_id = $request->employee_id;
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

    public function show(User $user)
    {
        //
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

            $userInfo = UserInfos::where('user_id',$user->id)->first();
            $userInfo->user_id = $user->id;
            $userInfo->name = $user->name;
            $userInfo->email = $user->email;
            $userInfo->employee_id = $request->employee_id;
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
        //
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
}
