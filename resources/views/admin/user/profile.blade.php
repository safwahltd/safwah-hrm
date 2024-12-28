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
                            <img src="{{asset('/')}}admin/assets/images/lg/{{$user->userInfo->gender == '1' ? 'avatar5.jpg':''}}{{$user->userInfo->gender == '2' ? 'avatar2.jpg':''}}{{$user->userInfo->gender == '3' ? 'avatar4.jpg':''}}" alt="" class="avatar xl rounded-circle img-thumbnail shadow-sm">
                        @else
                            <img src="{{asset($user->userInfo->image)}}" alt="" class="avatar xl rounded-circle img-thumbnail shadow-sm">
                        @endif
                        <div class="about-info d-flex align-items-center mt-3 justify-content-center flex-column">
                            <h6 class="mb-0 fw-bold d-block fs-6">{{$user->userInfo->designations->name ?? 'N/A'}}</h6>
                            <span class="text-danger fw-bold small">ID : {{$user->userInfo->employee_id ?? 'N/A'}}</span>
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
                                    <i class="icofont-users"></i>
                                    <span class="ms-2 small">{{ $user->userInfo->gender == '1' ? 'Male':''}}{{ $user->userInfo->gender == '2' ? 'Female':''}}{{ $user->userInfo->gender == '3' ? 'Other':''}} </span>
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
                                </div>
                                <div class="col-md-6">
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
                            </div>
                        </div>
                        <div class="tab-pane fade" id="pills-profile" role="tabpanel" aria-labelledby="pills-profile-tab">
                            <div class="row">
                                <div class="col-md-10">
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
                        <div class="tab-pane fade" id="pills-contact" role="tabpanel" aria-labelledby="pills-contact-tab">
                            <div class="row">
                                <div class="col-md-12">
                                    <div class="card bg-secondary-subtle">
                                        <div class="card-header py-3 d-flex justify-content-between">
                                            <h6 class="mb-0 fw-bold "><i class="fa-solid fa-building-columns"></i> Assets information</h6>
                                        </div>
                                        <div class="card-body table-responsive">
                                            <table id="basic-datatable" class="table table-striped table-bordered mb-0">
                                                <thead>
                                                <tr>
                                                    <th>SL</th>
                                                    <th>Asset User</th>
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
                                                        <td>{{$asset->user->name}}</td>
                                                        <td>
                                                            <strong>{{$asset->asset_name}}</strong>
                                                        </td>
                                                        <td>{{$asset->asset_id}}</td>
                                                        <td>{{$asset->hand_in_date ?? 'N/A'}}</td>
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
                                                                        <div class="col-6"><p class="">{{$asset->hand_over_date ?? 'N/A'}}</p></div>
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
                                                                            <p class="">
                                                                                <select class="form-control {{$asset->status == 1 ? 'bg-success text-dark':''}}{{$asset->status == 0 ? 'bg-danger text-white':''}}" name="status" id="status" disabled>
                                                                                    <option {{$asset->status == 1 ? 'selected':''}} value="1">Active</option>
                                                                                    <option {{$asset->status == 0 ? 'selected':''}}  value="0">Inactive</option>
                                                                                </select>
                                                                            </p>
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

@endsection
