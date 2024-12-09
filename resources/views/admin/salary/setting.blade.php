@extends('admin.layout.app')
@section('title','Salary Settings')
@section('body')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Salary Setting Info</h3>
                <div class="col-auto d-flex w-sm-100">
                    <button type="button" class="btn btn-dark btn-set-task w-sm-100" data-bs-toggle="modal" data-bs-target="#depadd"><i class="icofont-plus-circle me-2 fs-6"></i> Add</button>
                </div>
            </div>
        </div>
    </div>
    <div class="row clearfix g-3">
        <div class="col-sm-12">
            <div class="card mb-3">
                <div class="card-body table-responsive export-table bg-dark-subtle">
                    <table id="basic-datatable" class="table table-bordered text-nowrap table-secondary key-buttons border-bottom w-100">
                        <thead>
                            <tr>
                                <th>No</th>
                                <th>Name</th>
                                <th>Type</th>
                                <th>Placeholder</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($settings as $key => $setting)
                            <tr>
                                <td>
                                    <span class="fw-bold">{{$loop->iteration}}</span>
                                </td>
                                <td>{{ ucwords(str_replace('_',' ',$setting->name))}}</td>
                                <td>{{$setting->type}}</td>
                                <td>{{$setting->placeholder}}</td>
                                <td>
                                    <span class="form-control-sm text-white {{$setting->status == 1 ? 'bg-success':'bg-danger'}} p-1 rounded-2">{{$setting->status == 1 ? 'Active':'Inactive'}}</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#degedit{{$key}}"><i class="icofont-edit text-success"></i></button>
                                        <form action="{{ route('admin.salary.setting.destroy',$setting->id) }}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" onclick="return confirm('are you sure to delete ? ')" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <!-- Edit Department-->
                            <div class="modal fade" id="degedit{{$key}}" tabindex="-1"  aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title  fw-bold" id="depeditLabel"> Department Edit</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="deadline-form">
                                                <form action="{{route('admin.salary.setting.update',$setting->id)}}" method="post">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="modal-body">
                                                        <div class="mb-3">
                                                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                                                            <input type="text" name="name" value="{{ $setting->name }}" class="form-control" id="nameEdit" required>
                                                        </div>
                                                        <div class="mb-3">
                                                            <label for="name" class="form-label">Placeholder <span class="text-danger">*</span></label>
                                                            <input type="text" name="placeholder" value="{{ $setting->placeholder }}" class="form-control" id="placeholderEdit" required>
                                                        </div>
                                                        <div class="deadline-form">
                                                            <div class="row g-3 mb-3">
                                                                <div class="col-sm-6">
                                                                    <label for="name" class="form-label">Type <span class="text-danger">*</span></label>
                                                                    <select class="form-control" name="type" id="typeEdit" required>
                                                                        <option {{$setting->type == "payment" ? 'selected':''}} value="payment">Payment</option>
                                                                        <option {{$setting->type == "deduct" ? 'selected':''}} value="deduct">Deduct</option>
                                                                    </select>
                                                                </div>
                                                                <div class="col-sm-6">
                                                                    <label for="status" class="form-label">Status</label>
                                                                    <select class="form-control" name="status" id="statusEdit">
                                                                        <option {{$setting->status == 1 ? 'selected':''}} value="1">Active</option>
                                                                        <option {{$setting->status == 0 ? 'selected':''}} value="0">Inactive</option>
                                                                    </select>
                                                                </div>
                                                            </div>
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
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="modal fade" id="depadd" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title  fw-bold" id="depaddLabel"> Input Field Add</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.salary.setting.store') }}" method="post">
                    @csrf
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="name" class="form-label">Name <span class="text-danger">*</span></label>
                            <input type="text" name="name" class="form-control" id="nameAdd" required>
                        </div>
                        <div class="mb-3">
                            <label for="name" class="form-label">Placeholder <span class="text-danger">*</span></label>
                            <input type="text" name="placeholder" class="form-control" id="placeholder" required>
                        </div>
                        <div class="deadline-form">
                            <div class="row g-3 mb-3">
                                <div class="col-sm-6">
                                    <label for="name" class="form-label">Type <span class="text-danger">*</span></label>
                                    <select class="form-control" name="type" id="status" required>
                                        <option selected value="payment">Payment</option>
                                        <option value="deduct">Deduct</option>
                                    </select>
                                </div>
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
                        <button type="submit" class="btn btn-primary">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('#nameAdd').on('keyup', function() {
                let title = $(this).val();
                let slug = title.toLowerCase()
                    .replace(/[^a-z _]/g, '').replace(/ /g, '_');
                $('#nameAdd').val(slug);
            });
            $('.nameEdit').on('keyup', function() {
                let title = $(this).val();
                let slug = title.toLowerCase()
                    .replace(/[^a-z _]/g, '').replace(/ /g, '_');
                $('#nameEdit').val(slug);
            });

        });
    </script>
@endpush
