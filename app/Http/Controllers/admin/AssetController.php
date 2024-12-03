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
        if(auth()->user()->hasPermission('asset index')){
            return view('admin.asset.index',[
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
        if(auth()->user()->hasPermission('asset store')){
            try {
                $validate = Validator::make($request->all(),[
                    'asset_name' => 'required',
                    'asset_id' => 'required|unique:assets,asset_id',
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
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function update(Request $request, Asset $asset)
    {
        if(auth()->user()->hasPermission('asset update')){
            try {
                $validate = Validator::make($request->all(),[
                    'asset_name' => 'required',
                    "asset_id" => [
                        'required',
                        Rule::unique('assets')->ignore($asset->id),
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
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function destroy(Asset $asset)
    {
        if(auth()->user()->hasPermission('asset destroy')){
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

    /*public  function employeeFilter(Request $request){
        $users = User::whereNotIn('role',['admin'])->get();
//        dd($request->employeeName,$request->employeeId);
        $userName = $request->employeeName;
        $employeeId = $request->employeeId;
        // Start with Asset query
        if ($userName || $employeeId){
            $assets = DB::table('assets')->join('user_infos as user_info1', 'user_info1.user_id', '=', 'assets.user_id')
                ->when($userName, function ($query) use ($userName) {
                    return $query->where('user_info1.name', 'like', '%' . $userName . '%');
                })
                ->when($employeeId, function ($query) use ($employeeId) {
                    return $query->where('user_info1.employee_id', $employeeId);
                })
                ->get();
        }
        else{
            $assets = Asset::latest()->get();
        }


        dd($assets);
//        if ($userName || $employeeId) {
            /*$query->when($userName, function($q) use ($userName) {
                $q->join('user_infos', as 'user_infos' 'user_infos.user_id', '=', 'assets.user_id')
                    ->where('user_infos.name', 'like', "%{$userName}%");
            })->when($employeeId, function($q) use ($employeeId) {
                    $q->join('user_infos', 'user_infos.user_id', '=', 'assets.user_id')
                        ->where('user_infos.employee_id', $employeeId);
            })->get();*/
//        }

        // Execute the query and get the results
        /*$assets = $query->get();
        return view('admin.asset.employeeFilter',compact('assets','users'));*/

        /*if ($request->employeeName){
            if ($request->employeeName == 'null'){
                $assets = Asset::get();
                return view('admin.asset.employeeFilter',compact('assets','users'));
            }
            else{
                $employeee = User::where('name', 'like', '%' . $request->employeeName . '%')->get()->pluck('id');
                $assets = Asset::whereIn('user_id',$employeee)->get();
                return view('admin.asset.employeeFilter',compact('assets','users'));
            }
        }
        if ($request->employeeId){
            if ($request->employeeId == 'null'){
                $assets = Asset::get();
                return view('admin.asset.employeeFilter',compact('assets','users'));
            }
            else{
                $employeeId = UserInfos::where('employee_id', '=', $request->employeeId)->get()->pluck('user_id');
                $assets = Asset::whereIn('user_id',$employeeId)->get();
                return view('admin.asset.employeeFilter',compact('assets','users'));
            }
        }*/
//    }*/
}
