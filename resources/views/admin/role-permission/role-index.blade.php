@extends('admin.layout.app')
@section('title','Role')
@section('body')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Role</h3>
                <div class="col-auto d-flex w-sm-100">
                    <button type="button" class="btn btn-dark btn-set-task w-sm-100" data-bs-toggle="modal" data-bs-target="#addRole">Add <i class="icofont-plus-circle me-2 fs-6"></i></button>
                </div>
            </div>
        </div>
    </div>
    <!-- Row end  -->

    <div class="row clearfix g-3">
        <div class="col-sm-12">
            <div class="card mb-3">
                <div class="card-body">
                    <table  class="table table-bordered text-nowrap key-buttons border-bottom  w-100">
                        <thead>
                            <tr>
                            <th class="border-bottom-0">SL No</th>
                            <th class="border-bottom-0">Name</th>
                            <th class="border-bottom-0">Status</th>
                            <th class="border-bottom-0">Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($roles as $key => $role)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $role->name }}</td>
                                <td class="col-2">
                                    <span class="p-1  text-white {{$role->status == 1 ? 'bg-success':'bg-warning'}}">{{$role->status == 1 ? 'Active':'Inactive'}}</span>
                                </td>
                                <td class="d-flex">
                                    <a href="#" class="btn btn-primary mx-2" data-bs-toggle="modal" data-bs-target="#Editrole{{$key}}" ><i class="fa fa-edit"></i></a>
                                    <form action="{{route('admin.role.destroy',$role->id)}}" method="post">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" onclick="return confirm('are you sure to delete ? ')" class="btn btn-danger"><i class="fa text-white fa-trash"></i></button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="Editrole{{$key}}" tabindex="-1"  aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title  fw-bold" id="depaddLabel">Update role</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form class="form-horizontal" action="{{route('admin.role.update',$role->id)}}" method="post" enctype="multipart/form-data">
                                                @csrf
                                                @method('PUT')
                                                <div class="row mb-4">
                                                    <label for="name" class="col-md-3 form-label">Name <span class="text-danger">*</span></label>
                                                    <div class="col-md-9">
                                                        <input class="form-control" value="{{ $role->name }}" id="name" name="name" placeholder="Enter name" type="text">
                                                        <span class="text-danger">{{$errors->has('name') ? $errors->first('name'):''}}</span>
                                                    </div>
                                                </div>
                                                @php($rolePermissions = \App\Models\RolePermission::where('role_id',$role->id)->pluck('permission_id')->toArray())
                                                <div class="row mb-4">
                                                    <h5 class="text-center">All Permissions</h5>
                                                    <hr>
                                                    <h5><input class="selectAll" type="checkbox"> <label for="selectAll">Select All</label></h5>
                                                    @foreach($permissionsGroup as $name => $permissions)
                                                        <div class="row my-2">
                                                                <h5 class="p-1 text-center" style="border: 1px solid black">{{ $name }}</h5>
                                                                @foreach($permissions as $key => $permission)
                                                                    <div class="col-4">
                                                                <span>
                                                                    <input type="checkbox" name="permission_ids[]" value="{{$permission->id}}"
                                                                           {{ in_array($permission->id, $rolePermissions) ? 'checked' : '' }} id="permission{{$key}}" class="itemCheckbox">
                                                                    <label for="permission{{$key}}">{{$permission->name}}</label>
                                                                </span>
                                                                    </div>
                                                                @endforeach
                                                        </div>
                                                    @endforeach
                                                </div>

                                                <div class="row mb-4 d-flex form-group">
                                                    <div class="col-md-3 form-label">
                                                        <label class="" for="status">Status</label>
                                                    </div>
                                                    <div class="col-md-9">
                                                        <select class="form-control select2 form-select" id="status" name="status" data-placeholder="Choose one">
                                                            <option class="form-control" label="Choose one"></option>
                                                            <option {{$role->status == 1 ? 'selected':''}} value="1">Active</option>
                                                            <option {{$role->status == 0 ? 'selected':''}} value="0">Inactive</option>
                                                        </select>
                                                    </div>
                                                </div>

                                                <button class="btn btn-primary float-end" type="submit">Submit</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-white my-3 d-grid justify-content-center">
                        {{$roles->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->

    <!-- Add Role-->
    <div class="modal fade" id="addRole" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-xl modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title  fw-bold" id="depaddLabel">New Role Create</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form class="form-horizontal" action="{{route('admin.role.store')}}" method="post" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-4">
                            <label for="name" class="col-md-3 form-label">Name <span class="text-danger">*</span></label>
                            <div class="col-md-9">
                                <input class="form-control" required value="{{old('name')}}" id="name" name="name" placeholder="Enter name" type="text">
                                <span class="text-danger">{{$errors->has('name') ? $errors->first('name'):''}}</span>
                            </div>
                        </div>
                        <div class="row mb-4">
                            <h3 class="text-center">All Permissions</h3>
                            <hr>
                            <h5><input class="selectAll" type="checkbox" id="selectAll"> <label for="selectAll">Select All</label></h5>
                            @foreach($permissionsGroup as $name => $permissions)
                                <div class="row my-2">
                                    <h5 class="p-1 text-center" style="border: 1px solid black">{{ $name }}</h5>
                                    @foreach($permissions as $key => $permission)
                                        <div class="col-4">
                                            <span>
                                            <input type="checkbox" name="permission_ids[]" value="{{$permission->id}}" id="permission{{$key}}" class="itemCheckbox">
                                            <label for="permission{{$key}}">{{$permission->name}}</label>
                                        </span>
                                        </div>
                                    @endforeach
                                </div>
                            @endforeach
                        </div>

                        <div class="row mb-4 d-flex form-group">
                            <div class="col-md-3 form-label">
                                <label class="" for="status">Status</label>
                            </div>
                            <div class="col-md-9">
                                <select class="form-control select2 form-select" id="status" name="status" data-placeholder="Choose one">
                                    <option class="form-control" label="Choose one" disabled selected></option>
                                    <option selected value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button class="btn btn-primary float-end" type="submit">Submit</button>
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

