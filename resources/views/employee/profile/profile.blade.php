@extends('admin.layout.app')
@section('title','Employee Profile')
@section('body')

    <div class="row g-3">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card bg-secondary-subtle teacher-card mb-3">
                <div class="card-body  d-flex teacher-fulldeatil">
                    <div class="profile-teacher pe-xl-4 pe-md-2 pe-sm-4 pe-0 text-center w220 mx-sm-0 mx-auto">
                            @if($user->userInfo->image == '')
                                <img src="{{asset('/')}}admin/assets/images/lg/avatar3.jpg" alt="" class="avatar xl rounded-circle img-thumbnail shadow-sm">
                            @else
                                <img src="{{asset($user->userInfo->image)}}" alt="" class="avatar xl rounded-circle img-thumbnail shadow-sm">
                            @endif
                                <form action="{{route('employee.profile.picture.update')}}" method="POSt" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" name="image" required class="btn btn-sm form-control">
                                    <button class="btn btn-primary my-1">change</button>
                                </form>
                        <div class="about-info d-flex align-items-center mt-3 justify-content-center flex-column">
                            <h6 class="mb-0 fw-bold d-block fs-6">{{$user->userInfo->designations->name ?? 'N/A'}}</h6>
                            <span class="text-muted small">Employee Id : {{$user->userInfo->employee_id ?? 'N/A'}}</span>
                        </div>
                        <div class="my-1">
                            <a class="mx-2" href="{{$user->userInfo->facebook}}" target="_blank">
                                <i class="icofont-facebook"></i>
                            </a>
                            <a class="" href="{{$user->userInfo->instagram}}" target="_blank">
                                <i class="icofont-instagram"></i>
                            </a>
                            <a class="mx-2" href="{{$user->userInfo->linkedIn}}" target="_blank">
                                <i class="icofont-linkedin"></i>
                            </a>
                            <a class="" href="{{$user->userInfo->twitter}}" target="_blank">
                                <i class="icofont-twitter"></i>
                            </a>
                            <a class="mx-2" href="{{$user->userInfo->github}}" target="_blank">
                                <i class="icofont-github"></i>
                            </a>
                        </div>
                    </div>
                    <div class="teacher-info border-start ps-xl-4 ps-md-3 ps-sm-4 ps-4 w-100">
                        <p class="text-end">
                            <button type="button" class="btn p-0" data-bs-toggle="modal" data-bs-target="#personalInfo"><i class="icofont-edit text-primary fs-6"></i></button>
                        </p>
                        <h6  class="mb-0 mt-2  fw-bold d-block fs-6">{{$user->name ?? 'N/A'}}</h6>
                        <span class="py-1 fw-bold small-11 mb-0 mt-1 text-muted">{{$user->userInfo->designations->name ?? 'N/A'}}</span>
                        <p class="mt-2 small">{{$user->userInfo->biography ?? 'N/A'}}</p>
                        <div class="row g-2 pt-2">
                            <div class="col-xl-5">
                                <div class="d-flex align-items-center">
                                    <i class="icofont-ui-touch-phone"></i>
                                    <span class="ms-2 small">{{$user->userInfo->official_mobile ?? 'N/A'}} ( Official )</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="icofont-ui-touch-phone"></i>
                                    <span class="ms-2 small">{{$user->userInfo->mobile ?? 'N/A'}} ( Personal )</span>
                                </div>
                            </div>
                            <div class="col-xl-5">
                                <div class="d-flex align-items-center">
                                    <i class="icofont-email"></i>
                                    <span class="ms-2 small">{{$user->email ?? 'N/A'}} ( Official )</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="icofont-email"></i>
                                    <span class="ms-2 small">{{$user->userInfo->personal_email ?? 'N/A'}} ( Personal )</span>
                                </div>
                            </div>
                            <div class="col-xl-5">
                                <div class="d-flex align-items-center">
                                    <i class="icofont-birthday-cake"></i>
                                    <span class="ms-2 small">{{ $user->userInfo->date_of_birth ?? 'N/A'}}</span>
                                </div>
                            </div>
                            <div class="col-xl-5">
                                <div class="d-flex align-items-center">
                                    <i class="icofont-birthday-cake"></i>
                                    <span class="ms-2 small">{{ $user->userInfo->gender ?? 'N/A'}}</span>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-5 d-flex align-items-center">
                                <i class="icofont-address-book"></i>
                                <span class="ms-2 small"><span class="text-danger">Present :</span> {{$user->userInfo->present_address ?? 'N/A'}}</span>
                            </div>
                            <div class="col-md-5 d-flex align-items-center p-1">
                                <i class="icofont-address-book"></i>
                                <span class="ms-2 small"><span class="text-danger">Permanent :</span> {{$user->userInfo->permanent_address ?? 'N/A'}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                    <div class="card bg-secondary-subtle">
                        <div class="card-header py-3 d-flex justify-content-between">
                            <h6 class="mb-0 fw-bold ">General Informations</h6>
                            <button type="button" class="btn p-0" data-bs-toggle="modal" data-bs-target="#generalInfo"><i class="icofont-edit text-primary fs-6"></i></button>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="row flex-wrap mb-3">
                                    <div class="col-6">
                                        <span class="fw-bold">Nationality</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-dark">{{ucwords($user->userInfo->nationality ?? 'N/A')}}</span>
                                    </div>
                                </li>
                                <li class="row flex-wrap mb-3">
                                    <div class="col-6">
                                        <span class="fw-bold">Religion</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-dark">{{ucwords($user->userInfo->religion ?? 'N/A')}}</span>
                                    </div>
                                </li>
                                <li class="row flex-wrap mb-3">
                                    <div class="col-6">
                                        <span class="fw-bold">Marital Status</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-dark">{{$user->userInfo->marital_status ?? 'N/A'}}</span>
                                    </div>
                                </li>
                                <li class="row flex-wrap mb-3">
                                    <div class="col-6">
                                        <span class="fw-bold">Passport No.</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-dark">{{$user->userInfo->passport_or_nid ?? 'N/A'}}</span>
                                    </div>
                                </li>
                                <li class="row flex-wrap">
                                    <div class="col-6">
                                        <span class="fw-bold">Emergency Contact</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-dark">{{$user->userInfo->emergency_contact ?? 'N/A'}}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    <div class="card bg-secondary-subtle my-2">
                        <div class="card-header py-3  d-flex justify-content-between">
                            <h6 class="mb-0 fw-bold"><i class="fa-solid fa-people-roof"></i> Family Information</h6>
                            <button type="button" class="btn p-0" data-bs-toggle="modal" data-bs-target="#generalInfo"><i class="icofont-edit text-primary fs-6"></i></button>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="row flex-wrap mb-3">
                                    <div class="col-6">
                                        <span class="fw-bold">Father Name</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-dark">{{ucwords($user->userInfo->father ?? 'N/A')}}</span>
                                    </div>
                                </li>
                                <li class="row flex-wrap mb-3">
                                    <div class="col-6">
                                        <span class="fw-bold">Mother Name</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-dark">{{ucwords($user->userInfo->mother ?? 'N/A')}}</span>
                                    </div>
                                </li>
                                <li class="row flex-wrap mb-3">
                                    <div class="col-6">
                                        <span class="fw-bold">Spouse Name</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-dark">{{$user->userInfo->spouse ?? 'N/A'}}</span>
                                    </div>
                                </li>
                                <li class="row flex-wrap mb-3">
                                    <div class="col-6">
                                        <span class="fw-bold">Family Member</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-dark">{{$user->userInfo->family_member ?? 'N/A'}} &nbsp;<i class="fa-solid fa-people-roof"></i></span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                </div>
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                    <div class="card bg-secondary-subtle">
                        <div class="card-header py-3 d-flex justify-content-between">
                            <h6 class="mb-0 fw-bold "><i class="fa-solid fa-building-columns"></i> Bank information</h6>
                            <button type="button" class="btn p-0" data-bs-toggle="modal" data-bs-target="#bankInfo"><i class="icofont-edit text-primary fs-6"></i></button>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="row flex-wrap mb-3">
                                    <div class="col-6">
                                        <span class="fw-bold">Bank Name</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-dark">{{$user->userInfo->bank_name ?? 'N/A'}}</span>
                                    </div>
                                </li>
                                <li class="row flex-wrap mb-3">
                                    <div class="col-6">
                                        <span class="fw-bold">Account Name</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-dark">{{$user->userInfo->account_name ?? 'N/A'}}</span>
                                    </div>
                                </li>

                                <li class="row flex-wrap mb-3">
                                    <div class="col-6">
                                        <span class="fw-bold">Account No.</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-dark">{{$user->userInfo->account_number ?? 'N/A'}}</span>
                                    </div>
                                </li>
                                <li class="row flex-wrap mb-3">
                                    <div class="col-6">
                                        <span class="fw-bold">Branch</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-dark">{{$user->userInfo->name_of_branch ?? 'N/A'}}</span>
                                    </div>
                                </li>
                                <li class="row flex-wrap mb-3">
                                    <div class="col-6">
                                        <span class="fw-bold">Swift Code</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-dark">{{$user->userInfo->swift_number ?? 'N/A'}}</span>
                                    </div>
                                </li>
                                <li class="row flex-wrap mb-3">
                                    <div class="col-6">
                                        <span class="fw-bold">Routing No</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-dark">{{$user->userInfo->routing_number ?? 'N/A'}}</span>
                                    </div>
                                </li>
                                <li class="row flex-wrap mb-3">
                                    <div class="col-6">
                                        <span class="fw-bold">Bank Code</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-dark">{{$user->userInfo->bank_code ?? 'N/A'}}</span>
                                    </div>
                                </li>
                                <li class="row flex-wrap mb-3">
                                    <div class="col-6">
                                        <span class="fw-bold">Branch Code</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-dark">{{$user->userInfo->branch_code ?? 'N/A'}}</span>
                                    </div>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{--<div class="col-xl-4 col-lg-12 col-md-12">
            <div class="card">
                <div class="card-header py-3">
                    <h6 class="mb-0 fw-bold ">Experience</h6>
                </div>
                <div class="card-body">
                    <div class="timeline-item ti-danger border-bottom ms-2">
                        <div class="d-flex">
                            <span class="avatar d-flex justify-content-center align-items-center rounded-circle light-success-bg">PW</span>
                            <div class="flex-fill ms-3">
                                <div class="mb-1"><strong>Pixel Wibes</strong></div>
                                <span class="d-flex text-dark">Jan 2016 - Present (5 years 2 months)</span>
                            </div>
                        </div>
                    </div> <!-- timeline item end  -->
                    <div class="timeline-item ti-info border-bottom ms-2">
                        <div class="d-flex">
                            <span class="avatar d-flex justify-content-center align-items-center rounded-circle bg-careys-pink">CC</span>
                            <div class="flex-fill ms-3">
                                <div class="mb-1"><strong>Crest Coder</strong></div>
                                <span class="d-flex text-dark">Dec 2015 - 2016 (1 years)</span>
                            </div>
                        </div>
                    </div> <!-- timeline item end  -->
                    <div class="timeline-item ti-success  ms-2">
                        <div class="d-flex">
                            <span class="avatar d-flex justify-content-center align-items-center rounded-circle bg-lavender-purple">MW</span>
                            <div class="flex-fill ms-3">
                                <div class="mb-1"><strong>Morning Wibe</strong></div>
                                <span class="d-flex text-dark">Nov 2014 - 2015 (1 years)</span>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-item ti-danger border-bottom ms-2">
                        <div class="d-flex">
                            <span class="avatar d-flex justify-content-center align-items-center rounded-circle light-success-bg">FF</span>
                            <div class="flex-fill ms-3">
                                <div class="mb-1"><strong>FebiFlue</strong></div>
                                <span class="d-flex text-dark">Jan 2010 - 2009 (1 years)</span>
                            </div>
                        </div>
                    </div> <!-- timeline item end  -->
                </div>
            </div>
        </div>--}}
    </div>
    <!-- Row End -->

    <!-- Edit Employee Personal Info-->
    <div class="modal fade" id="personalInfo" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content bg-secondary-subtle">
                <div class="modal-header">
                    <h5 class="modal-title  fw-bold" id="edit1Label"> Personal Informations</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="deadline-form">
                        <form action="{{route('employee.personal.info.update')}}" method="post">
                            @csrf
                            <div class="row g-3 mb-3">
                                <div class="col-6">
                                    <label for="nameUpdate" class="form-label">Name</label>
                                    <input type="text" class="form-control" name="name" placeholder="name" id="nameUpdate" value="{{$user->userInfo->name}}">
                                </div>
                                <div class="col-6">
                                    <label for="mobile1" class="form-label">Personal Mobile</label>
                                    <input type="number" class="form-control" name="mobile" placeholder="mobile" id="mobile1" value="{{$user->userInfo->mobile}}">
                                </div>
                                <div class="col-6">
                                    <label for="official_mobile" class="form-label">Official Mobile</label>
                                    <input type="number" class="form-control" name="official_mobile" placeholder="Official Mobile Number" id="official_mobile" value="{{$user->userInfo->official_mobile}}">
                                </div>

                                <div class="col-6">
                                    <label for="personal_email" class="form-label">Personal Email</label>
                                    <input type="email" class="form-control" name="personal_email" placeholder="Personal Email Address" id="personal_email" value="{{$user->userInfo->personal_email}}">
                                </div>

                                <div class="col-6">
                                    <label for="exampleFormControlInput977" class="form-label">Birth Date</label>
                                    <input type="date" class="form-control" name="date_of_birth" placeholder="Religion" id="exampleFormControlInput977" value="{{$user->userInfo->date_of_birth}}">
                                </div>
                                <div class="col">
                                    <label for="gender" class="form-label">Gender</label>
                                    <select name="gender" id="gender" class="form-control">
                                        <option label="Select One"></option>
                                        <option {{$user->userInfo->gender == 'Male' ? 'selected':''}} value="Male">Male</option>
                                        <option {{$user->userInfo->gender == 'Female' ? 'selected':''}} value="Female">Female</option>
                                        <option {{$user->userInfo->gender == 'Other' ? 'selected':''}} value="Other">Other</option>
                                    </select>
                                </div>
                                <div class="col-6">
                                    <label for="exampleFormControlInput4777" class="form-label">Present Address</label>
                                    <textarea class="form-control" name="present_address" id="present_address" cols="30" rows="3">{{$user->userInfo->present_address}}</textarea>
                                </div>
                                <div class="col-6">
                                    <label for="exampleFormControlInput4777" class="form-label">Permanent Address</label>
                                    <textarea class="form-control" name="permanent_address" id="permanent_address" cols="30" rows="3">{{$user->userInfo->permanent_address}}</textarea>
                                </div>

                                <div class="col-6">
                                    <label for="exampleFormControlInput4777" class="form-label">Facebook</label>
                                    <input type="url" class="form-control" name="facebook" id="exampleFormControlInput4777" placeholder="Facebook Account" value="{{$user->userInfo->facebook}}">
                                </div>
                                <div class="col-6">
                                    <label for="exampleFormControlInput4777" class="form-label">Instagram</label>
                                    <input type="url" class="form-control" name="instagram" id="exampleFormControlInput4777" placeholder="Instagram Instagram" value="{{$user->userInfo->instagram}}">
                                </div>
                                <div class="col-6">
                                    <label for="linkedIn" class="form-label">LinkedIn</label>
                                    <input type="url" class="form-control" name="linkedIn" id="linkedIn" placeholder="Instagram Instagram" value="{{$user->userInfo->linkedIn}}">
                                </div>
                                <div class="col-6">
                                    <label for="exampleFormControlInput4777" class="form-label">Twitter</label>
                                    <input type="url" class="form-control" name="twitter" id="exampleFormControlInput4777" placeholder="Twitter Account" value="{{$user->userInfo->twitter}}">
                                </div>
                                <div class="col-6">
                                    <label for="github" class="form-label">Github</label>
                                    <input type="url" class="form-control" name="github" id="github" placeholder="Github Account" value="{{$user->userInfo->github}}">
                                </div>
                                <div class="col-12">
                                    <label for="biography" class="form-label">Biography</label>
                                    <textarea class="form-control" name="biography" id="biography" cols="30" rows="3">{{$user->userInfo->biography}}</textarea>
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Edit Employee General Info-->
    <div class="modal fade" id="generalInfo" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content bg-secondary-subtle">
                <div class="modal-header">
                    <h5 class="modal-title  fw-bold" id="edit1Label"> General Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="deadline-form">
                        <form action="{{route('employee.general.info.update')}}" method="post">
                            @csrf
                            <div class="row g-3 mb-3">
                                <div class="col">
                                    <label for="exampleFormControlInput877" class="form-label">Nationality</label>
                                    <input type="text" class="form-control" name="nationality" placeholder="Nationality" id="exampleFormControlInput877" value="{{$user->userInfo->nationality}}">
                                </div>
                                <div class="col">
                                    <label for="exampleFormControlInput977" class="form-label">Religion</label>
                                    <input type="text" class="form-control" name="religion" placeholder="Religion" id="exampleFormControlInput977" value="{{$user->userInfo->religion}}">
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col">
                                    <label for="exampleFormControlInput9777" class="form-label">Marital Status</label>
                                    <select name="marital_status" id="exampleFormControlInput9777" class="form-control">
                                        <option label="Select One"></option>
                                        <option {{$user->userInfo->marital_status == 'Single' ? 'selected':''}} value="Single">Single</option>
                                        <option {{$user->userInfo->marital_status == 'Married' ? 'selected':''}} value="Married">Married</option>
                                        <option {{$user->userInfo->marital_status == 'Divorced' ? 'selected':''}} value="Divorced">Divorced</option>
                                    </select>
                                </div>
                                <div class="col">
                                    <label for="passport_or_nid" class="form-label">Passport/NID No</label>
                                    <input type="text" class="form-control" name="passport_or_nid" id="passport_or_nid" placeholder="Passport/NID No" value="{{$user->userInfo->passport_no}}">
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-6">
                                    <label for="exampleFormControlInput4777" class="form-label">Emergency Contact</label>
                                    <input type="text" class="form-control" name="emergency_contact" id="exampleFormControlInput4777" placeholder="Emergency Contact" value="{{$user->userInfo->emergency_contact}}">
                                </div>
                            </div>
                            <div class="text-center">
                                <h5 class="border fw-bold p-1 bg-secondary-subtle">Family Info</h5>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-6">
                                    <label for="father" class="form-label">Father Name</label>
                                    <input type="text" class="form-control" name="father" id="father" placeholder="Father Name" value="{{$user->userInfo->father}}">
                                </div>
                                <div class="col-6">
                                    <label for="mother" class="form-label">Mother Name</label>
                                    <input type="text" class="form-control" name="mother" id="mother" placeholder="Mother Name" value="{{$user->userInfo->mother}}">
                                </div>
                                <div class="col-6">
                                    <label for="spouse" class="form-label">Spouse Name</label>
                                    <input type="text" class="form-control" name="spouse" id="spouse" placeholder="Spouse Name" value="{{$user->userInfo->spouse}}">
                                </div>
                                <div class="col-6">
                                    <label for="family_member" class="form-label">Family Member</label>
                                    <input type="number" class="form-control" name="family_member" id="family_member" placeholder="Family Member" value="{{$user->userInfo->family_member}}">
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-primary">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

    <!-- Edit Bank Personal Info-->
    <div class="modal fade" id="bankInfo" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content bg-secondary-subtle">
                <div class="modal-header">
                    <h5 class="modal-title  fw-bold" id="edit2Label"> Bank information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="deadline-form">
                        <form action="{{route('employee.bank.info.update')}}" method="post">
                            @csrf
                            <div class="row g-3 mb-3">
                                <div class="col">
                                    <label for="exampleFormControlInput8775" class="form-label">Bank Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="bank_name" id="exampleFormControlInput8775" placeholder="Enter Bank Name" value="{{$user->userInfo->bank_name}}">
                                </div>
                                <div class="col">
                                    <label for="account_name" class="form-label">Account Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="account_name" id="account_name" placeholder="Enter Bank Account Name" value="{{$user->userInfo->account_name}}">
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col">
                                    <label for="account_number" class="form-label">Account Number <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="account_number" id="account_number" placeholder="Enter Bank Account Number" value="{{$user->userInfo->account_number}}">
                                </div>
                                <div class="col">
                                    <label for="name_of_branch" class="form-label">Branch Name <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="name_of_branch" id="name_of_branch" placeholder="Enter Bank Branch Name" value="{{$user->userInfo->name_of_branch}}">
                                </div>
                            </div>

                            <div class="row g-3 mb-3">
                                <div class="col">
                                    <label for="swift_number" class="form-label">Swift Code <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="swift_number" id="swift_number" placeholder="Enter Bank Swift Code" value="{{$user->userInfo->swift_number}}">
                                </div>
                                <div class="col">
                                    <label for="routing_number" class="form-label">Routing No <span class="text-danger">*</span></label>
                                    <input type="text" class="form-control" name="routing_number" id="routing_number" placeholder="Enter Routing No" value="{{$user->userInfo->routing_number}}">
                                </div>
                            </div>
                            <div class="row g-3 mb-3">
                                <div class="col-6">
                                    <label for="bank_code" class="form-label">Bank Code</label>
                                    <input type="text" class="form-control" name="bank_code" id="bank_code" placeholder="Enter Bank Code" value="{{$user->userInfo->bank_code}}">
                                </div>
                                <div class="col-6">
                                    <label for="branch_code" class="form-label">Branch Code</label>
                                    <input type="text" class="form-control" name="branch_code" id="branch_code" placeholder="Enter Branch Code" value="{{$user->userInfo->branch_code}}">
                                </div>

                            </div>
                            <div class="modal-footer">
                                <button type="submit" class="btn btn-success">Save</button>
                            </div>
                        </form>
                    </div>
                </div>

            </div>
        </div>
    </div>

@endsection
