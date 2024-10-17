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
        if (auth()->check()){
            if (auth()->user()->role == 'admin'){
                return redirect()->route('admin.dashboard');
            }
            if (auth()->user()->role == 'employee'){
                return redirect()->route('employee.dashboard');
            }
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
                    if ($user->role == 'admin'){
                        if (Auth::guard('web')->attempt($credentials,$request->has('remember'))){
                            toastr()->success('Login Successfull');
                            return redirect()->route('admin.dashboard');
                        }
                        else{
                            toastr()->error("Invalid Credentials!");
                            return back();
                        }
                    }
                    elseif ($user->role == 'employee'){
                        if (Auth::guard('web')->attempt($credentials)){
                            toastr()->success('Login Successfull');
                            return redirect()->route('employee.dashboard');
                        }
                        else{
                            toastr()->error("Invalid Credentials!");
                            return back();
                        }
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
}
