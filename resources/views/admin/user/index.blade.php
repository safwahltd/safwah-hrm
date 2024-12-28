@extends('admin.layout.app')
@section('title','Employee Management')
@section('body')
    <div class="row">
        <form method="get" action="{{ route('admin.employees.index') }}">
            <div class="row">
                <div class="col my-2">
                    <div class="card ">
                        <div class="card-header">
                            <label for="leave_type" class="text-dark">Employee</label>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <select class="form-control-lg select2-example"  name="user_id" id="user_id">
                                    <option value="">All Employee</option>
                                    @foreach($userss as $user)
                                        <option {{$user_id == $user->id ? 'selected':''}} value="{{ $user->id }}">{{ $user->name }} <sub>({{ $user->userInfo->employee_id }})</sub></option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col my-2">
                    <div class="card">
                        <div class="card-header">
                            <label for="leave_type" class="text-dark">Status</label>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <select class="p-1"  name="status" id="status">
                                    <option {{$status == 2 ? 'selected':''}} value="">All Type</option>
                                    <option {{$status == 1 ? 'selected':''}} value="1">Active</option>
                                    <option {{$status == 0 ? 'selected':''}} value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col my-2">
                    <div class="card">
                        <div class="card-header"><label for="leave_type" class="text-dark">Employee Type</label></div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <select class="p-1"  name="type" id="type">
                                    <option value="">All</option>
                                    <option {{$type == 'Intern' ? 'selected':''}} value="Intern">Intern</option>
                                    <option {{$type == 'Probationary' ? 'selected':''}} value="Probationary">Probationary</option>
                                    <option {{$type == 'Confirm' ? 'selected':''}} value="Confirm">Confirm</option>
                                    <option {{$type == 'Part_Time' ? 'selected':''}} value="Part_Time">Part Time</option>
                                    <option {{$type == 'Contractual' ? 'selected':''}} value="Contractual">Contractual</option>
                                    <option {{$type == 'Remote' ? 'selected':''}} value="Remote">Remote</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col my-2">
                    <div class="card">
                        <div class="card-header"><label for="leave_type" class="text-dark">Designation</label></div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <select class="p-1"  name="designation" id="designation">
                                    <option value="">All</option>
                                    @foreach($designations as $designation)
                                        <option value="{{$designation->id}}" {{$designation_id == $designation->id ? 'selected':''}} >{{$designation->name}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col my-2">
                    <div class="d-flex my-4 align-items-center">
                        <button class="form-control-lg text-white bg-success px-3"  type="submit">Filter</button>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card border-0 mb-4 no-bg">
                <div class="card-header py-3 px-0 d-sm-flex align-items-center  justify-content-between border-bottom">
                    <h3 class="fw-bold flex-fill mb-0 mt-sm-0 text-white">Employee</h3>
                    @if(auth()->user()->hasPermission('admin employees store'))
                    <button type="button" class="btn btn-dark me-1 mt-1 w-sm-100" data-bs-toggle="modal" data-bs-target="#createemp"><i class="icofont-plus-circle me-2 fs-6"></i>Add Employee</button>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->
    <div class="row g-3 py-1 pb-4">

        @foreach($users as $key => $user)
        <div class="col-md-3 col-6">
            <div class="card">
                <div class="card-body">
                    <div class="">
                        @if(auth()->user()->hasPermission('admin employees update'))
                        <button class="btn btn-toolbar float-start" data-bs-toggle="modal" data-bs-target="#editEmp{{$key}}"><i class="icofont-edit text-success"></i></button>
                        @endif
                        @if(auth()->user()->hasPermission('admin user ban unban'))
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
                        @endif
                    </div>
                    <div class="text-center">
                        <a href="{{route('employee.profile',$user->id)}}">
                            @if($user->userInfo->image == '')
                                <img src="{{asset('/')}}admin/assets/images/lg/{{$user->userInfo->gender == '1' ? 'avatar5.jpg':''}}{{$user->userInfo->gender == '2' ? 'avatar2.jpg':''}}{{$user->userInfo->gender == '3' ? 'avatar4.jpg':''}}" alt="" class="avatar xl rounded-circle img-thumbnail shadow-sm">
                            @else
                                <img src="{{asset($user->userInfo->image)}}" alt="" class="avatar xl rounded-circle img-thumbnail shadow-sm">
                            @endif
                            <div class="about-info align-items-center mt-3 justify-content-center">
                                <h6  class="mb-0 mt-2  fw-bold d-block fs-6">{{$user->name}}</h6>
                                <span class="light-info-bg py-1 px-2 rounded-1 d-inline-block fw-bold small-11 mb-0 mt-1">{{$user->userInfo->designations->name ?? 'N/A'}}<br> <span>({{ str_replace('_',' ',$user->userInfo->employee_type) }})</span></span><br>
                                <span class="light-info-bg py-1 px-2 rounded-1 d-inline-block fw-bold small-11 mb-0 mt-1">EIN : SL{{$user->userInfo->employee_id ?? 'N/A'}}</span>
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
                            <form action="{{route('admin.employees.update',$user->id)}}" method="post">
                                @csrf
                                @method('PUT')
                                <div class="mb-3">
                                    <label for="exampleFormControlInput877" class="form-label">Employee Name <span class="text-danger">*</span></label>
                                    <input type="text" name="name" required class="form-control" value="{{$user->name}}" id="exampleFormControlInput877" placeholder="Employee Name">
                                </div>
                                <div class="mb-3">
                                    <label for="exampleFormControlInput977" class="form-label">Email <span class="text-danger">*</span></label>
                                    <input type="email" name="email" required class="form-control" value="{{$user->email}}" id="exampleFormControlInput977" placeholder="Email Address">
                                </div>
                                <div class="deadline-form">
                                    <div class="row g-3 mb-3">
                                        <div class="col-sm-4">
                                            <label for="exampleFormControlInput1778" class="form-label">Employee ID <span class="text-danger">*</span></label>
                                            <input type="number" required name="employee_id" value="{{$user->userInfo->employee_id}}" class="form-control" id="exampleFormControlInput1778" placeholder="Employee Id">
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
                                            <input type="number" name="phone" class="form-control" value="{{$user->userInfo->mobile}}" id="exampleFormControlInput777" placeholder="phone number">
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
                                        <hr>
                                        <div class="row my-2">
                                            <h4 class="text-center text-white bg-black">Role</h4>

                                            @php($userRoles = \App\Models\UserRole::where('user_id',$user->id)->pluck('role_id')->toArray())
                                            <h5><input class="selectAll" id="selectAll" type="checkbox"> <label for="selectAll">Select All</label></h5>
                                            @foreach($roles as $key => $role)
                                                <div class="col-4">
                                                    <span>
                                                        <input type="checkbox" name="role_id[]" value="{{$role->id}}"
                                                               {{ in_array($role->id, $userRoles) ? 'checked' : '' }} id="role{{$key}}" class="itemCheckbox">
                                                        <label for="role{{$key}}">{{$role->name}}</label>
                                                    </span>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid justify-content-end">
                                    <button type="submit" onclick="return confirm('Are you sure to Update ?')" class="btn btn-primary">Update</button>
                                </div>
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
                    <form action="{{route('admin.employees.store')}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="exampleFormControlInput877" class="form-label">Employee Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" required class="form-control" value="{{old('name')}}" id="exampleFormControlInput877" placeholder="Employee Name">
                        </div>
                        <div class="mb-3">
                            <label for="exampleFormControlInput977" class="form-label">Email <span class="text-danger">*</span></label>
                            <input type="email" name="email" required class="form-control" value="{{old('name')}}" id="exampleFormControlInput977" placeholder="Email Address">
                        </div>
                        <div class="deadline-form">
                            <div class="row g-3 mb-3">
                                <div class="col-sm-4">
                                    <label for="exampleFormControlInput1778" class="form-label">Employee ID <span class="text-danger">*</span></label>
                                    <input type="number" required name="employee_id" value="{{old('employee_id')}}" class="form-control" id="exampleFormControlInput1778" placeholder="Employee Id">
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
                                    <input type="number" name="phone" class="form-control" value="{{old('phone')}}" id="exampleFormControlInput777" placeholder="phone number">
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
                                <hr>
                                <div class="row my-2">
                                    <h4 class="text-center text-white bg-black">Role</h4>
                                    <h5><input class="selectAll" id="selectAlladd" type="checkbox"> <label for="selectAlladd">Select All</label></h5>
                                    @foreach($roles as $key => $role)
                                        <div class="col-4">
                                                    <span>
                                                        <input type="checkbox" name="role_id[]" value="{{$role->id}}" id="roleAdd{{$key}}" class="itemCheckbox">
                                                        <label for="roleAdd{{$key}}">{{$role->name}}</label>
                                                    </span>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="d-grid justify-content-end">
                            <button type="submit" class="btn btn-primary">Create</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $('.selectAll').click(function() {
            $('.itemCheckbox').prop('checked', this.checked);
        });

        // Optional: If all checkboxes are manually checked, also check "Select All"
        $('.itemCheckbox').click(function() {
            if ($('.itemCheckbox:checked').length == $('.itemCheckbox').length) {
                $('.selectAll').prop('checked', true);
            } else {
                $('.selectAll').prop('checked', false);
            }
        });
    </script>
@endpush
