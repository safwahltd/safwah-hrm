@extends('admin.layout.app')
@section('title','notice')
@section('body')
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.5; }
        h1 { text-align: center; }
        .content { margin: 0 auto; width: 80%; }
        .signature { margin-top: 50px; }
        label {
            display: inline-block;
            padding-bottom: 10px;
        }
    </style>
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Notice</h3>
                <div class="col-auto d-flex w-sm-100">
                    <button type="button" class="btn btn-dark btn-set-task w-sm-100" data-bs-toggle="modal" data-bs-target="#depadd"><i class="icofont-plus-circle me-2 fs-6"></i>Add notice</button>
                </div>
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
                        <tr align="">
                            <th>No</th>
                            <th>Title</th>
                            <th align="center">Posted on</th>
                            <th align="center">Ends on</th>
                            <th align="center">Status</th>
                            <th>Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($notices as $key => $notice)
                            <tr>
                                <td>
                                    <span class="fw-bold">{{$loop->iteration}}</span>
                                </td>
                                <td>
                                    <span class="fw-bold ms-1">{{ $notice->title }}</span>
                                </td>
                                <td align="center"> {{ $notice->start_date ?? '-' }}</td>
                                <td align="center">{{ $notice->end_date ?? '-' }}</td>

                                <td align="center">
                                    <span class="p-1 {{$notice->status == 1 ? 'bg-success rounded-2 text-white':'bg-danger rounded-2 text-white'}}">{{$notice->status == 1 ? 'Active':'Inactive'}}</span>
                                </td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#noticeEdit{{$key}}"><i class="icofont-edit text-primary"></i></button>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#noticeShow{{$key}}"><i class="icofont-eye text-success"></i></button>
                                        <form action="{{route('admin.notice.destroy',$notice->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('are you sure to delete ? ')" class="btn btn-outline-secondary deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                        </form>
                                        <form action="{{route('admin.notice.download',$notice->id)}}" method="post">
                                            @csrf
                                            <button type="submit" onclick="return confirm('are you sure to download ? ')" class="btn btn-outline-secondary deleterow"><i class="icofont-download-alt text-primary"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            <div class="modal fade" id="noticeEdit{{$key}}" tabindex="-1"  aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title  fw-bold" id="depeditLabel"> Notice Edit</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="deadline-form">
                                                    <div class="modal-body">
                                                        <form action="{{ route('admin.notice.update', $notice->id) }}" method="POST">
                                                            @csrf
                                                            @method('PUT')
                                                            <div class="form-group">
                                                                <label for="title">Notice Title</label>
                                                                <input type="text" name="title" class="form-control" value="{{ $notice->title }}" required>
                                                            </div>

                                                            <div class="form-group my-2">
                                                                <label for="content">Notice Content</label>
                                                                <textarea name="details" class="form-control" required id="details" cols="30" rows="6">{{ $notice->content }}</textarea>
                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="start_date">Start Date</label>
                                                                        <input type="date" name="start_date" class="form-control" value="{{ $notice->start_date }}" required>
                                                                    </div>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <div class="form-group">
                                                                        <label for="end_date">End Date (optional)</label>
                                                                        <input type="date" name="end_date" class="form-control" value="{{ $notice->end_date ? $notice->end_date : '' }}">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="form-group my-2">
                                                                <label for="end_date">Status</label>
                                                                <select class="form-control" name="status" id="statusEdit">
                                                                    <option {{$notice->status == 1 ? 'selected':''}} value="1">Active</option>
                                                                    <option {{$notice->status == 0 ? 'selected':''}} value="0">Inactive</option>
                                                                </select>
                                                            </div>
                                                            <div class="modal-footer text-end">
                                                                <button type="submit" class="btn btn-primary">Update Notice</button>
                                                            </div>

                                                        </form>
                                                    </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="modal fade" id="noticeShow{{$key}}" tabindex="-1"  aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title  fw-bold" id="depeditLabel">{{ $notice->title }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="deadline-form">
                                                    <div class="modal-body">
                                                        <div class="">
                                                            <p align="justify">{{ $notice->content }}</p><br>
                                                            <address>
                                                                Regards & Thanks <br>
                                                                {{ $notice->user->userInfo->designations->name ?? 'Managing Director' }}<br>
                                                                Shahjadpur,Gulsan-2,Confidence Center,Dhaka-1212,Bangladesh<br>
                                                                info@safwahltd.com<br>
                                                            </address>
                                                        </div>
                                                        <div class="">
                                                            <address>
                                                                Start Date : {{ $notice->start_date }} <br>
                                                                End Date : {{ $notice->end_date ? $notice->end_date : '' }}<br>
                                                                Status : <span class="p-1 {{$notice->status == 1 ? 'bg-success rounded-2 text-white':'bg-danger rounded-2 text-white'}}">{{$notice->status == 1 ? 'Active':'Inactive'}}</span><br>
                                                            </address>
                                                        </div>
                                                    </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-white my-3 d-grid justify-content-center">
                        {{$notices->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->
    <!-- Add Department-->
    <div class="modal fade" id="depadd" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title  fw-bold" id="depaddLabel">Notice Create</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="{{ route('admin.notice.store') }}" method="POST">
                        @csrf
                        <div class="form-group my-2">
                            <label for="title">Notice Title <span class="text-danger">*</span></label>
                            <input type="text" name="title" class="form-control" required>
                        </div>

                        <div class="form-group my-2">
                            <label for="content">Notice Content <span class="text-danger">*</span></label>
                            <textarea name="details" class="form-control" required id="details" cols="30" rows="6"></textarea>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group my-2">
                                    <label for="start_date">Start Date <span class="text-danger">*</span></label>
                                    <input type="date" name="start_date" class="form-control" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <label for="end_date">End Date (optional)</label>
                                <input type="date" name="end_date" class="form-control">
                            </div>
                        </div>
                        <div class="form-group my-2">
                            <label for="end_date">Status</label>
                            <select name="status" id="" class="form-control">
                                <option value="1">Active</option>
                                <option value="0">Inactive</option>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-primary my-2">Create Notice</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


@endsection

