<?php

namespace App\Http\Controllers\employee;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\User;
use App\Models\UserInfos;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class EmployeeAccountController extends Controller
{
    public function profile(){
        $user = User::find(auth()->user()->id);
        $assets = Asset::where('user_id',$user->id)->latest()->get();
        return view('employee.profile.profile',compact('user','assets'));
    }
    public function personalInfoUpdate(Request $request){
        $userInfo = UserInfos::where('user_id',auth()->user()->id)->first();
        try {
            $validate = Validator::make($request->all(),[
                "personal_email" => Rule::unique('user_infos')->ignore($userInfo->id),
            ]);
            if($validate->fails())
            {
                toastr()->error($validate->messages());
                return redirect()->back();
            }
            $userInfo->name = $request->name;
            $userInfo->mobile = $request->mobile;
            $userInfo->official_mobile = $request->official_mobile;
            $userInfo->personal_email = $request->personal_email;
            $userInfo->date_of_birth = $request->date_of_birth;
            $userInfo->gender = $request->gender;
            $userInfo->present_address = $request->present_address;
            $userInfo->permanent_address = $request->permanent_address;
            $userInfo->facebook = $request->facebook;
            $userInfo->instagram = $request->instagram;
            $userInfo->linkedIn = $request->linkedIn;
            $userInfo->twitter = $request->twitter;
            $userInfo->github = $request->github;
            $userInfo->biography = $request->biography;
            $userInfo->save();

            $user = User::find(auth()->user()->id);
            $user->name = $request->name;
            $user->save();

            toastr()->success('Update Info Success.');
            return back();
        }
        catch (Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }

    }

    public function generalInfoUpdate(Request $request){
        try {
            $userInfo = UserInfos::where('user_id',auth()->user()->id)->first();
            $userInfo->nationality = $request->nationality;
            $userInfo->religion = $request->religion;
            $userInfo->marital_status = $request->marital_status;
            $userInfo->passport_or_nid = $request->passport_or_nid;
            $userInfo->emergency_contact = $request->emergency_contact;
            $userInfo->father = $request->father;
            $userInfo->mother = $request->mother;
            $userInfo->spouse = $request->spouse;
            $userInfo->family_member = $request->family_member;
            $userInfo->save();
            toastr()->success('Update Info Success.');
            return back();
        }
        catch (Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }

    }

    public function bankInfoUpdate(Request $request){
        try {
            $validate = Validator::make($request->all(),[
                "bank_name" => 'required',
                "account_name" => 'required',
                "account_number" => 'required',
                "name_of_branch" => 'required',
                "swift_number" => 'required',
                "routing_number" => 'required',
            ]);
            if($validate->fails())
            {
                toastr()->error($validate->messages());
                return redirect()->back();
            }
            $userInfo = UserInfos::where('user_id',auth()->user()->id)->first();
            $userInfo->bank_name = $request->bank_name;
            $userInfo->account_name = $request->account_name;
            $userInfo->account_number = $request->account_number;
            $userInfo->name_of_branch = $request->name_of_branch;
            $userInfo->swift_number = $request->swift_number;
            $userInfo->routing_number = $request->routing_number;
            $userInfo->bank_code = $request->bank_code;
            $userInfo->branch_code = $request->branch_code;
            $userInfo->save();
            toastr()->success('Update Info Success.');
            return back();
        }
        catch (Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }

    }
    public function profilePictureUpdate(Request $request){
        try {
            $userInfo = UserInfos::where('user_id',auth()->user()->id)->first();
            $image = $request->file('image');
            $imageExtension = $image->getClientOriginalExtension();
            $imageName = time().'.'.$imageExtension;
            $destination = 'upload/profile/';
            $image->move($destination,$imageName);
            $imageUrl = $destination.$imageName;
            if (file_exists($userInfo->image)){
                unlink($userInfo->image);
            }
            $userInfo->image = $imageUrl;
            $userInfo->save();

            toastr()->success('Update Profile Picture Success.');
            return back();
        }
        catch (Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }
    }

}
