@extends('admin.layout.app')
@section('title','Department Management')
@section('body')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white"><a class="text-white" href="{{route('departments.index')}}">Departments</a></h3>
                <div class="col-auto d-flex w-sm-100">
                    <a href="{{route('departments.index')}}" class="btn btn-dark btn-set-task w-sm-100"><i class="icofont-list me-2 fs-6"></i>All Departments</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Row end  -->

    <div class="row clearfix g-3">
        <div class="col-sm-8">
            <div class="card mb-3">
                <div class="card-body export-table bg-dark-subtle">
                    <table id="file-datatable" class="table table-bordered text-nowrap table-secondary key-buttons border-bottom w-100">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>Department Name</th>
                            <th>Department Head</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($departments as $key => $department)
                            <tr>
                                <td><span class="fw-bold">{{ $loop->iteration }}</span></td>
                                <td>{{ $department->department_name ?? 'N/A'  }}</td>
                                <td>{{ $department->user->name ?? 'N/A' }}</td>w
                                <td>
                                    <form action="{{route('admin.department.StatusUpdate',$department->id)}}" method="post">
                                        @csrf
                                        <select name="status" id="" class="form-control-sm text-white {{$department->status == 1 ? 'bg-success':'bg-danger'}}" onchange="this.form.submit()">
                                            <option {{$department->status == 1 ? 'selected':''}} value="1">Active</option>
                                            <option {{$department->status == 0 ? 'selected':''}} value="0">Inactive</option>
                                        </select>
                                    </form>
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                        <a href="{{route('departments.edit',$department->id)}}" class="btn btn-outline-secondary"><i class="icofont-edit text-success"></i></a>
                                        <form action="{{route('departments.destroy',$department->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('are you sure to delete ? ')" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-white my-3 d-grid justify-content-center">
                        {{ $departments->links() }}
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-4">
            <div class="card p-2">
                <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                    <h5 class="fw-bold mb-0 text-dark text-center">Edit Department</h5>
                    <hr>
                </div>
                <form action="{{route('departments.update',$dept->id)}}" method="post">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="deptNameEdit" class="form-label">Department Name</label>
                            <input type="text" value="{{$dept->department_name}}" name="department_name" class="form-control" id="deptNameEdit">
                        </div>
                        <div class="deadline-form">
                            <div class="row g-3 mb-3">
                                <div class="col-sm-12">
                                    <label for="department_headEdit" class="form-label">Department Head</label>
                                    <select class="form-control select2-example" name="department_head" id="department_headEdit">
                                        <option value="">Select One</option>
                                        @foreach($users as $user)
                                            <option {{$dept->department_head == $user->id ? 'selected':''}} value="{{$user->id}}">{{$user->name}} <sub>({{$user->userInfo->employee_id}})</sub></option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-12">
                                    <label for="statusEdit" class="form-label">Status</label>
                                    <select class="form-control" name="status" id="statusEdit">
                                        <option {{$dept->status == 1 ? 'selected':''}} value="1">Active</option>
                                        <option {{$dept->status == 0 ? 'selected':''}} value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!-- Row End -->
@endsection

