@extends('admin.layout.app')
@section('title','Employee Attendances')
@section('body')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Attendance</h3>
            </div>
        </div>
    </div>
    <!-- Row end  -->
    <div class="row clearfix g-3">
        <div class="col-sm-12">
            <div class="card mb-3">
                <div class="card-body table-responsive bg-dark-subtle">
                    <table id="basic-datatable" class="table table-bordered text-nowrap table-secondary key-buttons border-bottom w-100">
                        <thead class="bg-primary">
                        <tr class="">
                            <th>No</th>
                            <th>Name <sub>(ID)</sub> </th>
                            <th align="center">
                                <p class="my-0"align="center">Clock In</p>
                                <p class="text-muted my-0"align="center"><small>(D-M-Y H:M:S)</small></p>

                            </th>
                            <th align="center">
                                <p class="my-0"align="center">Clock Out</p>
                                <p class="text-muted my-0"align="center"><small>(D-M-Y H:M:S)</small></p>
                            </th>
                            <th align="center">
                                <p class="my-0"align="center">Working Hour</p>
                                <p class="text-muted my-0"align="center"><small>(H:M:S)</small></p>

                            </th>
                        </tr>
                        </thead>
                        <tbody>
                        @forelse($attendances as $key => $attendance)
                            <tr>
                                <td><span class="fw-bold">{{$loop->iteration}}</span></td>
                                <td>{{ $attendance->user->name }}<sub>({{ $attendance->user->userInfo->employee_id }})</sub> </td>
                                <td align="center">{{ \Illuminate\Support\Carbon::parse($attendance->clock_in)->format('d M , 2024 h:m a') }}</td>
                                <td class="text-center">
                                    @if($attendance->clock_out)
                                        {{ \Illuminate\Support\Carbon::parse($attendance->clock_out)->format('d M , 2024 h:m a') }}
                                    @else
                                        -
                                    @endif
                                </td>
                                <td align="center">{{ $attendance->working_time ?? '00:00:00' }} hour</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center"><span class="fw-bold">No Result</span></td>
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
