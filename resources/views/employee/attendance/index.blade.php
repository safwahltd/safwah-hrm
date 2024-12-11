@extends('admin.layout.app')
@section('title','My Attendance')
@section('body')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">My Attendance</h3>
            </div>
        </div>
    </div>
    <!-- Row end  -->
    <div class="row clearfix g-3">
        <div class="col-sm-12">
            <div class="card mb-3">
                <div class="card-body table-responsive bg-dark-subtle">
                    <table id="basic-datatable" class="table table-bordered text-nowrap table-secondary key-buttons border-bottom w-100 text-center" style="font-size: 12px;">
                        <thead class="bg-primary">
                        <tr class="">
                            <th>No</th>
                            <th>Date</th>
                            <th>Working Day</th>
                            <th>Attend</th>
                            <th>Late</th>
                            <th>Absent</th>
                            <th>Attachment</th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($attendances as $key => $attendance)
                            <tr>
                                <td><span class="fw-bold">{{$loop->iteration}}</span></td>
                                <td align="center">{{ date('F', mktime(0, 0, 0, $attendance->month, 1)) }} , {{ $attendance->year }}</td>
                                <td class="text-center">{{ $attendance->working_day ?? '-' }}</td>
                                <td class="text-center">{{ $attendance->attend ?? '-' }}</td>
                                <td class="text-center">{{ $attendance->late ?? '-' }}</td>
                                <td align="center">{{ $attendance->absent ?? '-' }}</td>
                                <td align="center">
                                    @if(!empty($attendance->attachment))
                                        <a href="{{ route('admin.attendance.showFile', $attendance->id) }}" target="_blank" class="btn btn-success">View</a>
                                    @else
                                        -
                                    @endif
                                </td>
                            </tr>
                            <div class="modal fade" id="attendedit{{$key}}" tabindex="-1"  aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-md modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title  fw-bold" id="depeditLabel"> Attendance Edit</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="deadline-form">
                                                <form class="p-4" action="{{route('admin.attendance.update',$attendance->id)}}" method="post" enctype="multipart/form-data">
                                                    @csrf
                                                    @method('PUT')
                                                    <div class="row g-3 mb-3">
                                                        <div class="col-sm-12">
                                                            <label for="user_idFull" class="form-label"> Employee  <span class="text-danger">*</span></label><br>
                                                            <p class="form-control">{{ $attendance->user->name }} <sub> ({{ $attendance->user->userInfo->employee_id }})</sub> </p>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="yearFullEdit" class="form-label">Month <span class="text-danger">*</span></label><br>
                                                            <select class="form-control-sm" name="month" id="month">
                                                                @for ($i = 1; $i <= 12; $i++)
                                                                    <option {{ $attendance->month == $i ? 'selected':''}} value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="yearFullEdit" class="form-label">Year <span class="text-danger">*</span></label><br>
                                                            <select class="form-control-sm" name="year" id="yearFullEdit" required>
                                                                @for ($i = date('Y'); $i >= 2022; $i--)
                                                                    <option {{ $attendance->year == $i ? 'selected':''}} value="{{ $i }}">{{ $i }}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="form-label">Attend <span class="text-danger">*</span></label>
                                                            <input type="number" min="0" name="attend" class="form-control" value="{{$attendance->attend}}" placeholder="Attend Number" required>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="form-label">Late <span class="text-danger">*</span></label>
                                                            <input type="number" min="0" name="late" class="form-control" value="{{$attendance->late}}" placeholder="Late Number" required>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label class="form-label">Absent <span class="text-danger">*</span></label>
                                                            <input type="number" min="0" name="absent" class="form-control" value="{{$attendance->absent}}" placeholder="Absent Number" required>
                                                        </div>
                                                        <div class="col-sm-12">
                                                            <label class="form-label">Attachment <span class="text-danger">*</span></label>
                                                            <input type="file" min="0" name="attachment" class="form-control" value="{{old('attachment')}}">
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
                        @empty
                            <tr>
                                <td colspan="6" class="text-center"><span class="fw-bold">No Result</span></td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                    <div class="text-white my-3 d-grid justify-content-center">
                        {{$attendances->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->
@endsection
