@extends('admin.layout.app')
@section('title','Leave')
@section('body')
    <style>
        .input-groups {
            display: none; /* Hide all input groups by default */
        }
    </style>
    <div class="row px-0">
        <div class="col-md-3 col-lg-2 col-6 text-center">
            <div class="card p-2 my-1">
                <p class="text-black m-0 fw-bold text-uppercase" style="font-size: 12px;">Total Leave </p>
                <p class="fw-bold" style="margin-bottom: 0; margin-top: 5px; color: #664d03">
                    {{ $totalLeave = (($leaveBalance->sick ?? 0) + ($leaveBalance->casual ?? 0)) }} <br>
                    <small>Sick : {{$leaveBalance->sick ?? 0}}</small>
                    <small>Casual : {{$leaveBalance->casual ?? 0}}</small>
                </p>
            </div>
        </div>
        <div class="col-md-3 col-lg-2 col-6 text-center">
            <div class="card p-2 my-1">
                <p class="text-black m-0 fw-bold text-uppercase" style="font-size: 12px;">Leave Spent</p>
                <p class="fw-bold text-primary" style="margin-bottom: 0; margin-top: 5px;">
                    {{ $spentTotal = ($leaveBalance->sick_spent ?? 0) + ($leaveBalance->casual_spent ?? 0) }}<br>
                    <small>Sick : {{$leaveBalance->sick_spent ?? 0}}</small>
                    <small>Casual : {{$leaveBalance->casual_spent ?? 0}}</small>
                </p>
            </div>
        </div>
        <div class="col-md-3 col-lg-2 col-6 text-center">
            <div class="card p-2 my-1">
                <p class="text-black m-0 fw-bold text-uppercase" style="font-size: 12px;">Leave Left</p>
                <p class="fw-bold text-success" style="margin-bottom: 0; margin-top: 5px;">
                    {{ $totalLeave - $spentTotal ?? 0 }}<br>
                    <small>Sick : {{$leaveBalance->sick_left ?? 0 }}</small>
                    <small>Casual : {{$leaveBalance->casual_left ?? 0 }}</small>
                </p>
            </div>
        </div>
        <div class="col-md-3 col-lg-2 col-6 text-center">
            <div class="card p-2 my-1">
                <p class="text-black m-0 fw-bold text-uppercase" style="font-size: 12px;">Half Day</p>
                <p class="fw-bold text-danger" style="margin-bottom: 0; margin-top: 5px;">{{ $leaveBalanceHalfDay->half_day ?? 0 }}</p>
            </div>
        </div>
        <div class="col-md-3 col-lg-2 col-6 text-center">
            <div class="card p-2 my-1">
                <p class="text-black m-0 fw-bold text-uppercase" style="font-size: 12px;">Half Day Spent</p>
                <p class="fw-bold text-primary" style="margin-bottom: 0; margin-top: 5px;">{{ $leaveBalanceHalfDay->spent ?? 0 }}</p>
            </div>
        </div>
        <div class="col-md-3 col-lg-2 col-6 text-center">
            <div class="card p-2 my-1">
                <p class="text-black m-0 fw-bold text-uppercase" style="font-size: 12px;">Half Day Left</p>
                <p class="fw-bold text-primary" style="margin-bottom: 0; margin-top: 5px;">{{ $leaveBalanceHalfDay->left ?? 0 }}</p>
            </div>
        </div>
    </div>
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Leave</h3>
                <div class="col-auto d-flex w-sm-100">
                    <button type="button" class="btn btn-dark btn-set-task w-sm-100" data-bs-toggle="modal" data-bs-target="#requestAdd"><i class="icofont-plus-circle me-2 fs-6"></i>Leave Request</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Row end  -->
    <div class="row clearfix g-3">
        <div class="col-sm-12">
            <div class="card mb-3">
                <div class="card-body table-responsive">
                    <table id="basic-datatable" class="table table-hover table-striped align-middle mb-0" style="width:100%">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Date</th>
                            <th>Type</th>
                            <th class="text-center">Leave <sub>(Date/Time)</sub></th>
                            <th>Days</th>
                            <th>Status</th>
                            <th class="text-center">Actions</th>
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
                                <td class="fw-bold {{$leave->leave_type == 'sick' ? 'text-primary':''}}{{$leave->leave_type == 'casual' ? 'text-success':''}}{{$leave->leave_type == 'half_day' ? 'text-danger':''}} text-uppercase">
                                    {{ ucwords(str_replace('_',' ',$leave->leave_type))}}
                                </td>
                                <td class="text-center fw-bold">
                                    @if($leave->leave_type != 'half_day')
                                        <span class="text-primary">{{ \Illuminate\Support\Carbon::parse($leave->start_date)->format('d M,Y') }} </span>&nbsp;
                                        <span><i class="fa fa-arrow-right"></i></span>&nbsp;
                                        &nbsp;<span class="text-danger"> {{ \Illuminate\Support\Carbon::parse($leave->end_date)->format('d M,Y') }}</span>

                                    @else
                                        <span class="text-primary">{{ \Illuminate\Support\Carbon::parse($leave->start_time)->format('H:i a') }} </span>&nbsp;
                                        <span><i class="fa fa-arrow-right"></i></span>&nbsp;
                                        &nbsp;<span class="text-danger"> {{ \Illuminate\Support\Carbon::parse($leave->end_time)->format('H:i a') }} </span>
                                    @endif

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
                                    <div class="d-flex justify-content-center" role="group" aria-label="Basic outlined example">
                                        @if($leave->status == 0)
                                            <a href="" class="btn btn-primary btn-sm me-1" data-bs-toggle="modal" data-bs-target="#depedit{{$key}}"><i class="icofont-edit text-white "></i></a>
                                            <form action="{{route('employee.leave.request.cancel',$leave->id)}}" method="post">
                                                @csrf
                                                <button type="submit" onclick="return confirm('are you sure to cancel request ? ')" class="btn btn-danger mx-1 text-white btn-sm"><i class="fa fa-xmark-circle text-white"></i> </button>
                                            </form>
                                        @endif
                                        <a href="" class="btn btn-success btn-sm me-1" data-bs-toggle="modal" data-bs-target="#depShow{{$key}}"><i class="icofont-eye text-white "></i></a>
                                        <a href="{{route('employee.leave.request.print',$leave->id)}}" class="btn btn-success btn-sm">print</a>

                                    </div>
                                </td>
                            </tr>
                            <!-- Edit Department-->
                            <div class="modal fade" id="depedit{{$key}}" tabindex="-1"  aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title  fw-bold" id="depeditLabel"> Leave Request Edit</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="deadline-form">
                                                <form action="{{route('employee.leave.request.update',$leave->id)}}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="deadline-form">
                                                            <div class="row g-3 mb-3">
                                                                <div class="col-sm-4">
                                                                    <label for="leave_type_idAdd" class="form-label">Leave Type <span class="text-danger">*</span></label>
                                                                    <select class="form-control leave_edit_type" data-id="{{ $key }}" name="leave_type" id="leave_type_idAdd">
                                                                        <option value="" disabled selected>Select Leave Type</option>
                                                                        <option {{ $leave->leave_type == 'sick' ? 'selected':''}} {{$leave->leave_type == 'half_day' ? 'disabled':''}} value="sick">Sick</option>
                                                                        <option {{$leave->leave_type == 'casual' ? 'selected':''}}  {{$leave->leave_type == 'half_day' ? 'disabled':''}} value="casual">Casual</option>
                                                                        <option {{$leave->leave_type == 'half_day' ? 'selected':''}} {{ $leave->leave_type == 'sick' ? 'disabled':''}} {{ $leave->leave_type == 'casual' ? 'disabled':''}} value="half_day">Half Day</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-4 date_group_edit{{$key}} {{ $leave->leave_type == 'half_day' ? 'input-groups':''}}">
                                                                    <label for="start_dateAdd" class="form-label">From Date <span class="text-danger">*</span></label>
                                                                    <input class="form-control" type="date" name="start_date" value="{{$leave->start_date}}" id="start_dateAdd">
                                                                </div>
                                                                <div class="col-sm-4 date_group_edit{{$key}} {{ $leave->leave_type == 'half_day' ? 'input-groups  ':''}}">
                                                                    <label for="end_dateAdd" class="form-label">To Date <span class="text-danger">*</span></label>
                                                                    <input class="form-control" type="date" name="end_date" value="{{$leave->end_date}}" id="end_dateAdd">
                                                                </div>
                                                                <div class="col-sm-4  time_group{{$key}} {{ $leave->leave_type == 'half_day' ? '':'input-groups '}}">
                                                                    <label for="start_timeAdd" class="form-label">From Time <span class="text-danger">*</span></label>
                                                                    <input class="form-control" type="time" name="start_time" value="{{$leave->start_time}}" id="from_timeAdd">
                                                                </div>
                                                                <div class="col-sm-4 time_group{{$key}} {{ $leave->leave_type == 'half_day' ? '':'input-groups'}}">
                                                                    <label for="end_timeAdd" class="form-label">To Time <span class="text-danger">*</span></label>
                                                                    <input class="form-control" type="time" name="end_time" value="{{$leave->end_time}}" id="to_timeAdd">
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="concernPersonAdd" class="form-label">Concern Person <span class="text-danger">*</span></label>
                                                                    <input class="form-control" required name="concern_person" placeholder="concern person during leave" value="{{$leave->concern_person}}" id="concernPersonAdd"/>
                                                                </div>
                                                                <div class="col-sm-4">
                                                                    <label for="address_contactAdd" class="form-label">Address & Contact <span class="text-danger">*</span></label>
                                                                    <input class="form-control" required name="address_contact" placeholder="address & contact during leave" value="{{$leave->address_contact}}" id="address_contactAdd"/>
                                                                </div>
                                                            </div>

                                                            <div class="row g-3 mb-3">
                                                                <div class="col-sm-12">
                                                                    <label for="end_dateAdd" class="form-label">Reason <span class="text-danger">*</span></label>
                                                                    <textarea class="form-control" required name="reason" cols="30" maxlength="250" rows="5">{{$leave->reason}}</textarea>
                                                                </div>
                                                            </div>
                                                            <div class="row g-3 mb-3">
                                                                <div class="col-sm-12">
                                                                    <label for="end_dateAdd" class="form-label">Status </label>
                                                                    <span class="p-1 rounded-2 {{$leave->status == 0 ? 'bg-warning':''}}{{$leave->status == 1 ? 'bg-success':''}}{{$leave->status == 2 ? 'bg-danger':''}}">
                                                                        {{$leave->status == 0 ? 'Pending':''}}{{$leave->status == 1 ? 'Approved':''}}{{$leave->status == 2 ? 'Rejected':''}}{{$leave->status == 3 ? 'Canceled':''}}
                                                                    </span>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">update</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="depShow{{$key}}" tabindex="-1"  aria-hidden="true">
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
                                                                    <p><span class="fw-bold"> {{ $leave->days_taken > 1 ? 'Dates':'Date'}} : </span><span>{{$leave->start_date}}</span></p>
                                                                @else
                                                                    <p> <span class="fw-bold">From : </span><span>{{$leave->start_date}}</span></p>
                                                                    <p> <span class="fw-bold">To : </span><span>{{$leave->end_date}}</span></p>
                                                                    <p> <span class="fw-bold">Total Day : </span><span>{{$leave->days_taken}}</span></p>
                                                                    <p><span class="fw-bold"> {{ $leave->days_taken > 1 ? 'Dates':'Date'}} : </span><span>{{$leave->dates}}</span></p>
                                                                @endif
                                                                <p> <span class="fw-bold">Concern Person : </span><span>{{$leave->concern_person}}</span></p>
                                                                <p> <span class="fw-bold">Address & Contact : </span><span>{{$leave->address_contact}}</span></p>
                                                            </div>
                                                            <div class="col-md-5 bg-dark-subtle text-center">
                                                                <h4 class="fw-bold my-3">Leave Balance</h4>
                                                                <hr>
                                                                @php
                                                                    if($leave->leave_type == 'sick' || $leave->leave_type == 'casual'){$leaveBalance = \App\Models\LeaveBalance::where('user_id',$leave->user_id)->where('year',\Illuminate\Support\Carbon::parse($leave->start_date)->format('Y'))->first();}
                                                                    elseif ($leave->leave_type == 'half_day'){$leaveBalance = \App\Models\HalfDayLeaveBalance::where('user_id',$leave->user_id)->where('year',\Illuminate\Support\Carbon::parse($leave->start_date)->format('Y'))->where('month',\Illuminate\Support\Carbon::parse($leave->start_date)->format('m'))->first();}
                                                                @endphp
                                                                <p> <span class="fw-bold">Name : </span><span>{{ucwords($leave->user->name)}}</span></p>
                                                                <p> <span class="fw-bold">ID : </span><span>{{ucwords($leave->user->userInfo->employee_id)}}</span></p>
                                                                @if($leave->leave_type == 'sick')
                                                                <p> <span class="fw-bold">Sick Leave Balance : </span><span>{{$leaveBalance->sick_left}}</span></p>
                                                                @endif
                                                                @if($leave->leave_type == 'casual')
                                                                <p> <span class="fw-bold">Casual Leave Balance : </span><span>{{$leaveBalance->casual_left}}</span></p>
                                                                @endif
                                                                @if($leave->leave_type == 'half_day')
                                                                <p> <span class="fw-bold">Half Day Leave Balance : </span><span>{{$leaveBalance->left ?? 'N/A'}}</span></p>
                                                                @endif
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

    <!-- Add Department-->
    <div class="modal fade" id="requestAdd" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title  fw-bold" id="depaddLabel"> Leave Request</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('employee.leave.request')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="deadline-form">
                            <div class="row g-3 mb-3">
                                <div class="col-sm-4">
                                    <label for="leave_type_idAdd" class="form-label">Leave Type <span class="text-danger">*</span></label>
                                    <select class="form-control leave_type" name="leave_type" id="leave_type_idAdd">
                                        <option value="" disabled selected>Select Leave Type</option>
                                        <option {{old('leave_type') == 'sick' ? 'selected':''}} value="sick">Sick</option>
                                        <option {{old('leave_type') == 'casual' ? 'selected':''}} value="casual">Casual</option>
                                        <option {{old('leave_type') == 'half_day' ? 'selected':''}} value="half_day">Half Day</option>
                                    </select>
                                </div>
                                <div class="col-sm-4 date_group input-groups">
                                    <label for="start_dateAdd" class="form-label">From Date <span class="text-danger">*</span></label>
                                    <input class="form-control" type="date" name="start_date" value="{{old('start_date')}}" id="start_dateAdd">
                                </div>
                                <div class="col-sm-4 date_group  input-groups">
                                    <label for="end_dateAdd" class="form-label">To Date <span class="text-danger">*</span></label>
                                    <input class="form-control" type="date" name="end_date" value="{{old('end_date')}}" id="end_dateAdd">
                                </div>
                                <div class="col-sm-4 time_group input-groups">
                                    <label for="start_timeAdd" class="form-label">From Time <span class="text-danger">*</span></label>
                                    <input class="form-control" type="time" name="start_time" value="{{old('start_time')}}" id="from_timeAdd">
                                </div>
                                <div class="col-sm-4 time_group  input-groups">
                                    <label for="end_timeAdd" class="form-label">To Time <span class="text-danger">*</span></label>
                                    <input class="form-control" type="time" name="end_time" value="{{old('end_time')}}" id="to_timeAdd">
                                </div>
                                <div class="col-sm-4">
                                    <label for="concernPersonAdd" class="form-label">Concern Person <span class="text-danger">*</span></label>
                                    <input class="form-control" required name="concern_person" placeholder="concern person during leave" value="{{old('concern_person')}}" id="concernPersonAdd"/>
                                </div>
                                <div class="col-sm-4">
                                    <label for="address_contactAdd" class="form-label">Address & Contact <span class="text-danger">*</span></label>
                                    <input class="form-control" required name="address_contact" placeholder="address & contact during leave" value="{{old('address_contact')}}" id="address_contactAdd"/>
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-sm-12">
                                    <label for="end_dateAdd" class="form-label">Reason <span class="text-danger">*</span></label>
                                    <textarea class="form-control" required name="reason" placeholder="reason for leave" cols="30" rows="5">{{old('reason')}}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

@push('js')
    <script>
        $(document).ready(function() {
            $('.leave_type').change(function() {
                var leaveType = $(this).val();
                $('.input-groups').hide();
                if (leaveType === 'casual' || leaveType === 'sick') {
                    $('.date_group').show();
                } else if (leaveType === 'half_day') {
                    $('.time_group').show();
                }
            });

            $('.leave_edit_type').change(function() {
                var leaveType = $(this).val();
                var leaveId = $(this).data('id');
                $('.input-groups').hide();
                if (leaveType === 'casual' || leaveType === 'sick') {
                    $('.date_group_edit.leaveId').show();
                } else if (leaveType === 'half_day') {
                    $('.time_group.leaveId').show();
                }
            });


        });
    </script>
@endpush
