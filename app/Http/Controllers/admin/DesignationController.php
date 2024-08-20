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
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('admin.designation.index', [
            'designations' => Designation::latest()->simplePaginate(10),
            'departments' => Department::where('status',1)->orderBy('department_name')->get(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
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

    /**
     * Display the specified resource.
     */
    public function show(Designation $designation)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Designation $designation)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Designation $designation)
    {
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

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Designation $designation)
    {
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
    public function StatusUpdate(Request $request,$id)
    {
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
}
