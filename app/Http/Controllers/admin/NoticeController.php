<?php

namespace App\Http\Controllers\admin;

use App\Models\Notice;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Mockery\Matcher\Not;

class NoticeController extends Controller
{
    public function index()
    {
        $notices = Notice::latest()->paginate(20);
        return view('admin.notice.index', compact('notices'));
    }

    public function store(Request $request)
    {
        try {
            $validate = Validator::make($request->all(),[
                'title' => 'required|max:255',
                'details' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
            ]);
            if ($validate->fails()){
                toastr()->error($validate->messages());
                return back();
            }
            $notice = new Notice();
            $notice->user_id = auth()->user()->id;
            $notice->title = $request->title;
            $notice->content = $request->details;
            $notice->start_date = $request->start_date;
            $notice->end_date = $request->end_date;
            $notice->status = $request->status;
            $notice->save();
            toastr()->success('Notice created successfully.');
            return back();
        }
        catch (\Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }
    }

    public function update(Request $request,$id)
    {
        try {
            $validate = Validator::make($request->all(),[
                'title' => 'required|max:255',
                'details' => 'required',
                'start_date' => 'required|date',
                'end_date' => 'nullable|date|after_or_equal:start_date',
            ]);
            if ($validate->fails()){
                toastr()->error($validate->messages());
                return back();
            }
            $notice = Notice::find($id);
            $notice->user_id = auth()->user()->id;
            $notice->title = $request->title;
            $notice->content = $request->details;
            $notice->start_date = $request->start_date;
            $notice->end_date = $request->end_date;
            $notice->status = $request->status;
            $notice->save();
            toastr()->success('Notice Updated successfully.');
            return back();
        }
        catch (\Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }
    }

    // Delete a notice (for admin/HR)
    public function destroy($id)
    {
        try {
            $notice = Notice::find($id);
            $notice->delete();
            toastr()->success('Notice Delete Successfully.');
            return back();
        }
        catch (\Exception $e){
            toastr()->error($e->getMessage());
            return back();
        }
    }
    public function download($id){
        $notice = Notice::find($id);

        // Generate PDF for the notice letter
        $pdf = Pdf::loadView('admin.notice.pdf', compact('notice'));

        // Return the PDF download response
        return $pdf->download('notice_'.$notice->title.'.pdf');
    }
    public function employeeShowList(){
        $notices = Notice::where('status',1)->orderBy('created_at', 'desc')->get();
        return view('employee.notice.index',compact('notices'));
    }
}
