@extends('admin.layout.app')
@section('title','Leave Management')
@section('body')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Leave Management</h3>
            </div>
        </div>
    </div>
    <!-- Row end  -->

    <div class="row clearfix g-3">
        <div class="col-sm-3">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills mb-3" id="pills-tab-2" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">Full Day</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Half Day</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <form class="p-4" action="{{route('admin.full.leave.store')}}" method="post">
                                @csrf
                                <div class="row g-3 mb-3">
                                    <div class="col-sm-12">
                                        <label class="form-label">Sick <span class="text-danger">*</span></label>
                                        <input type="number" min="0" name="sick" class="form-control" value="{{old('sick')}}" placeholder="sick leave number" required>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="form-label">Casual <span class="text-danger">*</span></label>
                                        <input type="number" min="0" name="casual" class="form-control" value="{{old('casual')}}" placeholder="casual leave number" required>
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="yearFullEdit" class="form-label">Year <span class="text-danger">*</span></label><br>
                                        <select class="form-control-lg select2-example" name="year" id="yearFullEdit" required>
                                            @for ($i = date('Y'); $i >= 2022; $i--)
                                                <option {{old('year') == $i ? 'selected':''}} value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-sm-12">
                                        <label for="user_idFull" class="form-label"> Employee <sub>(optional)</sub></label><br>
                                        <select class="form-control select2-example" multiple  name="user_id[]" id="user_idFull" style="width: 100%;">
                                            @foreach($users as $user)
                                                <option value="{{ $user->id }}">{{ $user->name }} <sub>({{ $user->userInfo->employee_id }})</sub></option>
                                            @endforeach
                                        </select>
                                    </div>

                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <form class="p-4" action="{{route('admin.half.leave.store')}}" method="post">
                                @csrf
                                <div class="row g-3 mb-3">
                                    <div class="col-sm-12 my-2">
                                        <label for="monthHalf" class="form-label">Month <span class="text-danger">*</span></label><br>
                                        <select class="form-control-sm" name="month" id="monthHalf" required>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-sm-12 my-2">
                                        <label for="yearHalf" class="form-label">Year <span class="text-danger">*</span></label><br>
                                        <select class="form-control-lg select2-example" name="year" id="yearHalf" required>
                                            @for ($i = date('Y'); $i >= 2022; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                    </div>
                                    <div class="col-sm-12 my-2">
                                        <label for="half_day" class="form-label">Half Day <span class="text-danger">*</span></label>
                                        <input type="number" min="0" name="half_day" class="form-control" placeholder="half day number" required>
                                    </div>
                                    <div class="col-sm-12">
                                        <label class="form-label"> Employee <sub>(optional)</sub></label><br>
                                        <select class="form-control-lg select2-example" multiple name="user_id[]" style="width: 100%" >
                                            @foreach($users as $key => $user)
                                                <option value="{{ $user->id }}">{{ $user->name }} <sub>({{ $user->userInfo->employee_id }})</sub></option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="modal-footer">
                                    <button type="submit" class="btn btn-primary">Save</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <div class="col-sm-9">
            <div class="card">
                <div class="card-body">
                    <ul class="nav nav-pills mb-3" id="pills-tab-1" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active" id="full-day-tab" data-bs-toggle="pill" data-bs-target="#full-day-table" type="button" role="tab" aria-controls="full-day-table" aria-selected="true">Full Day</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link" id="half-day-tab" data-bs-toggle="pill" data-bs-target="#half-day-table" type="button" role="tab" aria-controls="half-day-table" aria-selected="false">Half Day</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent-1">
                        <div class="tab-pane table-responsive fade show active" id="full-day-table" role="tabpanel" aria-labelledby="full-day-tab">
                            <table id="basic-datatable" class="table table-bordered text-nowrap table-secondary key-buttons border-bottom w-100">
                                <thead>
                                <tr style="background-color: #00b864">
                                    <th>No</th>
                                    <th>Name</th>
                                    <th>Sick</th>
                                    <th>Casual</th>
                                    <th>year</th>
                                    <th>Actions</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($leaveBalances as $key => $leaveBalance)
                                    <tr>
                                        <td>
                                            <span class="fw-bold">{{$loop->iteration}}</span>
                                        </td>
                                        <td class="text-primary fw-bold" style="font-size: 13px">{{$leaveBalance->user->name}} <sub>({{$leaveBalance->user->userInfo->employee_id}})</sub></td>
                                        <td>
                                            <span class="text-primary fw-bold">Available : <span class="text-primary fw-bold">{{$leaveBalance->sick}}</span></span><br>
                                            <span class="text-danger fw-bold">Spent : <span class="text-danger fw-bold">{{$leaveBalance->sick_spent}}</span></span><br>
                                            <span class="text-success fw-bold">Left : <span class="text-success fw-bold">{{$leaveBalance->sick_left}}</span></span>
                                        </td>
                                        <td>
                                            <span class="text-primary fw-bold">Available : {{$leaveBalance->casual}}</span><br>
                                            <span class="text-danger fw-bold">Spent : {{$leaveBalance->casual_spent}}</span><br>
                                            <span class="text-success fw-bold">Left : {{$leaveBalance->casual_left}}</span>

                                        </td>
                                        <td class="text-success fw-bold">{{$leaveBalance->year}}</td>
                                        <td>
                                            <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#fullDayBalance{{$key}}"><i class="icofont-edit text-success"></i></button>
                                                <form action="{{route('admin.full.leave.delete',$leaveBalance->id)}}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <button type="submit" onclick="return confirm('are you sure to delete ? ')" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                    <!-- Edit holiday-->
                                        <div class="modal fade" id="fullDayBalance{{$key}}" tabindex="-1"  aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title  fw-bold" id="fullDayBalanceLabel">Leave Balance Edit</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="deadline-form">
                                                            <form action="{{route('admin.full.leave.update',$leaveBalance->id)}}" method="post">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="row g-3 mb-3">
                                                                    <div class="col-sm-6">
                                                                        <label for="sick" class="form-label">Sick</label>
                                                                        <input type="number" name="sick" class="form-control" value="{{$leaveBalance->sick}}" placeholder="sick leave number">
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <label for="sick" class="form-label">Casual</label>
                                                                        <input type="number" name="casual" class="form-control" value="{{$leaveBalance->casual}}" placeholder="casual leave number">
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <label for="yearFullEdit" class="form-label">Year</label><br>
                                                                        <p><span class="bg-success p-1 text-white rounded-2">{{ $leaveBalance->year }}</span></p>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <label for="user_idFullEdit" class="form-label"> Employee </label><br>
                                                                        <p><span class="bg-success p-1 text-white rounded-2">{{ $leaveBalance->user->name }}</span></p>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary">save</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                @endforeach
                                </tbody>
                            </table>
                            <div class="text-white my-3 d-grid justify-content-center">
                                {{$leaveBalances->links()}}
                            </div>
                        </div>
                        <div class="tab-pane fade" id="half-day-table" role="tabpanel" aria-labelledby="half-day-tab">
                            <div class="table-responsive">
                                <table id="example2" class="table table-bordered text-nowrap table-secondary key-buttons border-bottom w-100">
                                    <thead>
                                    <tr>
                                        <th>SL</th>
                                        <th>Name</th>
                                        <th>Month</th>
                                        <th>Year</th>
                                        <th>Half Day</th>
                                        <th>Spent</th>
                                        <th>Left</th>
                                        <th>Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($halfDayLeaveBalances as $key => $halfDayLeaveBalance)
                                        <tr>
                                            <td>
                                                <span class="fw-bold">{{$loop->iteration}}</span>
                                            </td>
                                            <td>{{$halfDayLeaveBalance->user->name}}</td>
                                            <td>{{ date('F', mktime(0, 0, 0, $halfDayLeaveBalance->month, 1)) }}</td>
                                            <td align="center"s>{{$halfDayLeaveBalance->year}}</td>
                                            <td align="center">{{$halfDayLeaveBalance->half_day}}</td>
                                            <td align="center">{{$halfDayLeaveBalance->spent}}</td>
                                            <td align="center">{{$halfDayLeaveBalance->left}}</td>
                                            <td>
                                                <div class="btn-group" role="group" aria-label="Basic outlined example">
                                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#HalfDayBalance{{$key}}"><i class="icofont-edit text-success"></i></button>
                                                    <form action="{{route('admin.half.leave.delete',$halfDayLeaveBalance->id)}}" method="post">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" onclick="return confirm('are you sure to delete ? ')" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                        <!-- Edit holiday-->
                                        <div class="modal fade" id="HalfDayBalance{{$key}}" tabindex="-1"  aria-hidden="true">
                                            <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title  fw-bold" id="fullDayBalanceLabel">Leave Balance Edit</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        <div class="deadline-form">
                                                            <form action="{{route('admin.half.leave.update',$halfDayLeaveBalance->id)}}" method="post">
                                                                @csrf
                                                                @method('PUT')
                                                                <div class="row g-3 mb-3">
                                                                    <div class="col-sm-6">
                                                                        <label for="sick" class="form-label">Half Day</label>
                                                                        <input type="number" name="half_day" class="form-control" value="{{$halfDayLeaveBalance->half_day}}" placeholder="sick leave number">
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <label for="" class="form-label">Month</label><br>
                                                                        <p><span class="bg-success p-1 text-white rounded-2">{{ date('F', mktime(0, 0, 0, $halfDayLeaveBalance->month, 1)) }}</span></p>
                                                                    </div>
                                                                    <div class="col-sm-6">
                                                                        <label for="yearFullEdit" class="form-label">Year</label><br>
                                                                        <p><span class="bg-success p-1 text-white rounded-2">{{ $halfDayLeaveBalance->year }}</span></p>
                                                                    </div>

                                                                    <div class="col-sm-6">
                                                                        <label for="user_idFullEdit" class="form-label"> Employee </label><br>
                                                                        <p><span class="bg-success p-1 text-white rounded-2">{{ $halfDayLeaveBalance->user->name }}</span></p>
                                                                    </div>
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" class="btn btn-primary">save</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                    </tbody>
                                </table>
                                <div class="text-white my-3 d-grid justify-content-center">
                                    {{$halfDayLeaveBalances->links()}}
                                </div>
                            </div>


                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->
@endsection

