@extends('admin.layout.app')
@section('title','Assets Management')
@section('body')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Assets</h3>
                <div class="col-auto d-flex w-sm-100">
                    <button type="button" class="btn btn-dark btn-set-task w-sm-100" data-bs-toggle="modal" data-bs-target="#add_asset"><i class="icofont-plus-circle me-2 fs-6"></i>Add Asset</button>
                </div>
            </div>
        </div>
    </div>
    {{--<form action="" id="employee-form">
        <div class="row filter-row">
            <div class="col-sm-6 col-md-3">
                <div class="input-block mb-3 form-focus">
                    <input type="text" id="employee_name" class="form-control floating">
                    <label class="focus-label  text-white">Employee Name</label>
                </div>
            </div>
            <div class="col-sm-6 col-md-3">
                <div class="input-block mb-3 form-focus select-focus">
                    <input type="text" id="employee_id" class="form-control floating">
                    <label class="focus-label text-white">Employee Id</label>
                </div>
            </div>
        </div>
    </form>--}}
    <div class="row">
        <div class="col-md-12">
            <div class="card p-2">
                <div class="table-responsive" id="assetTable">
                    <table id="basic-datatable" class="table table-striped table-bordered mb-0">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Asset User</th>
                            <th>ID</th>
                            <th>Asset Name</th>
                            <th>Asset Id</th>
                            <th>Hand In</th>
                            <th>Hand Over</th>
                            <th>Amount</th>
                            <th class="text-center">Status</th>
                            <th class="text-end">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($assets as $key => $asset)
                            <tr style="font-size: 12px">
                                <td>{{$loop->iteration}}</td>
                                <td>{{$asset->user->name}}</td>
                                <td>{{$asset->user->userInfo->employee_id}}</td>
                                <td>
                                    <strong>{{$asset->asset_name}}</strong>
                                </td>
                                <td>{{$asset->asset_id}}</td>
                                <td>{{$asset->hand_in_date ?? 'N/A'}}</td>
                                <td>{{$asset->hand_over_date ?? '-'}}</td>
                                <td>৳ {{$asset->value}}</td>
                                <td class="text-center">
                            <span class="rounded-2 p-1  text-white {{$asset->status == 1 ? 'bg-success text-white':''}}{{$asset->status == 0 ? 'bg-danger text-dark':''}}">
                                {{$asset->status == 1 ? 'Active':''}}
                                {{$asset->status == 0 ? 'Unused':''}}
                            </span>
                                </td>
                                <td class="d-sm-flex justify-content-sm-between d-grid align-items-center">
                                    <a class="mx-1 my-1" href="#" data-bs-toggle="modal" data-bs-target="#show_asset{{$key}}"><i class="fa-solid btn btn-primary btn-sm fa-eye m-r-5"></i></a>
                                    <a class="mx-1 my-1" href="#" data-bs-toggle="modal" data-bs-target="#edit_asset{{$key}}"><i class="fa-solid btn btn-primary btn-sm fa-pencil m-r-5"></i></a>
                                    <a href="#" class="border-0 bg-transparent btn-sm" onclick="return confirm('are you sure to logout ?') ? document.getElementById('destroy-form').submit():''">
                                        <i onclick="" class="fa-regular btn btn-danger btn-sm text-white fa-trash-can m-r-5" type="submit"></i>
                                    </a>
                                    <form class="list-group-item list-group-item-action border-0" id="destroy-form" action="{{route('admin.asset.destroy',$asset->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>
                            <!-- Edit Asset Modal-->
                            <div class="modal fade" id="edit_asset{{$key}}" tabindex="-1"  aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title  fw-bold" id="depaddLabel"> Asset Edit</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <form action="{{route('admin.asset.update',$asset->id)}}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <div class="modal-body">
                                                <div class="row g-3 mb-3">
                                                    <div class="col-sm-6">
                                                        <label for="asset_name" class="form-label">Asset Name <span class="text-danger">*</span></label>
                                                        <input type="text" name="asset_name" value="{{$asset->asset_name}}" class="form-control" id="asset_name" required>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="asset_model" class="form-label">Model</label>
                                                        <input type="text" name="asset_model" value="{{$asset->asset_model}}" class="form-control" id="asset_model">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="asset_id" class="form-label">Asset ID <span class="text-danger">*</span></label>
                                                        <input type="text" name="asset_id" value="{{$asset->asset_id}}"  class="form-control" id="asset_id" required>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="user_id" class="form-label">Asset User <span class="text-danger">*</span></label>
                                                        <select class="form-control" name="user_id" id="user_id" required>
                                                            <option label="select one user"></option>
                                                            @foreach($users as $user)
                                                                <option {{$user->id == $asset->user_id ? 'selected':''}} value="{{$user->id}}">{{$user->name}} <small>({{$user->userInfo->designations->name}})</small></option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="purchase_date" class="form-label">Purchase Date</label>
                                                        <input type="date" name="purchase_date" value="{{$asset->purchase_date}}"  class="form-control" id="purchase_date">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="purchase_from" class="form-label">Purchase From</label>
                                                        <input type="text" name="purchase_from" value="{{$asset->purchase_from}}"  class="form-control" id="purchase_from">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="warranty" class="form-label">Warranty</label>
                                                        <input type="text" name="warranty" value="{{$asset->warranty}}"  class="form-control" id="warranty">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="warranty_end" class="form-label">Warranty End</label>
                                                        <input type="date" name="warranty_end" value="{{$asset->warranty_end}}"  class="form-control" id="warranty_end">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="hand_in_date" class="form-label">Hand In</label>
                                                        <input type="date" name="hand_in_date" value="{{$asset->hand_in_date}}"  class="form-control" id="hand_in_date">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="hand_over_dateEdit" class="form-label">Hand Over Date</label>
                                                        <input type="date" name="hand_over_date" value="{{$asset->hand_over_date}}"  class="form-control" id="hand_over_dateEdit">
                                                    </div>

                                                    <div class="col-sm-6">
                                                        <label for="condition" class="form-label">Condition</label>
                                                        <input type="text" name="condition" value="{{$asset->condition}}"  class="form-control" id="condition">
                                                    </div>
                                                    <div class="col-sm-6">
                                                        <label for="value" class="form-label">Value <span class="text-danger">*</span></label>
                                                        <input type="number" min="0" name="value" value="{{$asset->value}}"  class="form-control" id="value" required>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="">
                                                        <label for="description" class="form-label">Description</label>
                                                        <textarea name="description" class="form-control" id="description" cols="30" rows="4"> {{$asset->description}} </textarea>
                                                    </div>
                                                </div>
                                                <div class="deadline-form">
                                                    <div class="row g-3 mb-3">
                                                        <div class="col-sm-6">
                                                            <label for="status" class="form-label">Status</label>
                                                            <select class="form-control" name="status" id="status">
                                                                <option {{$asset->status == 1 ? 'selected':''}} value="1">Active</option>
                                                                <option {{$asset->status == 0 ? 'selected':''}}  value="0">Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-primary">Update</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

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
    <!-- Add Asset Modal-->
    <div class="modal fade" id="add_asset" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title  fw-bold" id="depaddLabel"> Asset Add</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{route('admin.asset.store')}}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="row g-3 mb-3">
                            <div class="col-sm-6">
                                <label for="asset_name" class="form-label">Asset Name <span class="text-danger">*</span></label>
                                <input type="text" name="asset_name" class="form-control" id="asset_name" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="asset_model" class="form-label">Model</label>
                                <input type="text" name="asset_model" class="form-control" id="asset_model">
                            </div>
                            <div class="col-sm-6">
                                <label for="asset_id" class="form-label">Asset ID <span class="text-danger">*</span></label>
                                <input type="text" name="asset_id" class="form-control" id="asset_id" required>
                            </div>
                            <div class="col-sm-6">
                                <label for="user_id" class="form-label">Asset User <span class="text-danger">*</span></label>
                                <select class="form-control" name="user_id" id="user_id" required>
                                    <option label="select one user"></option>
                                    @foreach($users as $user)
                                    <option value="{{$user->id}}">{{$user->name}} <small>({{$user->userInfo->designations->name}})</small></option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-sm-6">
                                <label for="purchase_date" class="form-label">Purchase Date</label>
                                <input type="date" name="purchase_date" class="form-control" id="purchase_date">
                            </div>
                            <div class="col-sm-6">
                                <label for="purchase_from" class="form-label">Purchase From</label>
                                <input type="text" name="purchase_from" class="form-control" id="purchase_from">
                            </div>
                            <div class="col-sm-6">
                                <label for="warranty" class="form-label">Warranty</label>
                                <input type="text" name="warranty" class="form-control" id="warranty">
                            </div>
                            <div class="col-sm-6">
                                <label for="warranty_end" class="form-label">Warranty End</label>
                                <input type="date" name="warranty_end" class="form-control" id="warranty_end">
                            </div>
                            <div class="col-sm-6">
                                <label for="hand_in_date" class="form-label">Hand In</label>
                                <input type="date" name="hand_in_date" class="form-control" id="hand_in_date">
                            </div>
                            <div class="col-sm-6">
                                <label for="hand_over_date" class="form-label">Hand Over</label>
                                <input type="date" name="hand_over_date" class="form-control" id="hand_over_date">
                            </div>

                            <div class="col-sm-6">
                                <label for="condition" class="form-label">Condition</label>
                                <input type="text" name="condition" class="form-control" id="condition">
                            </div>
                            <div class="col-sm-6">
                                <label for="value" class="form-label">Value <span class="text-danger">*</span></label>
                                <input type="number" min="0" name="value" class="form-control" id="value" required>
                            </div>
                        </div>
                        <div class="row">
                            <div class="">
                                <label for="description" class="form-label">Description</label>
                                <textarea name="description" class="form-control" id="description" cols="30" rows="4"></textarea>
                            </div>
                        </div>
                        <div class="deadline-form">
                            <div class="row g-3 mb-3">
                                <div class="col-sm-6">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" name="status" id="status">
                                        <option selected value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
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
@push('js')
    {{--<script>
        /*$(document).ready(function(){
            $("#employee_name").keyup(function(){
                var employeeName = $(this).val();
                var employeeNameLength = employeeName.length;

                if(employeeNameLength === 0){
                    var employeeName = 'null';
                }
                console.log(employeeName);
                $.ajax({
                        url: '--}}{{--{{route('admin.employee.filter.asset')}}--}}{{--',
                        type: 'GET',
                        data: {
                            employeeName: employeeName,
                        },
                        dataType: 'html',
                        success: function(response) {
                            if(response != ''){
                                $("#assetTable").empty();
                                $("#assetTable").html(response);
                            }
                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });

            });
            $("#employee_id").keyup(function(){
                var employeeId = $(this).val();
                var employeeIdLength = employeeId.length;
                if(employeeIdLength === 0){
                    var employeeId = 'null';
                }
                console.log(employeeId);
                $.ajax({
                        url: '--}}{{--{{route('admin.employee.filter.asset')}}--}}{{--',
                        type: 'GET',
                        data: {
                            // employeeName: employeeName,
                            employeeId: employeeId,
                        },
                        dataType: 'html',
                        success: function(response) {
                            if(response != ''){
                                $("#assetTable").empty();
                                $("#assetTable").html(response);
                            }

                        },
                        error: function(xhr, status, error) {
                            console.error(error);
                        }
                    });

            });

        });*/
        $(document).ready(function() {
            $("#employee_name,#employee_id").keyup(function(e){
            /*$('#employee_name, #employee_id').on('keyup', function(e) {*/
                e.preventDefault();
                var employeeId = $ ('#employee_id').val();
                var employeeName = $ ('#employee_name').val();
                var employeeNameLength = employeeName.length;
                if(employeeNameLength === 0){
                    var employeeName = 'null';
                }
                console.log('submit',employeeId,employeeName);

                // Send data via AJAX
                $.ajax({
                    url: '{{route('admin.employee.filter.asset')}}',
                    type: 'GET',
                    data: {
                        employeeId : employeeId,
                        employeeName : employeeName,
                    },
                    dataType: 'html',
                    success: function(response) {
                        if(response != ''){
                            $("#assetTable").empty();
                            $("#assetTable").html(response);
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error(error);
                    }
                });
            });
        });
    </script>--}}
@endpush
