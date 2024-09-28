<?php

namespace App\Http\Controllers\admin;

use App\Models\Termination;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Exception;

class TerminationController extends Controller
{
    public function index(){
        $terminations = Termination::latest()->paginate(20);
        $users = User::where('role','employee')->orderBy('name','asc')->get();
        return view('admin.termination.index',compact('terminations','users'));
    }
    public function store(Request $request){
        try{
            $validate = Validator::make($request->all(),[
                'employee_id' => 'required',
                'reason' => 'required',
                'terminated_at' => 'required',
            ]);
            if($validate->fails()){
                toastr()->error($validate->messages());
                return back();
            }
            $termination = new Termination();
            $termination->employee_id = $request->employee_id;
            $termination->reason = $request->reason;
            $termination->details = $request->details;
            $termination->terminated_at = $request->terminated_at;
            $termination->notice_date = now();
            $termination->save();
            toastr()->success('Termination Create Successfully.');
            return back();
        }
        catch(Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }

    }
    public function update(Request $request,$id){
        try{
            $validate = Validator::make($request->all(),[
                'employee_id' => 'required',
                'reason' => 'required',
                'terminated_at' => 'required',
            ]);
            if($validate->fails()){
                toastr()->error($validate->messages());
                return back();
            }
            $termination = Termination::find($id);
            $termination->employee_id = $request->employee_id;
            $termination->reason = $request->reason;
            $termination->details = $request->details;
            $termination->terminated_at = $request->terminated_at;
            $termination->notice_date = now();
            $termination->save();
            toastr()->success('Termination Update Successfully.');
            return back();
        }
        catch(Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }
    }
    public function destroy($id){
        try{
            $d = Termination::find($id);
            $d->delete();
            toastr()->success('Delete Successfully.');
            return back();
        }
        catch(Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }

    }
    public function download($id){
        $termination = Termination::find($id);

        // Generate PDF for the termination letter
        $pdf = Pdf::loadView('admin.termination.pdf', compact('termination'));

        // Return the PDF download response
        return $pdf->download('termination_letter_'.$termination->employee->userInfo->employee_id.'.pdf');
    }
}
