@extends('admin.layout.app')
@section('title','Employee Management')
@section('body')

    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card border-0 mb-4 no-bg">
                <div class="card-header py-3 px-0 d-sm-flex align-items-center  justify-content-between border-bottom">
                    <h3 class=" fw-bold flex-fill mb-0 mt-sm-0">Employee</h3>
                    <button type="button" class="btn btn-dark me-1 mt-1 w-sm-100" data-bs-toggle="modal" data-bs-target="#createemp"><i class="icofont-plus-circle me-2 fs-6"></i>Add Employee</button>
                    <div class="dropdown">
                        <button class="btn btn-primary dropdown-toggle mt-1  w-sm-100" type="button" id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                            Status
                        </button>
                        <ul class="dropdown-menu  dropdown-menu-end" aria-labelledby="dropdownMenuButton2">
                            <li><a class="dropdown-item" href="#">All</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->
    <div class="row g-3 py-1 pb-4">
        @foreach($users as $key => $user)
        <div class="col-2">
            <div class="card teacher-card">
                <div class="card-body">
                    <div class="d-flex">
                        <button class="btn btn-toolbar float-start" data-bs-toggle="modal" data-bs-target="#editEmp{{$key}}"><i class="icofont-edit text-success"></i></button>
                        <form action="{{route('admin.user.ban.unban',$user->id)}}" method="post">
                            @csrf
                            @if($user->status == 0)
                                <input type="hidden" value="1" name="status">
                                <button class="float-end btn btn-toolbar"><i class="text-danger icofont-ban"></i></button>
                            @endif
                            @if($user->status == 1)
                                <input type="hidden" value="0" name="status">
                                <button class="float-end btn btn-toolbar"><i class="text-success icofont-stop"></i></button>
                            @endif
                        </form>
                    </div>
                    <div class="profile-av pe-xl-4 pe-md-2 pe-sm-4 pe-4 text-center w220">
                        <a href="{{route('employee.profile',$user->id)}}">
                            @if($user->userInfo->image == '')
                                <img src="{{asset('/')}}admin/assets/images/lg/avatar3.jpg" alt="" class="avatar xl rounded-circle img-thumbnail shadow-sm">
                            @else
                                <img src="{{asset($user->userInfo->image)}}" alt="" class="avatar xl rounded-circle img-thumbnail shadow-sm">
                            @endif
                            <div class="about-info align-items-center mt-3 justify-content-center">
                                <h6  class="mb-0 mt-2  fw-bold d-block fs-6">{{$user->name}}</h6>
                                <span class="light-info-bg py-1 px-2 rounded-1 d-inline-block fw-bold small-11 mb-0 mt-1">{{$user->userInfo->designations->name ?? 'N/A'}}<br> <span>({{ str_replace('_',' ',$user->userInfo->employee_type) }})</span></span><br>
                                <span class="light-info-bg py-1 px-2 rounded-1 d-inline-block fw-bold small-11 mb-0 mt-1">EIN : {{$user->userInfo->employee_id ?? 'N/A'}}</span>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
            <div class="modal fade" id="editEmp{{$key}}" tabindex="-1"  aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title  fw-bold" id=""> Edit Employee</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{route('employees.update',$user->id)}}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="exampleFormControlInput877" class="form-label">Employee Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" required class="form-control" value="{{$user->name}}" id="exampleFormControlInput877" placeholder="Employee Name">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlInput977" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="text" name="email" required class="form-control" value="{{$user->email}}" id="exampleFormControlInput977" placeholder="Email Address">
                                </div>
                                <div class="deadline-form">
                                    <div class="row g-3 mb-3">
                                        <div class="col-sm-4">
                                            <label for="exampleFormControlInput1778" class="form-label">Employee ID <span class="text-danger">*</span></label>
                                            <input type="text" required name="employee_id" value="{{$user->userInfo->employee_id}}" class="form-control" id="exampleFormControlInput1778" placeholder="Employee Id">
                                        </div>
                                        <div class="col-sm-4">
                                            <label for="employee_type" class="form-label">Employee Type <span class="text-danger">*</span></label>
                                            <select  class="form-control" required name="employee_type" id="employee_type">
                                                <option label="Select Type"></option>
                                                <option {{$user->userInfo->employee_type == 'Intern' ? 'selected':''}} value="Intern">Intern</option>
                                                <option {{$user->userInfo->employee_type == 'Probationary' ? 'selected':''}} value="Probationary">Probationary</option>
                                                <option {{$user->userInfo->employee_type == 'Confirm' ? 'selected':''}} value="Confirm">Confirm</option>
                                                <option {{$user->userInfo->employee_type == 'Part_Time' ? 'selected':''}} value="Part_Time">Part Time</option>
                                                <option {{$user->userInfo->employee_type == 'Contractual' ? 'selected':''}} value="Contractual">Contractual</option>
                                                <option {{$user->userInfo->employee_type == 'Remote' ? 'selected':''}} value="Remote">Remote</option>
                                            </select>
                                        </div>

                                        <div class="col-sm-4">
                                            <label for="exampleFormControlInput2778" class="form-label">Joining Date <span class="text-danger">*</span></label>
                                            <input type="date" required name="join" class="form-control" value="{{$user->userInfo->join}}" id="exampleFormControlInput2778">
                                        </div>
                                    </div>
                                    <div class="row g-3 mb-3">
                                        <div class="col-sm-6">
                                            <label for="exampleFormControlInput777" class="form-label">Phone</label>
                                            <input type="text" name="phone" class="form-control" value="{{$user->userInfo->mobile}}" id="exampleFormControlInput777" placeholder="phone number">
                                        </div>
                                        <div class="col-sm-6">
                                            <label  class="form-label">Designation <span class="text-danger">*</span></label>
                                            <select required name="designation" class="form-select" aria-label="Default select">
                                                @foreach($designations as $designation)
                                                    <option value="{{$designation->id}}" {{$user->userInfo->designation == $designation->id ? 'selected':''}} >{{$designation->name}}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label  class="form-label">Gender<span class="text-danger">*</span></label>
                                            <select required name="gender" class="form-select" aria-label="Default select">
                                                <option>Select Gender</option>
                                                <option value="1" {{$user->userInfo->gender == 1 ? 'selected':''}} >Male</option>
                                                <option value="2" {{$user->userInfo->gender == 2 ? 'selected':''}} >FeMale</option>
                                                <option value="3" {{$user->userInfo->gender == 3 ? 'selected':''}} >Other</option>
                                            </select>
                                        </div>
                                        <div class="col-sm-6">
                                            <label  class="form-label">Status</label>
                                            <select name="status" class="form-select" aria-label="Default select">
                                                <option {{$user->status == 1 ? 'selected':''}} value="1" >Active</option>
                                                <option {{$user->status == 0 ? 'selected':''}} value="0">Inactive</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid justify-content-end">
                                    <button type="submit" onclick="return confirm('Are you sure to Update ?')" class="btn btn-primary">Update</button>
                                </div>

                                {{--<div class="table-responsive">
                                    <table class="table table-striped custom-table">
                                        <thead>
                                        <tr>
                                            <th>Project Permission</th>
                                            <th class="text-center">Read</th>
                                            <th class="text-center">Write</th>
                                            <th class="text-center">Create</th>
                                            <th class="text-center">Delete</th>
                                            <th class="text-center">Import</th>
                                            <th class="text-center">Export</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        <tr>
                                            <td class="fw-bold">Projects</td>
                                            <td class="text-center">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1" checked>
                                            </td>
                                            <td class="text-center">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2" checked>
                                            </td>
                                            <td class="text-center">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3" checked>
                                            </td>
                                            <td class="text-center">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4" checked>
                                            </td>
                                            <td class="text-center">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault5" checked>
                                            </td>
                                            <td class="text-center">
                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault6" checked>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td  class="fw-bold">Tasks</td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault7" checked>

                                            </td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault8" checked>

                                            </td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault9" checked>

                                            </td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault10" checked>

                                            </td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault11" checked>

                                            </td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault12" checked>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td  class="fw-bold">Chat</td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault13" checked>

                                            </td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault14" checked>

                                            </td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault15" checked>

                                            </td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault16" checked>

                                            </td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault17" checked>

                                            </td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault18" checked>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td  class="fw-bold">Estimates</td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault19" checked>

                                            </td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault20" checked>

                                            </td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault21" checked>

                                            </td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault22" checked>

                                            </td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault23" checked>

                                            </td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault24" checked>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td  class="fw-bold">Invoices</td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault25" checked>

                                            </td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault26">

                                            </td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault27" checked>

                                            </td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault28">

                                            </td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault29" checked>

                                            </td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault30" checked>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td  class="fw-bold">Timing Sheets</td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault31" checked>

                                            </td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault32" checked>

                                            </td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault33" checked>

                                            </td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault34" checked>

                                            </td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault35" checked>

                                            </td>
                                            <td class="text-center">

                                                <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault36" checked>

                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                </div>--}}
                            </form>
                        </div>
                        <div class="modal-footer">

                        </div>

                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Modal Create Employee-->
    <div class="modal fade" id="createemp" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title  fw-bold" id="createprojectlLabel"> Add Employee</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{route('employees.store')}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput877" class="form-label">Employee Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" required class="form-control" value="{{old('name')}}" id="exampleFormControlInput877" placeholder="Employee Name">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput977" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="text" name="email" required class="form-control" value="{{old('name')}}" id="exampleFormControlInput977" placeholder="Email Address">
                        </div>
                        <div class="deadline-form">
                            <div class="row g-3 mb-3">
                                <div class="col-sm-4">
                                    <label for="exampleFormControlInput1778" class="form-label">Employee ID <span class="text-danger">*</span></label>
                                    <input type="text" required name="employee_id" value="{{old('employee_id')}}" class="form-control" id="exampleFormControlInput1778" placeholder="Employee Id">
                                </div>
                                <div class="col-sm-4">
                                    <label for="employee_type" class="form-label">Employee Type <span class="text-danger">*</span></label>
                                    <select  class="form-control" required name="employee_type" id="employee_type">
                                        <option label="Select Type"></option>
                                        <option value="Intern">Intern</option>
                                        <option value="Probationary">Probationary</option>
                                        <option value="Confirm">Confirm</option>
                                        <option value="Part_Time">Part Time</option>
                                        <option value="Contractual">Contractual</option>
                                        <option value="Remote">Remote</option>
                                    </select>
                                </div>

                                <div class="col-sm-4">
                                    <label for="exampleFormControlInput2778" class="form-label">Joining Date <span class="text-danger">*</span></label>
                                    <input type="date" required name="join" class="form-control" value="{{old('join')}}" id="exampleFormControlInput2778">
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-sm-6">
                                    <label for="exampleFormControlInput277" class="form-label">Password <span class="text-danger">*</span></label>
                                    <input type="Password" required name="password" value="{{old('password')}}" class="form-control" id="exampleFormControlInput277" placeholder="Password">
                                </div>
                                <div class="col-sm-6">
                                    <label for="confirm_password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                    <input type="password" required name="confirm_password" value="{{old('confirm_password')}}" class="form-control" id="confirm_password" placeholder="confirm Password">
                                </div>
                                <div class="col-sm-6">
                                    <label for="exampleFormControlInput777" class="form-label">Phone</label>
                                    <input type="text" name="phone" class="form-control" value="{{old('phone')}}" id="exampleFormControlInput777" placeholder="phone number">
                                </div>
                                <div class="col-sm-6">
                                    <label  class="form-label">Designation <span class="text-danger">*</span></label>
                                    <select required name="designation" class="form-select" aria-label="Default select">
                                        @foreach($designations as $designation)
                                            <option value="{{$designation->id}}" {{old('designation') == $designation->id ? 'selected':''}} >{{$designation->name}}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label  class="form-label">Gender <span class="text-danger">*</span></label>
                                    <select required name="gender" class="form-select" aria-label="Default select">
                                        <option value="1" selected>Male</option>
                                        <option value="2" >FeMale</option>
                                        <option value="3" >Other</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label  class="form-label">Status</label>
                                    <select name="status" class="form-select" aria-label="Default select">
                                        <option value="1" selected >Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="d-grid justify-content-end">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>

                        {{--<div class="table-responsive">
                            <table class="table table-striped custom-table">
                                <thead>
                                <tr>
                                    <th>Project Permission</th>
                                    <th class="text-center">Read</th>
                                    <th class="text-center">Write</th>
                                    <th class="text-center">Create</th>
                                    <th class="text-center">Delete</th>
                                    <th class="text-center">Import</th>
                                    <th class="text-center">Export</th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td class="fw-bold">Projects</td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault1" checked>
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault2" checked>
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault3" checked>
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault4" checked>
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault5" checked>
                                    </td>
                                    <td class="text-center">
                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault6" checked>
                                    </td>
                                </tr>
                                <tr>
                                    <td  class="fw-bold">Tasks</td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault7" checked>

                                    </td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault8" checked>

                                    </td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault9" checked>

                                    </td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault10" checked>

                                    </td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault11" checked>

                                    </td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault12" checked>

                                    </td>
                                </tr>
                                <tr>
                                    <td  class="fw-bold">Chat</td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault13" checked>

                                    </td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault14" checked>

                                    </td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault15" checked>

                                    </td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault16" checked>

                                    </td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault17" checked>

                                    </td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault18" checked>

                                    </td>
                                </tr>
                                <tr>
                                    <td  class="fw-bold">Estimates</td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault19" checked>

                                    </td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault20" checked>

                                    </td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault21" checked>

                                    </td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault22" checked>

                                    </td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault23" checked>

                                    </td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault24" checked>

                                    </td>
                                </tr>
                                <tr>
                                    <td  class="fw-bold">Invoices</td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault25" checked>

                                    </td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault26">

                                    </td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault27" checked>

                                    </td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault28">

                                    </td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault29" checked>

                                    </td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault30" checked>

                                    </td>
                                </tr>
                                <tr>
                                    <td  class="fw-bold">Timing Sheets</td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault31" checked>

                                    </td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault32" checked>

                                    </td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault33" checked>

                                    </td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault34" checked>

                                    </td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault35" checked>

                                    </td>
                                    <td class="text-center">

                                        <input class="form-check-input" type="checkbox" value="" id="flexCheckDefault36" checked>

                                    </td>
                                </tr>
                                </tbody>
                            </table>
                        </div>--}}
                    </form>
                </div>
                <div class="modal-footer">

                </div>

            </div>
        </div>
    </div>
@endsection
