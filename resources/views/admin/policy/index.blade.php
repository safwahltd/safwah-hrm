@extends('admin.layout.app')
@section('title','Policy Management')
@section('body')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Policy Management</h3>
                <div class="col-auto d-flex w-sm-100">
                    <button type="button" class="btn btn-dark btn-set-task w-sm-100" data-bs-toggle="modal" data-bs-target="#depadd"><i class="icofont-plus-circle me-2 fs-6"></i>Add Policy</button>
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
                            <th>Name</th>
                            <th>Documents</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($policies as $key => $policy)
                            <tr>
                                <td>
                                    <span class="fw-bold">{{$loop->iteration}}</span>
                                </td>
                                <td>{{$policy->name}}</td>
                                <td>
                                    <span class="bg-success p-1 rounded-2">
                                        <a class="text-white" href="{{ route('admin.policy.showFile', $policy->id) }}" target="_blank">{{ basename($policy->file) }}</a>
                                    </span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#degedit{{$key}}"><i class="icofont-edit text-success"></i></button>
                                        <form action="{{ route('admin.policy.destroy',$policy->id) }}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('are you sure to delete ? ')" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <!-- Edit Department-->
                            <div class="modal fade" id="degedit{{$key}}" tabindex="-1"  aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title  fw-bold" id="depeditLabel"> Policy Edit</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="deadline-form">
                                                <form action="{{route('admin.policy.update',$policy->id)}}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="name" class="form-label"> Name </label>
                                                            <input type="text" name="name" value="{{ $policy->name }}" class="form-control" id="name">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="fileAdd" class="form-label">Attachment </label>
                                                            <input type="file" name="file" class="form-control" id="fileAdd">
                                                            <div class="my-4">
                                                                <span class="">{{ basename($policy->file) }}</span>
                                                                <span class="bg-success p-1 rounded-2">
                                                                    <a class="text-white" href="{{ route('admin.policy.showFile', $policy->id) }}" target="_blank">Show File</a>
                                                                </span>
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
                        {{$policies->links()}}
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
                    <h5 class="modal-title  fw-bold" id="depaddLabel"> Policy Add</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.policy.store')}}" method="post" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label"> Name</label>
                            <input type="text" name="name" class="form-control" id="nameAdd">
                        </div>
                        <div class="mb-3">
                            <label for="fileAdd" class="form-label"> Attachment <span class="text-danger">*</span></label>
                            <input type="file" name="file" class="form-control" id="fileAdd" required>
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

