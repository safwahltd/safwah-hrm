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
        return view('admin.holiday.index',[
            'holidays' => Holiday::latest()->simplePaginate(10),
        ]);
    }
    public function store(Request $request){
        try {
            $validate = Validator::make($request->all(),[
                "name" => 'required',
            ]);
            if($validate->fails())
            {
                toastr()->error($validate->messages());
                return redirect()->back();
            }
            /* Total days count */
            $startDate = new DateTime($request->date_from);
            $endDate = new DateTime($request->date_to);
            $total = $startDate->diff($endDate);
//            dd($startDate,$endDate,$total->days);
            /* Total days count end */

            $holiday = new Holiday();
            $holiday->name = $request->name;
            $holiday->date_from = $request->date_from;
            $holiday->date_to = $request->date_to;
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
    public function update(Request $request,Holiday $holiday){
        try {
            $validate = Validator::make($request->all(),[
                "name" => 'required',
            ]);
            if($validate->fails())
            {
                toastr()->error($validate->messages());
                return redirect()->back();
            }
            $startDate = new DateTime($request->date_from);
            $endDate = new DateTime($request->date_to);
            $total = $startDate->diff($endDate);

            $holiday->name      = $request->name;
            $holiday->date_from = $request->date_from;
            $holiday->date_to   = $request->date_to;
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
    public function destroy(Holiday $holiday)
    {
        try {
            $holiday->delete();
            toastr()->success('Delete Holiday Success.');
        }
        catch (Exception $e){
            toastr()->error($e->getMessage());
        }
    }
    public function StatusUpdate(Request $request,$id)
    {
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
