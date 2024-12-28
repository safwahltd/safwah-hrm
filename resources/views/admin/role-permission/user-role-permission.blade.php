@extends('admin.layout.app')
@section('title','User Role')
@section('body')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">User Role</h3>
            </div>
        </div>
    </div>
    <!-- Row end  -->

    <div class="row clearfix g-3">
        <div class="col-sm-12">
            <div class="card mb-3">
                <div class="card-body table-responsive bg-dark-subtle">
                    <table id="basic-datatable" class="table table-bordered text-nowrap table-secondary key-buttons border-bottom w-100">
                        <thead>
                        <tr>
                            <th>No</th>
                            <th>User Name</th>
                            <th>Email</th>
                            <th>Roles</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $key => $user)
                            <tr>
                                <td>
                                    <span class="fw-bold">{{$loop->iteration}}</span>
                                </td>
                                <td>{{$user->name}}</td>
                                <td>{{$user->email}}</td>
                                <td>
                                    @foreach($user->userRoles as $role)
                                        <span class="bg-success mx-1 p-1 rounded-2 text-white"> {{$role->role->name}} </span>
                                    @endforeach
                                </td>
                                <td>
                                    <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#editRole{{$key}}"><i class="icofont-edit text-success"></i></button>
                                </td>
                            </tr>
                            <div class="modal fade" id="editRole{{$key}}" tabindex="-1"  aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title  fw-bold" id="">Edit Employee Role</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('admin.user.role.update',$user->id)}}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <div class="deadline-form">
                                                        <div class="row my-2">

                                                            @php($userRoles = \App\Models\UserRole::where('user_id',$user->id)->pluck('role_id')->toArray())
                                                            <h5 class="">
                                                                <span>
                                                                    <input class="selectAll" id="selectAll" type="checkbox">
                                                                    <label for="selectAll">Select All</label>
                                                                </span>
                                                            </h5><hr>
                                                            @foreach($roles as $key => $role)
                                                                <div class="col-12 col-md-4">
                                                                    <span>
                                                                    <input type="checkbox" name="role_id[]" value="{{$role->id}}" {{ in_array($role->id, $userRoles) ? 'checked' : '' }} id="role{{$randAdd = rand() }}" class="itemCheckbox text-danger">
                                                                    <label class="p-1 rounded-3 {{ in_array($role->id, $userRoles) ? 'bg-success text-white' : '' }}"  for="role{{$randAdd}}">{{$role->name}}</label>
                                                                </span>
                                                                </div>
                                                            @endforeach
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
                        </tbody>
                    </table>
                    <div class="text-white my-3 d-grid justify-content-center">
                        {{$users->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->

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
