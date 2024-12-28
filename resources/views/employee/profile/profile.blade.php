@extends('admin.layout.app')
@section('title','Employee Profile')
@section('body')

    <div class="row g-3">
        <div class="col-xl-12 col-lg-12 col-md-12">
            <div class="card bg-secondary-subtle teacher-card mb-3">
                <div class="card-body  d-flex teacher-fulldeatil">
                    <div class="profile-teacher pe-xl-4 pe-md-2 pe-sm-4 pe-0 text-center w220 mx-sm-0 mx-auto">
                            @if(file_exists(auth()->user()->userInfo->image))
                            <img id="imagePreview" src="{{ asset($user->userInfo->image) }}" alt="" class="avatar xl rounded-circle img-thumbnail shadow-sm">
                            @else
                            <img id="imagePreview" src="{{asset('/')}}admin/assets/images/lg/{{ auth()->user()->userInfo->gender == '1' ? 'avatar5.jpg':''}}{{auth()->user()->userInfo->gender == '2' ? 'avatar2.jpg':''}}{{auth()->user()->userInfo->gender == '3' ? 'avatar4.jpg':''}}" alt="" class="avatar xl rounded-circle img-thumbnail shadow-sm">
                            @endif
                                <form action="{{route('employee.profile.picture.update')}}" method="POSt" enctype="multipart/form-data">
                                    @csrf
                                    <input type="file" id="image" name="image" required class="btn btn-sm form-control image-input">
                                    <button class="btn btn-primary my-1">change</button>
                                </form>
                        <div class="about-info d-flex align-items-center mt-3 justify-content-center flex-column">
                            <h6 class="mb-0 fw-bold d-block fs-6">{{$user->userInfo->designations->name ?? '-'}}</h6>
                            <span class="text-danger fw-bold small">ID : {{$user->userInfo->employee_id ?? '-'}}</span>
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
                        <h6  class="mb-0 mt-2  fw-bold d-block fs-6">{{$user->name ?? '-'}}</h6>
                        <span class="py-1 fw-bold small-11 mb-0 mt-1 text-muted">{{$user->userInfo->designations->name ?? '-'}}</span>
                        <p class="mt-2 small">{{$user->userInfo->biography ?? '-'}}</p>
                        <div class="row g-2 pt-2">
                            <div class="col-xl-5">
                                <div class="d-flex align-items-center">
                                    <i class="icofont-ui-touch-phone"></i>
                                    <span class="ms-2 small">{{$user->userInfo->official_mobile ?? '-'}} ( Official )</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="icofont-ui-touch-phone"></i>
                                    <span class="ms-2 small">{{$user->userInfo->mobile ?? '-'}} ( Personal )</span>
                                </div>
                            </div>
                            <div class="col-xl-5">
                                <div class="d-flex align-items-center">
                                    <i class="icofont-email"></i>
                                    <span class="ms-2 small">{{$user->email ?? '-'}} ( Official )</span>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="icofont-email"></i>
                                    <span class="ms-2 small">{{$user->userInfo->personal_email ?? '-'}} ( Personal )</span>
                                </div>
                            </div>
                            <div class="col-xl-5">
                                <div class="d-flex align-items-center">
                                    <i class="icofont-birthday-cake"></i>
                                    <span class="ms-2 small">{{ $user->userInfo->date_of_birth ?? '-'}}</span>
                                </div>
                            </div>
                            <div class="col-xl-5">
                                <div class="d-flex align-items-center">
                                    <i class="icofont-users"></i>
                                    <span class="ms-2 small">{{ $user->userInfo->gender == '1' ? 'Male':''}}{{ $user->userInfo->gender == '2' ? 'Female':''}}{{ $user->userInfo->gender == '3' ? 'Other':''}} </span>
                                </div>
                            </div>

                        </div>
                        <div class="row">
                            <div class="col-md-5 d-flex align-items-center">
                                <i class="icofont-address-book"></i>
                                <span class="ms-2 small"><span class="text-danger">Present :</span> {{$user->userInfo->present_address ?? '-'}}</span>
                            </div>
                            <div class="col-md-5 d-flex align-items-center p-1">
                                <i class="icofont-address-book"></i>
                                <span class="ms-2 small"><span class="text-danger">Permanent :</span> {{$user->userInfo->permanent_address ?? '-'}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row g-3">
                <div class="col-md-12">
                    <ul class="nav nav-pills mb-3" id="pills-tab" role="tablist">
                        <li class="nav-item" role="presentation">
                            <button class="nav-link active text-white" id="pills-home-tab" data-bs-toggle="pill" data-bs-target="#pills-home" type="button" role="tab" aria-controls="pills-home" aria-selected="true">General Info</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-white" id="pills-profile-tab" data-bs-toggle="pill" data-bs-target="#pills-profile" type="button" role="tab" aria-controls="pills-profile" aria-selected="false">Bank Info</button>
                        </li>
                        <li class="nav-item" role="presentation">
                            <button class="nav-link text-white" id="pills-contact-tab" data-bs-toggle="pill" data-bs-target="#pills-contact" type="button" role="tab" aria-controls="pills-contact" aria-selected="false">Assets</button>
                        </li>
                    </ul>
                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab">
                            <div class="row">
                                <div class="col-md-6">
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
                                                        <span class="text-dark">{{ucwords($user->userInfo->nationality ?? '-')}}</span>
                                                    </div>
                                                </li>
                                                <li class="row flex-wrap mb-3">
                                                    <div class="col-6">
                                                        <span class="fw-bold">Religion</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span class="text-dark">{{ucwords($user->userInfo->religion ?? '-')}}</span>
                                                    </div>
                                                </li>
                                                <li class="row flex-wrap mb-3">
                                                    <div class="col-6">
                                                        <span class="fw-bold">Marital Status</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span class="text-dark">{{$user->userInfo->marital_status ?? '-'}}</span>
                                                    </div>
                                                </li>
                                                <li class="row flex-wrap mb-3">
                                                    <div class="col-6">
                                                        <span class="fw-bold">Passport No.</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span class="text-dark">{{$user->userInfo->passport_or_nid ?? '-'}}</span>
                                                    </div>
                                                </li>
                                                <li class="row flex-wrap">
                                                    <div class="col-6">
                                                        <span class="fw-bold">Emergency Contact</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span class="text-dark">{{$user->userInfo->emergency_contact ?? '-'}}</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
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
                                                        <span class="text-dark">{{ucwords($user->userInfo->father ?? '-')}}</span>
                                                    </div>
                                                </li>
                                                <li class="row flex-wrap mb-3">
                                                    <div class="col-6">
                                                        <span class="fw-bold">Mother Name</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span class="text-dark">{{ucwords($user->userInfo->mother ?? '-')}}</span>
                                                    </div>
                                                </li>
                                                <li class="row flex-wrap mb-3">
                                                    <div class="col-6">
                                                        <span class="fw-bold">Spouse Name</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span class="text-dark">{{$user->userInfo->spouse ?? '-'}}</span>
                                                    </div>
                                                </li>
                                                <li class="row flex-wrap mb-3">
                                                    <div class="col-6">
                                                        <span class="fw-bold">Family Member</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span class="text-dark">{{$user->userInfo->family_member ?? '-'}} &nbsp; @if(!empty($user->userInfo->family_member)) <i class="fa-solid fa-people-roof"></i> @endif</span>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <div class="row">
                                <div class="col-md-12">
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
                                                        <span class="text-dark">{{$user->userInfo->bank_name ?? '-'}}</span>
                                                    </div>
                                                </li>
                                                <li class="row flex-wrap mb-3">
                                                    <div class="col-6">
                                                        <span class="fw-bold">Account Name</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span class="text-dark">{{$user->userInfo->account_name ?? '-'}}</span>
                                                    </div>
                                                </li>

                                                <li class="row flex-wrap mb-3">
                                                    <div class="col-6">
                                                        <span class="fw-bold">Account No.</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span class="text-dark">{{$user->userInfo->account_number ?? '-'}}</span>
                                                    </div>
                                                </li>
                                                <li class="row flex-wrap mb-3">
                                                    <div class="col-6">
                                                        <span class="fw-bold">Branch</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span class="text-dark">{{$user->userInfo->name_of_branch ?? '-'}}</span>
                                                    </div>
                                                </li>
                                                <li class="row flex-wrap mb-3">
                                                    <div class="col-6">
                                                        <span class="fw-bold">Swift Code</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span class="text-dark">{{$user->userInfo->swift_number ?? '-'}}</span>
                                                    </div>
                                                </li>
                                                <li class="row flex-wrap mb-3">
                                                    <div class="col-6">
                                                        <span class="fw-bold">Routing No</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span class="text-dark">{{$user->userInfo->routing_number ?? '-'}}</span>
                                                    </div>
                                                </li>
                                                <li class="row flex-wrap mb-3">
                                                    <div class="col-6">
                                                        <span class="fw-bold">Bank Code</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span class="text-dark">{{$user->userInfo->bank_code ?? '-'}}</span>
                                                    </div>
                                                </li>
                                                <li class="row flex-wrap mb-3">
                                                    <div class="col-6">
                                                        <span class="fw-bold">Branch Code</span>
                                                    </div>
                                                    <div class="col-6">
                                                        <span class="text-dark">{{$user->userInfo->branch_code ?? '-'}}</span>
                                                    </div>
                                                </li>

                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card bg-secondary-subtle">
                                        <div class="card-header py-3 d-flex justify-content-between">
                                            <h6 class="mb-0 fw-bold ">Assets information</h6>
                                        </div>
                                        <div class="card-body table-responsive">
                                            <table id="basic-datatable" class="table table-striped table-bordered mb-0">
                                                <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Asset Name</th>
                                                    <th>Asset Id</th>
                                                    <th>Hand In</th>
                                                    <th>Amount</th>
                                                    <th class="text-center">Status</th>
                                                    <th class="text-end">Action</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($assets as $key => $asset)
                                                    <tr>
                                                        <td>{{$loop->iteration}}</td>
                                                        <td>
                                                            <strong>{{$asset->asset_name}}</strong>
                                                        </td>
                                                        <td>{{$asset->asset_id}}</td>
                                                        <td>{{$asset->hand_in_date ?? '-'}}</td>
                                                        <td>{{$asset->value}}.tk</td>
                                                        <td class="text-center">
                                                            <span class="rounded-2 p-1  text-white {{$asset->status == 1 ? 'bg-success text-white':''}}{{$asset->status == 0 ? 'bg-danger text-dark':''}}">{{$asset->status == 1 ? 'Active':''}}{{$asset->status == 0 ? 'Inactive':''}}</span>
                                                        </td>
                                                        <td class="d-sm-flex justify-content-sm-between d-grid align-items-center">
                                                            <a class="mx-1 my-1" href="#" data-bs-toggle="modal" data-bs-target="#show_asset{{$key}}"><i class="fa-solid btn btn-primary btn-sm fa-eye m-r-5"></i></a>
                                                        </td>
                                                    </tr>
                                                    <!-- Show Asset Modal-->
                                                    <div class="modal fade " id="show_asset{{$key}}" tabindex="-1"  aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-centered modal-lg">
                                                            <div class="modal-content bg-black-subtle">
                                                                <div class="modal-header ">
                                                                    <h5 class="modal-title text-center fw-bold" id="depaddLabel"> Asset Details</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <div class="row px-2 border-0 fw-bold ">
                                                                        <div class="col-4"><label for="asset_name" class="form-label">Asset Name </label></div>
                                                                        <div class="col-2">:</div>
                                                                        <div class="col-6"><p class="">{{$asset->asset_name}}</p></div>
                                                                    </div>
                                                                    <div class="row px-2 border-0 fw-bold ">
                                                                        <div class="col-4"><label for="asset_model" class="form-label">Asset Model </label></div>
                                                                        <div class="col-2">:</div>
                                                                        <div class="col-6"><p class="">{{$asset->asset_model}}</p></div>
                                                                    </div>
                                                                    <div class="row px-2 border-0 fw-bold ">
                                                                        <div class="col-4"><label for="asset_id" class="form-label">Asset ID </label></div>
                                                                        <div class="col-2">:</div>
                                                                        <div class="col-6"><p class="">{{$asset->asset_id}}</p></div>
                                                                    </div>
                                                                    <div class="row px-2  fw-bold ">
                                                                        <div class="col-4"><label for="asset_id" class="form-label">Asset User </label></div>
                                                                        <div class="col-2">:</div>
                                                                        <div class="col-6"><p class="">{{$asset->user->name}} (<small>{{$asset->user->userInfo->designations->name}}</small>)</p></div>
                                                                    </div>
                                                                    <div class="row px-2  fw-bold ">
                                                                        <div class="col-4"><label for="purchase_date" class="form-label">Purchase Date</label></div>
                                                                        <div class="col-2">:</div>
                                                                        <div class="col-6"><p class="">{{$asset->purchase_date}}</p></div>
                                                                    </div>
                                                                    <div class="row px-2  fw-bold ">
                                                                        <div class="col-4"><label for="purchase_date" class="form-label">Hand In</label></div>
                                                                        <div class="col-2">:</div>
                                                                        <div class="col-6"><p class="">{{$asset->hand_in_date}}</p></div>
                                                                    </div>
                                                                    <div class="row px-2  fw-bold ">
                                                                        <div class="col-4"><label for="purchase_date" class="form-label">Hand Over</label></div>
                                                                        <div class="col-2">:</div>
                                                                        <div class="col-6"><p class="">{{$asset->hand_over_date ?? '-'}}</p></div>
                                                                    </div>

                                                                    <div class="row px-2  fw-bold ">
                                                                        <div class="col-4"><label for="purchase_from" class="form-label">Purchase From</label></div>
                                                                        <div class="col-2">:</div>
                                                                        <div class="col-6"><p class="">{{$asset->purchase_from}}</p></div>
                                                                    </div>
                                                                    <div class="row px-2  fw-bold ">
                                                                        <div class="col-4"><label for="warranty" class="form-label">Warranty</label></div>
                                                                        <div class="col-2">:</div>
                                                                        <div class="col-6"><p class="">{{$asset->warranty}}</p></div>
                                                                    </div>
                                                                    <div class="row px-2  fw-bold ">
                                                                        <div class="col-4"><label for="purchase_date" class="form-label">Purchase Date</label></div>
                                                                        <div class="col-2">:</div>
                                                                        <div class="col-6"><p class="">{{$asset->purchase_date}}</p></div>
                                                                    </div>
                                                                    <div class="row px-2  fw-bold ">
                                                                        <div class="col-4"><label for="warranty_end" class="form-label">Warranty End</label></div>
                                                                        <div class="col-2">:</div>
                                                                        <div class="col-6"><p class="">{{$asset->warranty_end}}</p></div>
                                                                    </div>
                                                                    <div class="row px-2  fw-bold ">
                                                                        <div class="col-4"><label for="condition" class="form-label">Condition</label></div>
                                                                        <div class="col-2">:</div>
                                                                        <div class="col-6"><p class="">{{$asset->condition}}</p></div>
                                                                    </div>
                                                                    <div class="row px-2  fw-bold ">
                                                                        <div class="col-4"><label for="condition" class="form-label">Value</label></div>
                                                                        <div class="col-2">:</div>
                                                                        <div class="col-6"><p class="">{{$asset->value}}</p></div>
                                                                    </div>

                                                                    <div class="row px-2  fw-bold ">
                                                                        <div class="col-4"><label for="description" class="form-label">Description</label></div>
                                                                        <div class="col-2">:</div>
                                                                        <div class="col-6"><p class="">{{$asset->description}}</p></div>
                                                                    </div>
                                                                    <div class="row px-2  fw-bold ">
                                                                        <div class="col-4"><label for="description" class="form-label">Status</label></div>
                                                                        <div class="col-2">:</div>
                                                                        <div class="col-6">
                                                                            <span class="p-1 rounded-2 {{$asset->status == 1 ? 'bg-success text-white':''}}{{$asset->status == 0 ? 'bg-danger text-white':''}}">{{$asset->status == 1 ? 'Active':'Inactive'}}</span>
                                                                        </div>
                                                                    </div>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
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
                                        <option {{$user->userInfo->gender == '1' ? 'selected':''}} value="1">Male</option>
                                        <option {{$user->userInfo->gender == '2' ? 'selected':''}} value="2">Female</option>
                                        <option {{$user->userInfo->gender == '3' ? 'selected':''}} value="3">Other</option>
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
@push('js')

    <script>
        $(document).ready(function() {
            // When the user selects a file in the input field
            $('#image').change(function(event) {
                // Get the selected file
                var file = event.target.files[0];

                // Check if a file is selected
                if (file) {
                    // Create a URL for the selected file (used to display the image)
                    var reader = new FileReader();
                    reader.onload = function(e) {
                        // Display the preview image
                        $('#imagePreview').attr('src', e.target.result).show();
                    };
                    reader.readAsDataURL(file);
                } else {
                    // Hide the preview image if no file is selected
                    $('#imagePreview').hide();
                }
            });
        });
    </script>

@endpush
