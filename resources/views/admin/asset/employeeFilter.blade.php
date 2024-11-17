<table id="basic-datatable" class="table table-striped table-bordered mb-0">
    <thead>
    <tr>
        <th>Asset User</th>
        <th>Asset Name</th>
        <th>Asset Id</th>
        <th>Hand In</th>
        <th>Warranty</th>
        {{--                        <th>Warrenty End</th>--}}
        <th>Amount</th>
        <th class="text-center">Status</th>
        <th class="text-end">Action</th>
    </tr>
    </thead>
    <tbody>
    @forelse($assets as $key => $asset)
        <tr>
            <td>{{$asset->user->name}}</td>
            <td>
                <strong>{{$asset->asset_name}}</strong>
            </td>
            <td>{{$asset->asset_id}}</td>
            <td>{{$asset->hand_in_date ?? 'N/A'}}</td>
            <td>{{$asset->warranty ?? 'N/A'}}</td>
            {{--                        <td>5 Jan 2019</td>--}}
            <td>{{$asset->value}}.tk</td>
            <td class="text-center">
                <select name="status" id="" class="form-control-sm {{$asset->status == 1 ? 'text-white bg-success':''}}{{$asset->status == 0 ? 'text-dark bg-danger':''}} ">
                    <option {{$asset->status == 1 ? 'selected':''}} value="1">Active</option>
                    <option {{$asset->status == 0 ? 'selected':''}} value="0">Inactive</option>
                </select>
            </td>
            <td class="d-flex justify-content-end">
                <a class="mx-1" href="#" data-bs-toggle="modal" data-bs-target="#show_asset{{$key}}"><i class="fa-solid btn btn-primary fa-eye m-r-5"></i></a>
                <a class="" href="#" data-bs-toggle="modal" data-bs-target="#edit_asset{{$key}}"><i class="fa-solid btn btn-primary fa-pencil m-r-5"></i></a>
                <a class="mx-1" href="#" data-bs-toggle="modal" data-bs-target="#delete_asset">
                    <form action="{{route('asset.destroy',$asset->id)}}" method="post">
                        @csrf
                        @method('DELETE')
                        <button class="border-0" onclick="return confirm('are you sure to delete ?') ? this.form.submit():''"><i onclick="" class="fa-regular btn btn-danger text-white fa-trash-can m-r-5" type="submit"></i></button>
                    </form>

                </a>
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
                    <form action="{{route('asset.update',$asset->id)}}" method="post">
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
                                    <label for="Hand_out_date" class="form-label">Hand_out_date</label>
                                    <input type="date" name="Hand_out_date" value="{{$asset->Hand_out_date}}"  class="form-control" id="Hand_out_date">
                                </div>

                                <div class="col-sm-6">
                                    <label for="condition" class="form-label">Condition</label>
                                    <input type="text" name="condition" value="{{$asset->condition}}"  class="form-control" id="condition">
                                </div>
                                <div class="col-sm-6">
                                    <label for="value" class="form-label">Value <span class="text-danger">*</span></label>
                                    <input type="text" name="value" value="{{$asset->value}}"  class="form-control" id="value" required>
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
    @empty
        <tr class="text-center">
            <td colspan="8">No Data Found</td>
        </tr>
    @endforelse
    </tbody>
</table>
