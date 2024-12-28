<?php

namespace App\Http\Controllers\admin;

use App\Models\Holiday;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use Exception;
use DateTime;

class HolidayController extends Controller
{
    public function index(){
        if(auth()->user()->hasPermission('admin holiday index')){
            return view('admin.holiday.index',[
                'holidays' => Holiday::latest()->simplePaginate(500),
            ]);
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function store(Request $request){
        if(auth()->user()->hasPermission('admin holiday store')){
            try {
                $validate = Validator::make($request->all(),[
                    "name" => 'required',
                    "date_from" => 'required',
                    "date_to" => 'required',
                ]);
                if($validate->fails())
                {
                    toastr()->error($validate->messages());
                    return redirect()->back();
                }
                /* Total days count */
//                $startDate = new DateTime($request->date_from);
                $startDate = Carbon::parse($request->date_from);
                $endDate = Carbon::parse($request->date_to);
//                $endDate = new DateTime($request->date_to);
                $total = $startDate->diff($endDate);
                $dates = collect();

                $currentDate = $startDate->copy();

                while ($currentDate->lte($endDate)) {
                    $dates->push($currentDate->toDateString());  // Add the date to the collection
                    $currentDate->addDay();  // Move to the next day
                }

                /* Total days count end */

                $holiday = new Holiday();
                $holiday->name = $request->name;
                $holiday->date_from = $request->date_from;
                $holiday->date_to = $request->date_to;
                $holiday->dates = json_encode($dates);
                if ($startDate == $endDate){
                    $holiday->total_day = 1;
                }
                else{
                    $holiday->total_day = $total->days + 1;
                }
                $holiday->status = $request->status;
                $holiday->save();
                toastr()->success('Holiday Added Success.');
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
    public function update(Request $request,Holiday $holiday){
        if(auth()->user()->hasPermission('admin holiday update')){
            try {
                $validate = Validator::make($request->all(),[
                    "name" => 'required',
                    "date_from" => 'required',
                    "date_to" => 'required',
                ]);
                if($validate->fails())
                {
                    toastr()->error($validate->messages());
                    return redirect()->back();
                }
                /* Total days count */
                $startDate = Carbon::parse($request->date_from);
                $endDate = Carbon::parse($request->date_to);
                $total = $startDate->diff($endDate);
                $dates = collect();
                $currentDate = $startDate->copy();
                while ($currentDate->lte($endDate)) {
                    $dates->push($currentDate->toDateString());
                    $currentDate->addDay();
                }
                $holiday->name      = $request->name;
                $holiday->date_from = $request->date_from;
                $holiday->date_to   = $request->date_to;
                $holiday->dates = json_encode($dates);
                if ($startDate == $endDate){
                    $holiday->total_day = 1;
                }
                else{
                    $holiday->total_day = $total->days + 1;
                }
                $holiday->status    = $request->status;
                $holiday->save();
                toastr()->success('Holiday Update Success.');
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
    public function destroy(Holiday $holiday)
    {
        if(auth()->user()->hasPermission('admin holiday destroy')){
            try {
                $holiday->delete();
                toastr()->success('Delete Holiday Success.');
            }
            catch (Exception $e){
                toastr()->error($e->getMessage());
            }
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function StatusUpdate(Request $request,$id)
    {
        if(auth()->user()->hasPermission('admin holiday statusupdate')){
            try {
                $holiday = Holiday::find($id);
                $holiday->status = $request->status;
                $holiday->save();
                toastr()->success('Status Change Holiday Success');
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
    public function employeeIndex(Request $request){
        $currentDate = Carbon::now();
        $endOfYear = $currentDate->copy()->endOfYear();
        if ($request->type == 'left'){
            $holidays = Holiday::where('date_from', '>', $currentDate)->where('date_to', '<=', $endOfYear)->orderBy('date_from')->get();
            return view('employee.holiday.index',[
                'holidays' => $holidays,
                'type' => $request->type,
            ]);
        }
        $holidays = Holiday::latest()->simplePaginate(20);

        return view('employee.holiday.index',[
            'holidays' => $holidays,
            'type' => $request->type,
        ]);
    }
}
