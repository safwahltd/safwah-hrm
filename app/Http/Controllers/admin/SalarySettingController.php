<?php

namespace App\Http\Controllers\admin;
use App\Http\Controllers\Controller;

use App\Models\SalarySetting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SalarySettingController extends Controller
{
    public function index(){
        $settings = SalarySetting::latest()->get();
        return view('admin.salary.setting',compact('settings'));
    }
    public function store(Request $request){
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
    public function update(Request $request,$id){
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
    public function destroy($id){
        try{
            $d = SalarySetting::find($id);
            $d->delete();
            toastr()->success('Delete Successfully.');
            return back();
        }
        catch(\Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }

    }
}
