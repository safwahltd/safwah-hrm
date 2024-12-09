<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use App\Models\SalarySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalarySettingController extends Controller
{
    public function index(){
        if(auth()->user()->hasPermission('admin salary setting index')){
            $settings = SalarySetting::where('soft_delete',0)->latest()->get();
            return view('admin.salary.setting',compact('settings'));
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function store(Request $request){
        if(auth()->user()->hasPermission('admin salary setting store')){
            try{
                $validate = Validator::make($request->all(),[
                    'name' => 'required',
                    'type' => 'required',
                ]);
                if($validate->fails()){
                    toastr()->error($validate->messages());
                    return back();
                }
                $salary = new SalarySetting();
                $salary->name = $request->name;
                $salary->type = $request->type;
                $salary->placeholder = $request->placeholder;
                $salary->status = $request->status;
                $salary->save();
                toastr()->success('Add Successfully.');
                return back();
            }
            catch(\Exception $e){
                toastr()->error($e->getMessage());
                return back();
            }
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function update(Request $request,$id){
        if(auth()->user()->hasPermission('admin salary setting update')){
            try{
                $validate = Validator::make($request->all(),[
                    'name' => 'required',
                    'type' => 'required',
                ]);
                if($validate->fails()){
                    toastr()->error($validate->messages());
                    return back();
                }
                $salary = SalarySetting::find($id);
                $salary->name = $request->name;
                $salary->type = $request->type;
                $salary->placeholder = $request->placeholder;
                $salary->status = $request->status;
                $salary->save();
                toastr()->success('Update Successfully.');
                return back();
            }
            catch(\Exception $e){
                toastr()->error($e->getMessage());
                return back();
            }
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function destroy($id){
        if(auth()->user()->hasPermission('admin salary setting destroy')){
            try{
                $salary = SalarySetting::find($id);
                $salary->soft_delete = 1;
                $salary->save();
                toastr()->success('Delete Successfully.');
                return back();
            }
            catch(\Exception $e){
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
