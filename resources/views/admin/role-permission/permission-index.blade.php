@extends('admin.layout.app')
@section('title','Permission')
@section('body')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Permission</h3>
                <div class="col-auto d-flex w-sm-100">
{{--                    <button type="button" class="btn btn-dark btn-set-task w-sm-100" data-bs-toggle="modal" data-bs-target="#addPermission">Add Permission <i class="icofont-plus-circle me-2 fs-6"></i></button>--}}
                </div>
            </div>
        </div>
    </div>
    <!-- Row end  -->

    <div class="row clearfix g-3">
        <div class="col-sm-12">
            <div class="card mb-3">
                <div class="card-body export-table bg-dark-subtle">
                    <table id="file-datatable" class="table table-bordered text-nowrap table-secondary key-buttons border-bottom w-100">
                        <thead>
                        <tr>
                            <th class="border-bottom-0">SL No</th>
                            <th class="border-bottom-0">Name</th>
                            <th class="border-bottom-0">Status</th>
                            <th class="border-bottom-0">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($permissions as $key => $permission)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $permission->name }}</td>
                                <td class="col-2">
                                    <span class="p-1 {{$permission->status == 1 ? 'bg-success':'bg-warning text-white'}}">{{$permission->status == 1 ? 'Active':'Inactive'}}</span>
                                </td>
                                <td class="d-flex">
                                    <a href="#" class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#Editpermission{{$key}}" ><i class="fa fa-edit"></i></a>
                                    <form action="{{route('admin.permission.destroy',$permission->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('are you sure to delete ? ')" class="btn btn-danger"><i class="fa fa-trash text-white"></i></button>
                                    </form>
                                </td>
                            </tr>
                            <div class="modal fade" id="Editpermission{{$key}}">
                                <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title  fw-bold" id="depaddLabel">Edit Permission </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal" action="{{route('admin.permission.update',$permission->id)}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="row mb-4">
                                                    <label for="name" class="col-md-3 form-label">Name </label>
                                                    <div class="col-md-9">
                                                        <p class="form-control">{{ $permission->name }}</p>
{{--                                                        <input class="form-control" value="" id="name" name="name" placeholder="Enter name" type="text">--}}
                                                        <span class="text-danger">{{$errors->has('name') ? $errors->first('name'):''}}</span>
                                                    </div>
                                                </div>
                                                <div class="row mb-4 d-flex form-group">
                                                    <div class="col-md-3 form-label">
                                                        <label class="" for="status">Status</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select class="form-control select2 form-select" id="status" name="status" data-placeholder="Choose one">
                                                            <option class="form-control" label="Choose one"></option>
                                                            <option {{$permission->status == 1 ? 'selected':''}} value="1">Active</option>
                                                            <option {{$permission->status == 0 ? 'selected':''}} value="0">Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <button class="btn btn-primary float-end" type="submit">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->

    <!-- Add Permission-->
    <div class="modal fade" id="addPermission" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title  fw-bold" id="depaddLabel">New Permission Create</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="{{route('admin.permission.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-4">
                            <label for="name" class="col-md-3 form-label">Name <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input class="form-control" value="{{old('name')}}" id="name" name="name" placeholder="Enter name" type="text">
                                <span class="text-danger">{{$errors->has('name') ? $errors->first('name'):''}}</span>
                            </div>
                        </div>
                        <div class="row mb-4 d-flex form-group">
                            <div class="col-md-3 form-label">
                                <label class="" for="status">Status</label>
                            </div>
                            <div class="col-md-9">
                                <select class="form-control select2 form-select" id="status" name="status" data-placeholder="Choose one">
                                    <option class="form-control" label="Choose one" disabled selected></option>
                                    <option selected value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>

                        <button class="btn btn-primary float-end" type="submit">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

