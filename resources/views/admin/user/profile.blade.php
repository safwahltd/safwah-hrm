@extends('admin.layout.app')
@section('title','Employee Profile')
@section('body')
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card border-0 mb-4 no-bg">
                <div class="card-header py-3 px-0 d-flex align-items-center  justify-content-between border-bottom">
                    <h3 class=" fw-bold flex-fill mb-0 text-white">Employee Profile</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->

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
                                    <i class="icofont-address-book"></i>
                                    <span class="ms-2 small"><span class="text-danger">Present :</span> {{$user->userInfo->present_address ?? 'N/A'}}</span>
                                </div>
                            </div>
                            <div class="col-xl-5">
                                <div class="d-flex align-items-center">
                                    <i class="icofont-address-book"></i>
                                    <span class="ms-2 small"><span class="text-danger">Permanent :</span> {{$user->userInfo->permanent_address ?? 'N/A'}}</span>
                                </div>
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
    </div>
    <!-- Row End -->

@endsection
