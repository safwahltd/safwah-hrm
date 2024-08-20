<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
class AdminAuthController extends Controller
{
    public function login()
    {
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
                    if (Auth::guard('web')->attempt($credentials)){
                        if ($user->role == 'admin') {
                            toastr()->success('Login Successfull');
                            return redirect()->route('admin.dashboard');
                        }
                        elseif ($user->role == 'employee') {
                            toastr()->success('Login Successfull');
                            return redirect()->route('user.dashboard');
                        }
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
    public function logout()
    {
        Auth::logout();
        toastr()->success("Logout Successfully");
        return redirect()->route('login');
    }
}
