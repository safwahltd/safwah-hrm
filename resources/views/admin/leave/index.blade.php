@extends('admin.layout.app')
@section('title','Employee Management')
@section('body')
    <style>
        label {
            display: inline-block;
            padding-bottom: 10px;
        }
    </style>
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold text-white mb-0">Leave</h3>
            </div>
        </div>
    </div>
    <!-- Row end  -->

    <div class="row clearfix g-3">
        <div class="col-sm-12">
            <div class="card mb-3">
                <div class="card-body export-table bg-dark-subtle">
                    <table id="example3" class="table table-bordered text-nowrap table-secondary key-buttons border-bottom w-100">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>Name <sub>(Id)</sub></th>
                            <th>Type</th>
                            <th class="text-center">Date</th>
                            <th>Days</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($leaves as $key => $leave)
                            <tr>
                                <td>
                                    <span class="fw-bold">{{$loop->iteration}}</span>
                                </td>
                                <td>
                                    {{ \Illuminate\Support\Carbon::parse($leave->created_at)->format('d M,Y') }}
                                </td>
                                <td><span class="fw-bold">{{$leave->user->name}}  <sub>({{$leave->user->userInfo->employee_id}})</sub></span></td>

                                <td>
                                    {{ ucwords(str_replace('_',' ',$leave->leave_type))}}
                                </td>
                                <td class="text-center fw-bold">
                                    <span class="text-primary">{{ \Illuminate\Support\Carbon::parse($leave->start_date)->format('d M,Y') }} </span>&nbsp;
                                    <span><i class="fa fa-arrow-right"></i></span>&nbsp;
                                    &nbsp;<span class="text-danger"> {{ \Illuminate\Support\Carbon::parse($leave->end_date)->format('d M,Y') }}</span>
                                </td>
                                <td class="text-center">
                                    {{ $leave->days_taken }}
                                </td>
                                <td>
                                    <span class="p-1 rounded-2 {{$leave->status == 0 ? 'bg-warning':''}}{{$leave->status == 1 ? 'bg-success text-white':''}}{{$leave->status == 2 ? 'bg-danger text-white':''}}{{$leave->status == 3 ? 'bg-danger text-white':''}}">
                                        {{$leave->status == 0 ? 'Pending':''}}{{$leave->status == 1 ? 'Approved':''}}{{$leave->status == 2 ? 'Rejected':''}}{{$leave->status == 3 ? 'Canceled':''}}
                                    </span>
                                </td>
                                <td>
                                    <div class="" role="group" aria-label="Basic outlined example">
                                        <button type="button" class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#depedit{{$key}}"><i class="icofont-eye text-white "></i></button>
                                        <a href="{{route('admin.leave.request.print',$leave->id)}}" class="btn btn-success btn-sm">print</a>
                                    </div>
                                </td>
                            </tr>
                            <!-- Edit Department-->
                            <div class="modal fade" id="depedit{{$key}}" tabindex="-1"  aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title  fw-bold" id="depeditLabel"> Leave Request Show</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="deadline-form">
                                                    <div class="modal-body">
                                                        <div class="deadline-form">
                                                            <div class="row g-3 mb-3">
                                                                <div class="col-md-7">
                                                                    <p> <span class="fw-bold">Employee Name : </span><span>{{ucwords($leave->user->name)}}</span></p>
                                                                    <p> <span class="fw-bold">Employee Id : </span><span>{{ucwords($leave->user->userInfo->employee_id)}}</span></p>
                                                                    <p> <span class="fw-bold">Leave Type : </span><span>{{ucwords(str_replace('_',' ',$leave->leave_type))}}</span></p>
                                                                    @if($leave->leave_type == 'half_day')
                                                                        <p> <span class="fw-bold">From : </span><span>{{ \Illuminate\Support\Carbon::parse($leave->start_time)->format('H:i a') }}</span></p>
                                                                        <p> <span class="fw-bold">To : </span><span>{{ \Illuminate\Support\Carbon::parse($leave->end_time)->format('H:i a') }}</span></p>
                                                                    @else
                                                                        <p> <span class="fw-bold">From : </span><span>{{$leave->start_date}}</span></p>
                                                                        <p> <span class="fw-bold">To : </span><span>{{$leave->end_date}}</span></p>
                                                                    @endif
                                                                    <p> <span class="fw-bold">Concern Person : </span><span>{{$leave->concern_person}}</span></p>
                                                                    <p> <span class="fw-bold">Address & Contact : </span><span>{{$leave->address_contact}}</span></p>
                                                                </div>
                                                                <div class="col-md-5">
                                                                    <h4 class="fw-bold">Leave Balance</h4>
                                                                    <p> <span class="fw-bold">Employee Name : </span><span>{{ucwords($leave->user->name)}}</span></p>
                                                                    <p> <span class="fw-bold">Employee Id : </span><span>{{ucwords($leave->user->userInfo->employee_id)}}</span></p>
                                                                    <p> <span class="fw-bold">Sick Leave Balance : </span><span>{{$leave->user->userInfo->sick_leave}}</span></p>
                                                                    <p> <span class="fw-bold">Casual Leave Balance : </span><span>{{$leave->user->userInfo->casual_leave}}</span></p>
                                                                    <p> <span class="fw-bold">Half Day Leave Balance : </span><span>{{$leave->user->userInfo->half_day_leave}}</span></p>
                                                                    <div class="my-2">
                                                                        <form action="{{route('admin.leave.update',$leave->id)}}" method="post">
                                                                            @csrf
                                                                            <select name="status" id="" onchange="return confirm('are you sure ?') ? this.form.submit():''" class="form-control-sm text-center {{$leave->status == 0 ? 'bg-warning':''}}{{$leave->status == 1 ? 'bg-success text-white':''}}{{$leave->status == 2 ? 'bg-danger text-white':''}}{{$leave->status == 3 ? 'bg-danger text-white':''}}">
                                                                                <option {{$leave->status == 0 ? 'selected':''}} value="0">Pending</option>
                                                                                <option {{$leave->status == 1 ? 'selected':''}} value="1">Approve</option>
                                                                                <option {{$leave->status == 2 ? 'selected':''}} value="2">Reject</option>
                                                                                <option {{$leave->status == 3 ? 'selected':''}} value="3">Cancel</option>
                                                                            </select>
                                                                        </form>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                            <div class="row g-3 mb-3">
                                                                <div class="col-sm-12">
                                                                    <label for="end_dateAdd" class="form-label"><p> <span class="fw-bold">Reason : </span></p></label>
                                                                    <div class="">
                                                                        <p>{{$leave->reason}}</p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-white my-3 d-grid justify-content-center">
                        {{$leaves->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->

@endsection
