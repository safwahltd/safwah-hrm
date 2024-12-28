<?php

namespace App\Http\Controllers\admin;

use App\Models\Asset;
use App\Models\User;
use App\Models\UserInfos;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Exception;
use Illuminate\Validation\Rule;

class AssetController extends Controller
{
    public function index()
    {
        if(auth()->user()->hasPermission('admin asset index')){
            return view('admin.admin.asset.index',[
                'assets' => Asset::latest()->paginate(10),
                'users' => User::whereNotIn('role',['admin'])->get(),
            ]);
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function store(Request $request)
    {
        if(auth()->user()->hasPermission('admin asset store')){
            $checkAsset = Asset::where('asset_id',$request->asset_id)->where('status',1)->first();
            if (!$checkAsset){
                try {
                    $validate = Validator::make($request->all(),[
                        'asset_name' => 'required',
                        'asset_id' => 'required',
                        'user_id' => 'required',
                        'value' => 'required|numeric|min:0',
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
            else{
                toastr()->error('This Asset Already In Used');
                return back();
            }

        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function update(Request $request, Asset $asset)
    {
        if(auth()->user()->hasPermission('admin asset update')){
            $checkAsset = Asset::where('asset_id',$request->asset_id)->where('status',1)->whereNotIn('id',[$asset->id])->first();
            if (!$checkAsset){
                try {
                    $validate = Validator::make($request->all(),[
                        'asset_name' => 'required',
                        "asset_id" => [
                            'required',
                        ],
                        'user_id' => 'required',
                        'value' => 'required|numeric|min:0',
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
            else{
                toastr()->error('This Asset Already In Used');
                return back();
            }
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function destroy(Asset $asset)
    {
        if(auth()->user()->hasPermission('admin asset destroy')){
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
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
}
