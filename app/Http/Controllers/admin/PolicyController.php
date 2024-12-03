<?php

namespace App\Http\Controllers\admin;

use App\Models\Policy;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PolicyController extends Controller
{
    public function index(){
        $policies = Policy::latest()->simplePaginate(100);
        return view('admin.policy.index',compact('policies'));
    }
    public function store(Request $request){
        try{
            $validate = Validator::make($request->all(),[
                'file' => 'required|mimes:xlsx,xls,pdf,docx,jpg,jpeg,png,webp'
            ]);
            if($validate->fails()){
                toastr()->error($validate->messages());
                return back();
            }
            $policy = new Policy();
            $policy->name = $request->name;

            /* File Upload Start */
            $fileName = $request->file('file')->getClientOriginalName();
            $path = 'upload/policy/';
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
    public function update(Request $request,$id){
        try{
            $validate = Validator::make($request->all(),[
                'file' => 'mimes:xlsx,xls,pdf,docx,jpg,jpeg,png,webp',
            ]);
            if($validate->fails()){
                toastr()->error($validate->messages());
                return back();
            }
            $policy = Policy::find($id);
            $policy->name = $request->name;

            if ($request->file('file')){
                if (isset($policy->file)){
                    unlink($policy->file);
                }
                /* File Upload Start */
                $fileName = $request->file('file')->getClientOriginalName();
                $path = 'upload/policy/';
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
    public function destroy($id){
        try{
            $policy = Policy::find($id);
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
    public function showFile($id)
    {
        $policy = Policy::findOrFail($id);
        $filePath = $policy->file;
        $extension = pathinfo($filePath, PATHINFO_EXTENSION);
        // Handle PDF and image files
        if (in_array($extension, ['pdf', 'jpg', 'jpeg', 'png', 'gif', 'bmp','webp','svg','docx', 'doc', 'xlsx', 'xls'])) {
            return response()->file($filePath);
        }
        abort(404, 'File format not supported');

        return response()->file($filePath);
    }
}
