<?php

namespace App\Http\Controllers\admin;

use App\Models\Asset;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Validation\Rule;

class AssetController extends Controller
{
    public function index()
    {
        return view('admin.assets.index',[
            'assets' => Asset::latest()->paginate(10),
            'users' => User::whereNotIn('role',['admin'])->get(),
        ]);
    }
    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(),[
                'asset_name' => 'required',
                'asset_id' => 'required|unique:assets,asset_id',
                'user_id' => 'required',
                'value' => 'required',
            ]);
            if ($validate->fails()){
                toastr()->error($validate->messages());
                return back();
            }
            $asset = new Asset();
            $asset->asset_name = $request->asset_name;
            $asset->user_id = $request->user_id;
            $asset->asset_model = $request->asset_model;
            $asset->asset_id = $request->asset_id;
            $asset->purchase_date = $request->purchase_date;
            $asset->purchase_from = $request->purchase_from;
            $asset->warranty = $request->warranty;
            $asset->warranty_end = $request->warranty_end;
            $asset->hand_in_date = $request->hand_in_date;
            $asset->hand_over_date = $request->hand_over_date;
            $asset->condition = $request->condition;
            $asset->value = $request->value;
            $asset->description = $request->description;
            $asset->status = $request->status;
            $asset->save();
            toastr()->success('Asset Added Successfully.');
            return back();
        }
        catch (Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }

    }
    public function update(Request $request, Asset $asset)
    {
        try {
            $validate = Validator::make($request->all(),[
                'asset_name' => 'required',
                "asset_id" => [
                    'required',
                    Rule::unique('assets')->ignore($asset->id),
                ],
                'user_id' => 'required',
                'value' => 'required',
            ]);
            if ($validate->fails()){
                toastr()->error($validate->messages());
                return back();
            }
            $asset->asset_name = $request->asset_name;
            $asset->user_id = $request->user_id;
            $asset->asset_model = $request->asset_model;
            $asset->asset_id = $request->asset_id;
            $asset->purchase_date = $request->purchase_date;
            $asset->purchase_from = $request->purchase_from;
            $asset->warranty = $request->warranty;
            $asset->warranty_end = $request->warranty_end;
            $asset->hand_in_date = $request->hand_in_date;
            $asset->hand_over_date = $request->hand_over_date;
            $asset->condition = $request->condition;
            $asset->value = $request->value;
            $asset->description = $request->description;
            $asset->status = $request->status;
            $asset->save();
            toastr()->success('Asset Update Successfully.');
            return back();
        }
        catch (Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }
    }
    public function destroy(Asset $asset)
    {
        try {
            $asset->delete();
            toastr()->success('Asset Delete Successfully.');
            return back();
        }
        catch (Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }
    }

    public  function employeeFilter(Request $request){
        $employeee = User::where('name', 'like', '%' . $request->employeeName . '%')->get()->pluck('id');
        $assets = Asset::whereIn('user_id',$employeee)->get();
        if ($assets){
            $users = User::whereNotIn('role',['admin'])->get();
            return view('admin.assets.employeeFilter',compact('assets','users'));
        }
//        $employeeIds = A
        return view('admin.assets.employeeFilter',compact('assets','users'));
    }
}
