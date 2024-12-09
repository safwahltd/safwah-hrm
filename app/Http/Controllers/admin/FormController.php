<?php

namespace App\Http\Controllers\admin;

use App\Models\Form;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class FormController extends Controller
{
    public function index(){
        if(auth()->user()->hasPermission('admin form index')){
            $forms = Form::latest()->simplePaginate(100);
            return view('admin.form.index',compact('forms'));
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function store(Request $request){
        if(auth()->user()->hasPermission('admin form store')){
            try{
                $validate = Validator::make($request->all(),[
                    'file' => 'required|mimes:xlsx,xls,pdf,docx,jpg,jpeg,png,webp'
                ]);
                if($validate->fails()){
                    toastr()->error($validate->messages());
                    return back();
                }
                $policy = new Form();
                $policy->name = $request->name;

                /* File Upload Start */
                $fileName = $request->file('file')->getClientOriginalName();
                $path = 'upload/form/';
                $request->file('file')->move($path,$fileName);
                $url = $path.$fileName;
                $policy->file = $url;
                /* File Upload End */

                $policy->save();
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
        if(auth()->user()->hasPermission('admin form update')){
            try{
                $validate = Validator::make($request->all(),[
                    'file' => 'mimes:xlsx,xls,pdf,docx,jpg,jpeg,png,webp',
                ]);
                if($validate->fails()){
                    toastr()->error($validate->messages());
                    return back();
                }
                $policy = Form::find($id);
                $policy->name = $request->name;

                if ($request->file('file')){
                    if (isset($policy->file)){
                        unlink($policy->file);
                    }
                    /* File Upload Start */
                    $fileName = $request->file('file')->getClientOriginalName();
                    $path = 'upload/form/';
                    $request->file('file')->move($path,$fileName);
                    $url = $path.$fileName;
                    $policy->file = $url;
                    /* File Upload End */
                }

                $policy->save();
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
        if(auth()->user()->hasPermission('admin form destroy')){
            try{
                $policy = Form::find($id);
                if (isset($policy->file)){
                    unlink($policy->file);
                }
                $policy->delete();
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
    public function showFile($id)
    {
        if(auth()->user()->hasPermission('admin form showfile')){
            $policy = Form::findOrFail($id);
            $filePath = $policy->file;
            $extension = pathinfo($filePath, PATHINFO_EXTENSION);
            // Handle PDF and image files
            if (in_array($extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'bmp','webp','svg','docx', 'doc', 'xlsx', 'xls'])) {
                return response()->file($filePath);
            }
            abort(404, 'File format not supported');
            return response()->file($filePath);
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
}
