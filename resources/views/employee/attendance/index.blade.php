@extends('admin.layout.app')
@section('title','My Attendance')
@section('body')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Attendance</h3>
            </div>
        </div>
    </div>
    <!-- Row end  -->

    <div class="row g-3">
        <div class="col-sm-12">
            <div class="card mb-3">
                <div class="card-body">
                    <div class="table-responsive export-table">
                        <table id="file-datatable" class="table table-bordered w-100" style="width:100%">
                            <thead>
                            <tr>
                                <th class="border-bottom-0">No</th>
                                <th class="border-bottom-0">Clock In <sub>(D-M-Y H:M:S)</sub></th>
                                <th class="border-bottom-0">Clock Out <sub>(D-M-Y H:M:S)</sub></th>
                                <th class="border-bottom-0">Working Hour <sub>(H:M:S)</sub></th>
                            </tr>
                            </thead>
                            </thead>
                            <tbody>
                            @forelse($attendances as $key => $attendance)
                                <tr>
                                    <td><span class="fw-bold">{{$loop->iteration}}</span></td>
                                    <td>{{$attendance->clock_in}}</td>
                                    <td>{{$attendance->clock_out}}</td>
                                    <td>{{$attendance->working_time }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="4" class="text-center"><span class="fw-bold">No Result</span></td>
                                </tr>
                            @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->
@endsection
