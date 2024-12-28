<?php

namespace App\Http\Controllers\admin;

use App\Events\EmployeeNotificationEvent;
use App\Events\GeneralNotificationEvent;
use App\Models\Notice;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Mockery\Matcher\Not;

class NoticeController extends Controller
{
    public function index()
    {
        if(auth()->user()->hasPermission('admin notice index')){
            $notices = Notice::latest()->paginate(100);
            return view('admin.notice.index', compact('notices'));
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function store(Request $request)
    {
        if(auth()->user()->hasPermission('admin notice store')){
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

                // Trigger event
                event(new GeneralNotificationEvent(
                    'new_notice',
                     $notice->title,
                     [
                         'content' => $notice->content,
                         'user_id' => $notice->user_id,
                     ]
                ));
                // Fetch all active employees
                $employees = User::where('status', '1')->where('role','employee')->get();
                // Trigger event
                foreach ($employees as $employee) {
                    event(new EmployeeNotificationEvent(
                        'new_notice',
                        $notice->title,
                        $employee->id,
                        [
                            'content' => $notice->content,
                            'user_id' => $notice->user_id,
                        ]

                    ));
                }

                toastr()->success('Notice created successfully.');
                return back();
            }
            catch (\Exception $e){
                toastr()->error($e->getMessage());
                return back();
            }
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function update(Request $request,$id)
    {
        if(auth()->user()->hasPermission('admin notice update')){
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
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function destroy($id)
    {
        if(auth()->user()->hasPermission('admin notice destroy')){
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
        else{
            toastr()->error('Permission Denied');
            return back();
        }
    }
    public function download($id){
        if(auth()->user()->hasPermission('admin notice download')){
            try {
                $notice = Notice::find($id);
                $pdf = Pdf::loadView('admin.notice.pdf', compact('notice'));
                return $pdf->download('notice_'.$notice->title.'.pdf');
            }
            catch (\Exception $e){
                toastr()->error($e->getMessage());
                return back();
            }
        }
        else{
            toastr()->error('Permission Denied');
            return back();
        }

    }
    public function employeeShowList(){
        if(auth()->user()->hasPermission('employee notice list')){
            try {
                $notifications = auth()->user()->notifications()->paginate(50);
                return view('employee.notice.index', compact('notifications'));
            }
            catch (\Exception $e){
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
