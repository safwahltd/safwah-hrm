<?php

namespace App\Http\Controllers\admin;

use App\Models\Department;
use App\Models\Designation;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Exception;

class DesignationController extends Controller
{
    public function index()
    {
        if(auth()->user()->hasPermission('designations index')){
            return view('admin.designation.index', [
                'designations' => Designation::latest()->simplePaginate(10),
                'departments' => Department::where('status',1)->orderBy('department_name')->get(),
            ]);
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }


    }

    public function store(Request $request)
    {
        if(auth()->user()->hasPermission('designations store')){
            try {
                $validate = Validator::make($request->all(),[
                    "name" => 'required',
                    "department_id" => 'required',
                ]);
                if($validate->fails())
                {
                    toastr()->error($validate->messages());
                    return redirect()->back();
                }
                $designation = new Designation();
                $designation->name = $request->name;
                $designation->department_id = $request->department_id;
                $designation->status = $request->status;
                $designation->save();
                toastr()->success('Designation Added Success.');
                return back();
            }
            catch (Exception $exception){
                toastr()->success($exception->getMessage());
                return back();
            }
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function update(Request $request, Designation $designation)
    {
        if(auth()->user()->hasPermission('designations update')){
            try {
                $validate = Validator::make($request->all(),[
                    "name" => 'required',
                    "department_id" => 'required',
                ]);
                if($validate->fails())
                {
                    toastr()->error($validate->messages());
                    return redirect()->back();
                }
                $designation->name = $request->name;
                $designation->department_id = $request->department_id;
                $designation->status = $request->status;
                $designation->save();
                toastr()->success('Designation Update Success.');
                return back();
            }
            catch (Exception $exception){
                toastr()->success($exception->getMessage());
                return back();
            }
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }

    public function destroy(Designation $designation)
    {
        if(auth()->user()->hasPermission('designations destroy')){
            try {
                $designation->delete();
                toastr()->success('Delete Designation Success');
                return back();
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
    public function StatusUpdate(Request $request,$id)
    {
        if(auth()->user()->hasPermission('admin designation statusupdate')){
            try {
                $department = Designation::find($id);
                $department->status = $request->status;
                $department->save();
                toastr()->success('Status Change Designation Success');
                return back();
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
}
