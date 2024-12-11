<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use App\Models\User;
use http\Exception\BadConversionException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class DepartmentController extends Controller
{

    public function index()
    {
        if(auth()->user()->hasPermission('admin department index')){
            return view('admin.department.index', [
                'departments' => Department::latest()->where('soft_delete',0)->simplePaginate(100),
                'users' => User::whereNotIn('id',[1])->orderBy('name','asc')->get(),
            ]);
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function edit($id){
        try {
            $dept = Department::find($id);
            $departments = Department::latest()->whereNotIn('id',[$dept->id])->where('soft_delete',0)->simplePaginate(100);
            $users = User::whereNotIn('id',[1])->orderBy('name','asc')->get();
            return view('admin.department.edit',compact('dept','departments','users'));
        }
        catch (Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }

    }
    public function store(Request $request)
    {
        if(auth()->user()->hasPermission('admin department store')){
            try {
                $validate = Validator::make($request->all(),[
                    "department_name" => 'required',
                ]);
                if($validate->fails())
                {
                    toastr()->error($validate->messages());
                    return redirect()->back();
                }
                $department = new Department();
                $department->department_name = $request->department_name;
                $department->department_head = $request->department_head;
                $department->status = $request->status;
                $department->save();
                toastr()->success('Department Added Success.');
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
    public function update(Request $request, Department $department)
    {
        if(auth()->user()->hasPermission('admin department update')){
            try {
                $validate = Validator::make($request->all(),[
                    "department_name" => 'required',
                ]);
                if($validate->fails())
                {
                    toastr()->error($validate->messages());
                    return redirect()->back();
                }
                $department->department_name = $request->department_name;
                $department->department_head = $request->department_head;
                $department->status = $request->status;
                $department->save();
                toastr()->success('Department Updated Success.');
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
    public function destroy(Department $department)
    {
        if(auth()->user()->hasPermission('admin department destroy')){
            try {
                $department->department_name = $department->department_name;
                $department->department_head = $department->department_head;
                $department->status = $department->status;
                $department->soft_delete = 1;
                $department->saveOrFail();
                toastr()->success('Delete Department Success');
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
        if(auth()->user()->hasPermission('admin department StatusUpdate')){
            try {
                $department = Department::find($id);
                $department->status = $request->status;
                $department->save();
                toastr()->success('Status Change Department Success');
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
