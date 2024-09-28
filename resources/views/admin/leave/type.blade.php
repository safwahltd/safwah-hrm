@extends('admin.layout.app')
@section('title','Leave Type Management')
@section('body')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0">Leave Type</h3>
                <div class="col-auto d-flex w-sm-100">
                    <button type="button" class="btn btn-dark btn-set-task w-sm-100" data-bs-toggle="modal" data-bs-target="#leaveTypeadd"><i class="icofont-plus-circle me-2 fs-6"></i>Add New Type</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Row end  -->

    <div class="row clearfix g-3">
        <div class="col-sm-12">
            <div class="card mb-3">
                <div class="card-body">
                    <table id="myProjectTable" class="table table-hover align-middle mb-0" style="width:100%">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Name</th>
                            <th>Per Year <sub>(days)</sub></th>
                            <th>Per Month <sub>(days)</sub></th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($leaveTypes as $key => $leaveType)
                            <tr>
                                <td>
                                    <span class="fw-bold">{{$loop->iteration}}</span>
                                </td>
                                <td>{{$leaveType->name}}</td>
                                <td>{{$leaveType->days_per_year}}</td>
                                <td>{{$leaveType->days_per_month}}</td>
                                <td>
                                    <form action="{{route('admin.holiday.StatusUpdate',$leaveType->id)}}" method="post">
                                        @csrf
                                        <select name="status" id="" class="form-control text-white {{$leaveType->status == 1 ? 'bg-success':'bg-danger'}}" onchange="this.form.submit()">
                                            <option {{$leaveType->status == 1 ? 'selected':''}} value="1">Active</option>
                                            <option {{$leaveType->status == 0 ? 'selected':''}} value="0">Inactive</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#depedit{{$key}}"><i class="icofont-edit text-success"></i></button>
                                        <form action="{{route('admin.leave.type.destroy',$leaveType->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('are you sure to delete ? ')" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <!-- Edit holiday-->
                            <div class="modal fade" id="depedit{{$key}}" tabindex="-1"  aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title  fw-bold" id="depeditLabel"> Leave Type Edit</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="deadline-form">
                                                <form action="{{route('admin.leave.type.update')}}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <input type="hidden" value="{{$leaveType->id}}" name="id">
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="nameEdit" class="form-label">Leave Type Name</label>
                                                            <input type="text" name="name" value="{{$leaveType->name}}" class="form-control" id="nameEdit">
                                                        </div>
                                                        <div class="deadline-form">
                                                            <div class="row g-3 mb-3">
                                                                <div class="col-sm-6">
                                                                    <label for="days_per_year" class="form-label">Days Per Year</label>
                                                                    <input type="number" value="{{$leaveType->days_per_year}}" name="days_per_year" class="form-control">
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <label for="days_per_month" class="form-label">Days Per Month</label>
                                                                    <input type="number" value="{{$leaveType->days_per_month}}" name="days_per_month" class="form-control">
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <label for="status" class="form-label">Status</label>
                                                                    <select class="form-control" name="status" id="status">
                                                                        <option {{$leaveType->status == 1 ? 'selected':''}} value="1">Active</option>
                                                                        <option {{$leaveType->status == 0 ? 'selected':''}} value="0">Inactive</option>
                                                                    </select>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Submit</button>
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
                        {{$leaveTypes->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->

    <!-- Add holiday-->
    <div class="modal fade" id="leaveTypeadd" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title  fw-bold" id="depaddLabel"> holiday Add</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.leave.type.store')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">leave Type Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" required class="form-control" id="name">
                        </div>
                        <div class="deadline-form">
                            <div class="row g-3 mb-3">
                                <div class="col-sm-6">
                                    <label for="days_per_year_add" class="form-label">Days Per Year</label>
                                    <input type="number" id="days_per_year_add" name="days_per_year" class="form-control">
                                </div>
                                <div class="col-sm-6">
                                    <label for="days_per_month_add" class="form-label">Days Per Month</label>
                                    <input type="number" id="days_per_month_add" name="days_per_month" class="form-control">
                                </div>
                                <div class="col-sm-6">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" name="status" id="status">
                                        <option selected value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>

                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection

