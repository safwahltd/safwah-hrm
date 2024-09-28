@extends('admin.layout.app')
@section('title','Department Management')
@section('body')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0">Departments</h3>
                <div class="col-auto d-flex w-sm-100">
                    <button type="button" class="btn btn-dark btn-set-task w-sm-100" data-bs-toggle="modal" data-bs-target="#depadd"><i class="icofont-plus-circle me-2 fs-6"></i>Add Departments</button>
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
{{--                            <th>Department Head</th>--}}
                            <th>Department Name</th>
{{--                            <th>Employee UnderWork</th>--}}
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($departments as $key => $department)
                        <tr>
                            <td>
                                <span class="fw-bold">{{$loop->iteration}}</span>
                            </td>
                            {{--<td>
                                <img class="avatar rounded-circle" src="assets/images/xs/avatar1.jpg" alt="">
                                <span class="fw-bold ms-1">Joan Dyer</span>
                            </td>--}}
                            <td>
                                {{$department->department_name}}
                            </td>
                            <td>
                                <form action="{{route('admin.department.StatusUpdate',$department->id)}}" method="post">
                                    @csrf
                                    <select name="status" id="" class="form-control-sm text-white {{$department->status == 1 ? 'bg-success':'bg-danger'}}" onchange="this.form.submit()">
                                        <option {{$department->status == 1 ? 'selected':''}} value="1">Active</option>
                                        <option {{$department->status == 0 ? 'selected':''}} value="0">Inactive</option>
                                    </select>
                                </form>
                            </td>

{{--                            <td>--}}
{{--                                40--}}
{{--                            </td>--}}
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic outlined example">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#depedit{{$key}}"><i class="icofont-edit text-success"></i></button>
                                    <form action="{{route('departments.destroy',$department->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('are you sure to delete ? ')" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <!-- Edit Department-->
                        <div class="modal fade" id="depedit{{$key}}" tabindex="-1"  aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title  fw-bold" id="depeditLabel"> Department Edit</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="deadline-form">
                                            <form action="{{route('departments.update',$department->id)}}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="deptNameEdit" class="form-label">Department Name</label>
                                                        <input type="text" value="{{$department->department_name}}" name="department_name" class="form-control" id="deptNameEdit">
                                                    </div>
                                                    <div class="deadline-form">
                                                        <div class="row g-3 mb-3">
                                                            <div class="col-sm-6">
                                                                <label for="department_headEdit" class="form-label">Department Head</label>
                                                                <select class="form-control" name="department_head" id="department_headEdit">
                                                                    <option {{$department->department_head == 2 ? 'selected':''}} value="2">Employee Name 2</option>
                                                                    <option {{$department->department_head == 3 ? 'selected':''}} value="3">Employee Name 3</option>
                                                                    <option {{$department->department_head == 4 ? 'selected':''}} value="4">Employee Name 4</option>
                                                                    <option {{$department->department_head == 5 ? 'selected':''}} value="5">Employee Name 5</option>
                                                                    <option {{$department->department_head == 6 ? 'selected':''}} value="6">Employee Name 6</option>
                                                                    <option {{$department->department_head == 7 ? 'selected':''}} value="7">Employee Name 7</option>
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="statusEdit" class="form-label">Status</label>
                                                                <select class="form-control" name="status" id="statusEdit">
                                                                    <option {{$department->status == 1 ? 'selected':''}} value="1">Active</option>
                                                                    <option {{$department->status == 0 ? 'selected':''}} value="0">Inactive</option>
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
                        {{$departments->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->

    <!-- Add Department-->
    <div class="modal fade" id="depadd" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title  fw-bold" id="depaddLabel"> Department Add</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                    <div class="modal-body">
                        <form action="{{route('departments.store')}}" method="post">
                            @csrf
                            <div class="mb-3">
                                <label for="exampleFormControlInput1111" class="form-label">Department Name</label>
                                <input type="text" name="department_name" class="form-control" id="exampleFormControlInput1111">
                            </div>
                            <div class="deadline-form">

                                <div class="row g-3 mb-3">
                                    <div class="col-sm-6">
                                        <label for="department_head" class="form-label">Department Head</label>
                                        <select class="form-control" name="department_head" id="department_head">
                                            <option selected value="2">Employee Name 2</option>
                                            <option value="3">Employee Name 3</option>
                                            <option value="4">Employee Name 4</option>
                                            <option value="5">Employee Name 5</option>
                                            <option value="6">Employee Name 6</option>
                                            <option value="7">Employee Name 7</option>
                                        </select>
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
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Add</button>
                            </div>
                        </form>
                    </div>

            </div>
        </div>
    </div>


@endsection
