@extends('admin.layout.app')
@section('title','Update Password')
@section('body')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="">
                <h3 class="fw-bold mb-0 text-white text-center">Update Password</h3>
                <hr class="text-white">
            </div>
        </div>
    </div>
    <!-- Row end  -->

    <div class="row clearfix justify-content-center g-3">
        <div class="col-sm-8">
            <div class="card mb-3">
                <div class="card-body export-table bg-dark-subtle">
                    <form action="{{route('admin.password.update')}}" method="post">
                        @csrf
                        <div class="mb-3">
                            <label for="old_password" class="form-label">Current Password <span class="text-danger">*</span></label>
                            <input type="password" name="old_password" class="form-control" id="old_password" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">New Password <span class="text-danger">*</span></label>
                            <input type="password" name="password" class="form-control" id="password" required>
                        </div>
                        <div class="mb-3">
                            <label for="confirm_password" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                            <input type="password" name="confirm_password" class="form-control" id="confirm_password" required>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Save</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->

@endsection

