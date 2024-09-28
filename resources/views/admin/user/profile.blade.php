@extends('admin.layout.app')
@section('title','Employee Profile')
@section('body')
    <div class="row clearfix">
        <div class="col-md-12">
            <div class="card border-0 mb-4 no-bg">
                <div class="card-header py-3 px-0 d-flex align-items-center  justify-content-between border-bottom">
                    <h3 class=" fw-bold flex-fill mb-0">Employee Profile</h3>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->

    <div class="row g-3">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card teacher-card  mb-3">
                <div class="card-body  d-flex teacher-fulldeatil">
                    <div class="profile-teacher pe-xl-4 pe-md-2 pe-sm-4 pe-0 text-center w220 mx-sm-0 mx-auto">
                        <a href="#">
                            @if($user->userInfo->image == '')
                                <img src="{{asset('/')}}admin/assets/images/lg/avatar3.jpg" alt="" class="avatar xl rounded-circle img-thumbnail shadow-sm">
                            @else
                                <img src="{{asset($user->userInfo->image)}}" alt="" class="avatar xl rounded-circle img-thumbnail shadow-sm">
                            @endif
                        </a>
                        <div class="about-info d-flex align-items-center mt-3 justify-content-center flex-column">
                            <h6 class="mb-0 fw-bold d-block fs-6">{{$user->userInfo->designations->name ?? 'N/A'}}</h6>
                            <span class="text-muted small">Employee Id : {{$user->userInfo->employee_id ?? 'N/A'}}</span>
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
                                    <span class="ms-2 small">{{$user->userInfo->mobile ?? 'N/A'}} </span>
                                </div>
                            </div>
                            <div class="col-xl-5">
                                <div class="d-flex align-items-center">
                                    <i class="icofont-email"></i>
                                    <span class="ms-2 small">{{$user->email ?? 'N/A'}}</span>
                                </div>
                            </div>
                            <div class="col-xl-5">
                                <div class="d-flex align-items-center">
                                    <i class="icofont-birthday-cake"></i>
                                    <span class="ms-2 small">{{$user->date_of_birth ?? 'N/A'}}</span>
                                </div>
                            </div>
                            <div class="col-xl-5">
                                <div class="d-flex align-items-center">
                                    <i class="icofont-address-book"></i>
                                    <span class="ms-2 small">{{$user->present_address ?? 'N/A'}}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header py-3 d-flex justify-content-between">
                            <h6 class="mb-0 fw-bold ">Personal Informations</h6>
                            <button type="button" class="btn p-0" data-bs-toggle="modal" data-bs-target="#edit1"><i class="icofont-edit text-primary fs-6"></i></button>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="row flex-wrap mb-3">
                                    <div class="col-6">
                                        <span class="fw-bold">Nationality</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted">{{$user->userInfo->nationality ?? 'N/A'}}</span>
                                    </div>
                                </li>
                                <li class="row flex-wrap mb-3">
                                    <div class="col-6">
                                        <span class="fw-bold">Religion</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted">{{$user->userInfo->religion ?? 'N/A'}}</span>
                                    </div>
                                </li>
                                <li class="row flex-wrap mb-3">
                                    <div class="col-6">
                                        <span class="fw-bold">Marital Status</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted">{{$user->userInfo->marital_status ?? 'N/A'}}</span>
                                    </div>
                                </li>
                                <li class="row flex-wrap mb-3">
                                    <div class="col-6">
                                        <span class="fw-bold">Passport No.</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted">{{$user->userInfo->passport_no ?? 'N/A'}}</span>
                                    </div>
                                </li>
                                <li class="row flex-wrap">
                                    <div class="col-6">
                                        <span class="fw-bold">Emergency Contact</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted">{{$user->userInfo->emergency_contact ?? 'N/A'}}</span>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12">
                    <div class="card">
                        <div class="card-header py-3 d-flex justify-content-between">
                            <h6 class="mb-0 fw-bold ">Bank information</h6>
                            <button type="button" class="btn p-0" data-bs-toggle="modal" data-bs-target="#edit2"><i class="icofont-edit text-primary fs-6"></i></button>
                        </div>
                        <div class="card-body">
                            <ul class="list-unstyled mb-0">
                                <li class="row flex-wrap mb-3">
                                    <div class="col-6">
                                        <span class="fw-bold">Bank Name</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted">{{$user->userInfo->bank_name ?? 'N/A'}}</span>
                                    </div>
                                </li>
                                <li class="row flex-wrap mb-3">
                                    <div class="col-6">
                                        <span class="fw-bold">Account No.</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted">{{$user->userInfo->bank_account_no ?? 'N/A'}}</span>
                                    </div>
                                </li>
                                <li class="row flex-wrap mb-3">
                                    <div class="col-6">
                                        <span class="fw-bold">IFSC Code</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted">{{$user->userInfo->bank_ifsc_code ?? 'N/A'}}</span>
                                    </div>
                                </li>
                                <li class="row flex-wrap mb-3">
                                    <div class="col-6">
                                        <span class="fw-bold">Pan No</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted">{{$user->userInfo->bank_pan_no ?? 'N/A'}}</span>
                                    </div>
                                </li>
                                <li class="row flex-wrap">
                                    <div class="col-6">
                                        <span class="fw-bold">UPI Id</span>
                                    </div>
                                    <div class="col-6">
                                        <span class="text-muted">{{$user->userInfo->bank_upi_id ?? 'N/A'}}</span>
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
                                <span class="d-flex text-muted">Jan 2016 - Present (5 years 2 months)</span>
                            </div>
                        </div>
                    </div> <!-- timeline item end  -->
                    <div class="timeline-item ti-info border-bottom ms-2">
                        <div class="d-flex">
                            <span class="avatar d-flex justify-content-center align-items-center rounded-circle bg-careys-pink">CC</span>
                            <div class="flex-fill ms-3">
                                <div class="mb-1"><strong>Crest Coder</strong></div>
                                <span class="d-flex text-muted">Dec 2015 - 2016 (1 years)</span>
                            </div>
                        </div>
                    </div> <!-- timeline item end  -->
                    <div class="timeline-item ti-success  ms-2">
                        <div class="d-flex">
                            <span class="avatar d-flex justify-content-center align-items-center rounded-circle bg-lavender-purple">MW</span>
                            <div class="flex-fill ms-3">
                                <div class="mb-1"><strong>Morning Wibe</strong></div>
                                <span class="d-flex text-muted">Nov 2014 - 2015 (1 years)</span>
                            </div>
                        </div>
                    </div>
                    <div class="timeline-item ti-danger border-bottom ms-2">
                        <div class="d-flex">
                            <span class="avatar d-flex justify-content-center align-items-center rounded-circle light-success-bg">FF</span>
                            <div class="flex-fill ms-3">
                                <div class="mb-1"><strong>FebiFlue</strong></div>
                                <span class="d-flex text-muted">Jan 2010 - 2009 (1 years)</span>
                            </div>
                        </div>
                    </div> <!-- timeline item end  -->
                </div>
            </div>
        </div>--}}
    </div>
    <!-- Row End -->
@endsection
