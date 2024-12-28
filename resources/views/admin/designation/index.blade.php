@extends('admin.layout.app')
@section('title','Designation Management')
@section('body')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Designation</h3>
                <div class="col-auto d-flex w-sm-100">
                    @if(auth()->user()->hasPermission('admin designation store'))
                    <button type="button" class="btn btn-dark btn-set-task w-sm-100" data-bs-toggle="modal" data-bs-target="#depadd"><i class="icofont-plus-circle me-2 fs-6"></i>Add Designation</button>
                    @endif
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
                            <th>Designation Name</th>
                            <th>Department Name</th>
                            <th>Status</th>
                            @if(auth()->user()->hasPermission('admin designation update') || auth()->user()->hasPermission('admin designation soft destroy'))
                            <th>Actions</th>
                            @endif
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($designations as $key => $designation)
                        <tr>
                            <td>
                                <span class="fw-bold">{{$loop->iteration}}</span>
                            </td>
                            <td>{{$designation->name}}</td>
                            <td>{{$designation->department->department_name ?? ''}}</td>
                            <td>
                                <form action="{{route('admin.designation.StatusUpdate',$designation->id)}}" method="post">
                                    @csrf
                                    <select name="status" id="" class="form-control-sm text-white {{$designation->status == 1 ? 'bg-success':'bg-danger'}}" onchange="this.form.submit()">
                                        <option {{$designation->status == 1 ? 'selected':''}} value="1">Active</option>
                                        <option {{$designation->status == 0 ? 'selected':''}} value="0">Inactive</option>
                                    </select>
                                </form>
                            </td>
                            @if(auth()->user()->hasPermission('admin designation update') || auth()->user()->hasPermission('admin designation soft destroy'))
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic outlined example">
                                    @if(auth()->user()->hasPermission('admin designation update'))
                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#degedit{{$key}}"><i class="icofont-edit text-success"></i></button>
                                    @endif
                                    @if(auth()->user()->hasPermission('admin designation destroy'))
                                    <form action="{{ route('admin.designation.soft.destroy',$designation->id) }}" method="post">
                                        @csrf
                                        @method('PUT')
                                        <button type="submit" onclick="return confirm('are you sure to delete ? ')" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                    </form>
                                    @endif
                                </div>
                            </td>
                            @endif
                        </tr>
                        <!-- Edit Designation-->
                        <div class="modal fade" id="degedit{{$key}}" tabindex="-1"  aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title  fw-bold" id="depeditLabel"> Designation Edit</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="deadline-form">
                                            <form action="{{route('admin.designation.update',$designation->id)}}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="mb-3">
                                                        <label for="desiNameEdit" class="form-label">Designation Name <span class="text-danger">*</span></label>
                                                        <input type="text" value="{{$designation->name}}" name="name" class="form-control" id="desiNameEdit" required>
                                                    </div>
                                                    <div class="deadline-form">
                                                        <div class="row g-3 mb-3">
                                                            <div class="col-sm-6">
                                                                <label for="department_id_edit" class="form-label">Department <span class="text-danger">*</span></label>
                                                                <select class="form-control" name="department_id" id="department_id_edit" required>
                                                                    <option disabled value="">select one</option>
                                                                    @foreach($departments as $department)
                                                                    <option {{$department->id == $designation->department_id ? 'selected':''}} value="{{$department->id}}">{{$department->department_name}}</option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="statusEdit" class="form-label">Status</label>
                                                                <select class="form-control" name="status" id="statusEdit">
                                                                    <option {{$designation->status == 1 ? 'selected':''}} value="1">Active</option>
                                                                    <option {{$designation->status == 0 ? 'selected':''}} value="0">Inactive</option>
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
                        {{$designations->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->

    <!-- Add Designation-->
    <div class="modal fade" id="depadd" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title  fw-bold" id="depaddLabel"> Designation Add</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.designation.store')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Designation Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" id="name" required>
                        </div>
                        <div class="deadline-form">
                            <div class="row g-3 mb-3">
                                <div class="col-sm-6">
                                    <label for="department_id" class="form-label">Department <span class="text-danger">*</span></label>
                                    <select class="form-control" name="department_id" id="department_id" required>
                                        <option disabled selected value="">select one</option>
                                        @foreach($departments as $department)
                                            <option value="{{$department->id}}">{{$department->department_name}}</option>
                                        @endforeach
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
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">Add</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


@endsection
