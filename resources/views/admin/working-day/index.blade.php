@extends('admin.layout.app')
@section('title','Working Day Management')
@section('body')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Working Day Monthly</h3>
                <div class="col-auto d-flex w-sm-100">
                    <button type="button" class="btn btn-dark btn-set-task w-sm-100" data-bs-toggle="modal" data-bs-target="#depadd"><i class="icofont-plus-circle me-2 fs-6"></i>Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Row end  -->

    <div class="row clearfix g-3">
        <div class="col-sm-12">
            <div class="card mb-3">
                <div class="card-body table-responsive export-table bg-dark-subtle">
                    <table id="basic-datatable" class="table table-bordered text-nowrap table-secondary key-buttons border-bottom w-100">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Month</th>
                            <th class="text-center">Year</th>
                            <th class="text-center">Total Day In Month</th>
                            <th class="text-center">Total Working Day</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($workingDays as $key => $workingDay)
                            <tr>
                                <td>
                                    <span class="fw-bold">{{$loop->iteration}}</span>
                                </td>
                                <td class="text-uppercase">{{ date('F', mktime(0, 0, 0, $workingDay->month, 1)) }}</td>
                                <td align="center">{{$workingDay->year}}</td>
                                <td align="center">{{$workingDay->days_in_month}}</td>
                                <td align="center">{{$workingDay->working_day}}</td>
                                <td><span class="rounded-3 p-1 text-white {{$workingDay->status == 1 ? 'bg-success':'bg-danger'}}">{{$workingDay->status == 1 ? 'Active':'Inactive'}}</span></td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#depedit{{$key}}"><i class="icofont-edit text-success"></i></button>
                                        <form action="{{route('admin.workingDay.destroy',$workingDay->id)}}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" onclick="return confirm('Are you sure to delete ? ')" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <!-- Edit holiday-->
                            <div class="modal fade" id="depedit{{$key}}" tabindex="-1"  aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title  fw-bold" id="depeditLabel"> holiday Edit</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="deadline-form">
                                                <form action="{{route('admin.workingDay.update',$workingDay->id)}}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="deadline-form">
                                                            <div class="row g-3 mb-3">
                                                                <div class="col-sm-6">
                                                                    <label for="name" class="form-label">Month <span class="text-danger">*</span></label>
                                                                    <select class="form-control" name="month" id="month" required>
                                                                        @for ($i = 1; $i <= 12; $i++)
                                                                            <option {{$workingDay->month == $i ? 'selected':''}} value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <label for="holiday_head" class="form-label">Year <span class="text-danger">*</span></label>
                                                                    <select class="form-control" name="year" id="year" required>
                                                                        @for ($i = date('Y'); $i >= 2022; $i--)
                                                                            <option {{$workingDay->year == $i ? 'selected':''}} value="{{ $i }}">{{ $i }}</option>
                                                                        @endfor
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <label for="name" class="form-label">Total Days In Month <span class="text-danger">*</span></label>
                                                                    <input class="form-control" type="number" name="days_in_month"  value="{{ $workingDay->days_in_month }}" required>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <label for="name" class="form-label">Total Working Day <span class="text-danger">*</span></label>
                                                                    <input class="form-control" type="number" name="working_day"  value="{{ $workingDay->working_day }}" required>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <label for="status" class="form-label">Status</label>
                                                                    <select class="form-control" name="status" id="status">
                                                                        <option {{$workingDay->status == 1 ? 'selected':''}} value="1">Active</option>
                                                                        <option {{$workingDay->status == 0 ? 'selected':''}} value="0">Inactive</option>
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
                        {{$workingDays->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->

    <!-- Add holiday-->
    <div class="modal fade" id="depadd" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title  fw-bold" id="depaddLabel"> Working Day Add</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.workingDay.store')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="deadline-form">
                            <div class="row g-3 mb-3">
                                <div class="col-sm-6">
                                    <label for="name" class="form-label">Month <span class="text-danger">*</span></label>
                                    <select class="form-control" name="month" id="month" required>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="holiday_head" class="form-label">Year <span class="text-danger">*</span></label>
                                    <select class="form-control" name="year" id="year" required>
                                        @for ($i = date('Y'); $i >= 2022; $i--)
                                            <option  value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="name" class="form-label">Total Days In Month <span class="text-danger">*</span></label>
                                    <input class="form-control" type="number" name="days_in_month"  value="{{old('days_in_month')}}" required>
                                </div>
                                <div class="col-sm-6">
                                    <label for="name" class="form-label">Total Working Day <span class="text-danger">*</span></label>
                                    <input class="form-control" type="number" name="working_day"  value="{{old('working_day')}}" required>
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

