<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Department;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Exception;

class DepartmentController extends Controller
{

    public function index()
    {
        return view('admin.department.index', [
            'departments' => Department::latest()->simplePaginate(10),
        ]);
    }


    public function create()
    {
        //
    }

    public function store(Request $request)
    {
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

    public function show(Department $department)
    {
        //
    }

    public function edit(Department $department)
    {
        //
    }

    public function update(Request $request, Department $department)
    {
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

    public function destroy(Department $department)
    {
        try {
            $department->delete();
            toastr()->success('Delete Department Success');
            return back();
        }
        catch (Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }
    }
    public function StatusUpdate(Request $request,$id)
    {
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

}
