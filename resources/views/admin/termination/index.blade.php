@extends('admin.layout.app')
@section('title','Termination')
@section('body')
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.5; }
        h1 { text-align: center; }
        .content { margin: 0 auto; width: 80%; }
        .signature { margin-top: 50px; }
         label {
             display: inline-block;
             padding-bottom: 10px;
         }
    </style>
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Termination</h3>
                <div class="col-auto d-flex w-sm-100">
                    <button type="button" class="btn btn-dark btn-set-task w-sm-100" data-bs-toggle="modal" data-bs-target="#depadd"><i class="icofont-plus-circle me-2 fs-6"></i>Add Termination</button>
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
                            <th>Employee</th>
                            <th>Reason</th>
                            <th>Termination Date</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($terminations as $key => $termination)
                        <tr>
                            <td>
                                <span class="fw-bold">{{$loop->iteration}}</span>
                            </td>
                            <td>
                                <span class="fw-bold ms-1">{{$termination->employee->name}} <sub>({{$termination->employee->userInfo->employee_id}})</sub></span>
                            </td>
                            <td>{{$termination->reason}}</td>
                            <td>{{$termination->terminated_at}}</td>

                            <td>
                                <form action="{{--{{route('admin.department.StatusUpdate',$termination->id)}}--}}" method="post">
                                    @csrf
                                    <select name="status" id="" class="form-control-sm text-white {{$termination->status == 1 ? 'bg-success':'bg-danger'}}" onchange="this.form.submit()">
                                        <option {{$termination->status == 1 ? 'selected':''}} value="1">Active</option>
                                        <option {{$termination->status == 0 ? 'selected':''}} value="0">Inactive</option>
                                    </select>
                                </form>
                            </td>
                            <td>
                                <div class="btn-group" role="group" aria-label="Basic outlined example">
                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#depedit{{$key}}"><i class="icofont-edit text-primary"></i></button>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#depShow{{$key}}"><i class="icofont-eye text-success"></i></button>
                                    <form action="{{route('admin.termination.destroy',$termination->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('are you sure to delete ? ')" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                    </form>
                                    <form action="{{route('admin.termination.download',$termination->id)}}" method="post">
                                        @csrf
                                        <button type="submit" onclick="return confirm('are you sure to download ? ')" class="btn btn-outline-secondary deleterow"><i class="icofont-download-alt text-primary"></i></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <!-- Edit Department-->
                        <div class="modal fade" id="depedit{{$key}}" tabindex="-1"  aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title  fw-bold" id="depeditLabel"> Termination Edit</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="deadline-form">
                                            <form action="{{route('admin.termination.update',$termination->id)}}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="deadline-form">
                                                        <div class="row g-3 mb-3">
                                                            <div class="col-sm-6">
                                                                <label for="employee_idEdit" class="form-label">Employee</label>
                                                                <select class="form-control" name="employee_id" id="employee_idEdit">
                                                                    @foreach($users as $user)
                                                                        <option {{$termination->employee_id == $user->id ? 'selected':''}} value="{{$user->id}}">{{$user->name}} <sub>({{$user->userInfo->employee_id}})</sub></option>
                                                                    @endforeach
                                                                </select>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <label for="terminated_atEdit" class="form-label">Termination Date</label>
                                                                <input type="date" class="form-control" name="terminated_at" id="terminated_atEdit" value="{{$termination->terminated_at}}">
                                                            </div>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="reasonEdit" class="form-label">Reason</label>
                                                            <input type="text" name="reason" class="form-control" id="reasonEdit" placeholder="Enter Reason For Termination" value="{{$termination->reason}}">
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="detailsEdit" class="form-label">Details</label>
                                                            <textarea  class="form-control" name="details" id="detailsEdit" cols="30" rows="10"  placeholder="Enter Details For Termination">{{$termination->details}}</textarea>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="statusEdit" class="form-label">Status</label>
                                                            <select class="form-control" name="status" id="statusEdit">
                                                                <option {{$termination->status == 1 ? 'selected':''}} value="1">Active</option>
                                                                <option {{$termination->status == 0 ? 'selected':''}} value="0">Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>


                                                    <div class="modal-footer">
                                                        <button type="submit" class="btn btn-primary">Update</button>
                                                    </div>
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
                                        <h5 class="modal-title  fw-bold" id="depeditLabel"> Termination Letter Show</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="deadline-form">
                                            <div class="content">

                                                <p><span class="fw-bolder">Date: </span>{{ now()->format('d M, Y') }}</p>

                                                <p>To,</p>
                                                <p>{{ $termination->employee->name }}<br>
                                                    <span class="fw-bolder">Employee ID: </span>{{ $termination->employee->userInfo->employee_id }}<br>
                                                    <span class="fw-bolder">Department: </span>{{ $termination->employee->userInfo->designations->department->department_name }}</p>

                                                <p>Dear {{ $termination->employee->name }},</p>

                                                <p>We regret to inform you that your employment with {{ config('app.name') }} is being terminated effective immediately.</p>

                                                <p><span class="fw-bolder">Reason for Termination: </span>{{ $termination->reason }}</p>

                                                <p>{{ $termination->details }}</p>

                                                <p>Please return all company property in your possession before your departure. We wish you the best of luck in your future endeavors.</p>

                                                <div class="signature">
                                                    <p>Sincerely,</p>
                                                    <p>{{ config('app.name') }}</p>
                                                    <p>HR Department</p>
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
                        {{$terminations->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->
    <!-- Add Department-->
    <div class="modal fade" id="depadd" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title  fw-bold" id="depaddLabel">Termination Create</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                    <div class="modal-body">
                        <form action="{{route('admin.termination.store')}}" method="post">
                            @csrf
                            <div class="deadline-form">
                                <div class="row g-3 mb-3">
                                    <div class="col-sm-6">
                                        <label for="employee_id" class="form-label">Employee</label>
                                        <select class="form-control" name="employee_id" id="employee_id">
                                            @foreach($users as $user)
                                                <option {{old('employee_id') == $user->id ? 'selected':''}} value="{{$user->id}}">{{$user->name}} <sub>({{$user->userInfo->employee_id}})</sub></option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-sm-6">
                                        <label for="terminated_at" class="form-label">Termination Date</label>
                                        <input type="date" class="form-control" name="terminated_at" id="terminated_at">
                                    </div>
                                </div>
                                <div class="mb-3">
                                    <label for="reason" class="form-label">Reason</label>
                                    <input type="text" name="reason" class="form-control" id="reason" placeholder="Enter Reason For Termination">
                                </div>
                                <div class="mb-3">
                                    <label for="reason" class="form-label">Details</label>
                                    <textarea  class="form-control" name="details" id="details" cols="30" rows="10"  placeholder="Enter Details For Termination"></textarea>
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
