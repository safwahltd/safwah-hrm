<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserInfos;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class AdminAuthController extends Controller
{
    public function login()
    {
        if (auth()->check()){
            return redirect()->route('admin.dashboard');
        }
        return view('admin.auth.login');
    }
    public function loginConfirm(Request $request){
        try {
            $validate = Validator::make($request->all(), [
                'email' => 'required|email',
                'password' => 'required',
            ]);
            if ($validate->fails()) {
                toastr()->error($validate->getMessageBag()->first());
                return redirect()->back()->withErrors($validate)->withInput();
            }
            $credentials = $request->only('email', 'password');
            $user = User::where('email',$request->email)->first();
            if($user){
                if ($user->status == 1){
                    if (Auth::guard('web')->attempt($credentials,$request->has('remember'))){
                        toastr()->success('Login Success.');
                        return redirect()->route('admin.dashboard');
                    }
                    else{
                        toastr()->error("Invalid Credentials!");
                        return back();
                    }
                }
                else{
                    toastr()->error("Your account is Inactive!");
                    return back();
                }
                }
            else{
                toastr()->error("You Are Not Registered!");
                return back();
            }
        }
        catch (Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }
    }
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        toastr()->success("Logout Successfully");
        return redirect()->route('login');
    }
    public function password(){
        return view('admin.auth.password');
    }
    public function updatePassword(Request $request){
        try {
            $validate = Validator::make($request->all(),[
                'old_password'=> 'required',
                'password' => 'min:6|required_with:confirm_password|same:confirm_password',
                'confirm_password' => 'min:6'
            ]);
            if ($validate->fails()){
                toastr()->error($validate->messages());
                return back();
            }
            $user = User::find(auth()->user()->id);
            if ($user) {
                if (password_verify($request->old_password, $user->password)) {
                    $user->password = bcrypt($request->password);
                    $user->save();
                    toastr()->success('Password Change Successfully');
                    return back();
                }
                else {
                    toastr()->error('Current Password Not Matched.');
                    return back();
                }
            }
            else {
                toastr()->error('Data Not Found');
                return back();
            }
        }
        catch (Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }
    }
    public function updateEmail(Request $request){
        try {
            $validate = Validator::make($request->all(),[
                'old_email'=> 'email | required',
                'email' => 'email | required_with:confirm_email|same:confirm_email',
                'confirm_email' => 'email | required'
            ]);
            if ($validate->fails()){
                toastr()->error($validate->messages());
                return back();
            }
            $user = User::find(auth()->user()->id);
            if ($user) {
                if ($request->old_email == $user->email) {
                    $user->email = $request->email;
                    $user->save();
                    $userInfo = UserInfos::where('user_id',$user->id)->first();
                    $userInfo->email = $request->email;
                    $userInfo->save();
                    toastr()->success('Email Change Successfully');
                    return back();
                }
                else {
                    toastr()->error('Current Email Not Matched.');
                    return back();
                }
            }
            else {
                toastr()->error('Data Not Found');
                return back();
            }
        }
        catch (Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }
    }
    public function userPassword(){
        $users = User::whereNotIn('id',[1])->orderBy('name','asc')->get();
        return view('admin.user.password',compact('users'));
    }
    public function updateUserPassword(Request $request){
        try {
            $validate = Validator::make($request->all(),[
                'password' => 'min:6|required_with:confirm_password|same:confirm_password',
                'confirm_password' => 'min:6'
            ]);
            if ($validate->fails()){
                toastr()->error($validate->messages());
                return back();
            }
            $user = User::find($request->user_id);
            if ($user) {
                $user->password = bcrypt($request->password);
                $user->save();
                toastr()->success('Password Change Successfully');
                return back();
            }
            else {
                toastr()->error('Data Not Found');
                return back();
            }
        }
        catch (Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }
    }
    public function updateUserEmail(Request $request){
        try {
            $validate = Validator::make($request->all(),[
                'email' => 'email | required_with:confirm_email|same:confirm_email',
                'confirm_email' => 'email'
            ]);
            if ($validate->fails()){
                toastr()->error($validate->messages());
                return back();
            }
            $user = User::find($request->user_id);
            if ($user) {
                $user->email = $request->email;
                $user->save();
                $userInfo = UserInfos::where('user_id',$user->id)->first();
                $userInfo->email = $request->email;
                $userInfo->save();
                toastr()->success('Email Change Successfully');
                return back();
            }
            else {
                toastr()->error('Data Not Found');
                return back();
            }
        }
        catch (Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }
    }
}
