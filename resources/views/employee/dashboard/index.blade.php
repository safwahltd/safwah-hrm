@extends('admin.layout.app')
@section('title','Dashboard')
@section('body')
    <div class="row">
        <div class="col-xxl-12 col-lg-12 col-md-12">
            <div class="row">
                <div class="col-lg-6 col-md-12 my-1">
                    <div class="card bg-primary-gradient my-1">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="">
                                    <h4>Welcome Back, <span class="fw-bold">{{auth()->user()->name ?? 'N/A'}}</span></h4>
                                </div>
                                <div class="">
                                    @if(file_exists(auth()->user()->userInfo->image))
                                        <img src="{{asset(auth()->user()->userInfo->image)}}" alt="profile"  width="100" height="100" style="border-radius: 100%" class="img-responsive">
                                    @else
                                        <img class="img-responsive" src="{{asset('/')}}admin/assets/images/lg/avatar3.jpg"  width="100" style="border-radius: 100%" height="100"  alt="profile">
                                    @endif

                                </div>
                            </div>
                            <div class="">
                                <a href="{{route('employee.profile.details')}}" class="btn btn-primary">View Profile</a>
                            </div>
                        </div>
                    </div>
                    <div class="card bg-dark-subtle my-1">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-7">

                                    <div class="">
                                        <p class="mb-0">Working Time</p>
                                        <small class="fw-bold" id="workingTime">{{ $attendance->working_time ?? ''}}{{--{{ \Illuminate\Support\Carbon::parse($attendance->clock_in)->format('jS F Y, h:i a')}}--}}</small>
                                    </div>
                                    <div class="">
                                        <p class="mb-0">Clock In</p>
                                        <small class="fw-bold" id="clock_in_time">{{ $attendance->clock_in ?? ''}}{{--{{ \Illuminate\Support\Carbon::parse($attendance->clock_in)->format('jS F Y, h:i a')}}--}}</small>
                                    </div>
                                    <div class="">
                                        <p class="mb-0">Clock Out</p>
                                        <small class="fw-bold" id="clock_out_time">{{ $attendance->clock_out ?? ''}} {{--{{ \Illuminate\Support\Carbon::parse($attendance->clock_out)->format('jS F Y, h:i a')}}--}}</small>
                                    </div>
                                </div>
                                <div class="col-5 align-content-center">
                                    <button class="btn btn-primary" hidden id="clockInBtn"><i class="fa-solid fa-play"></i> Clock In</button>
                                    <button class="btn text-white btn-danger" hidden id="clockOutBtn"><i class="fa-solid fa-person-walking-arrow-right "></i> Clock Out</button>
                                    <div class="" id="clockInCLockOut">
                                        <button class="btn btn-primary" hidden id="clockInBtn"><i class="fa-solid fa-play"></i> Clock In</button>
                                        <button class="btn text-white btn-danger" hidden id="clockOutBtn"><i class="fa-sharp fa-solid fa-person-walking-arrow-right"></i> Clock Out</button>
                                    </div>
                                </div>
                            </div>
                            {{--<div class="clock-in-list">
                                <ul class="nav">
                                    <li>
                                        <p>Remaining</p>
                                        <h6>2 Hrs 36 Min</h6>
                                    </li>
                                    <li>
                                        <p>Overtime</p>
                                        <h6>0 Hrs 00 Min</h6>
                                    </li>
                                    <li>
                                        <p>Break</p>
                                        <h6>1 Hrs 20 Min</h6>
                                    </li>
                                </ul>
                            </div>--}}
                            <div class="view-attendance">
                                <a href="{{route('employee.attendance.list')}}" class="btn btn-primary p-1 my-2">
                                    View Attendance <i class="fe fe-arrow-right-circle"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card info-card my-1">
                        <div class="card-body">
                            <h4 class="fw-bold">Upcoming Holidays</h4>
                            <div class="holiday-details">
                                <div class="holiday-calendar">
                                    <div class="holiday-calendar-content">
                                        <div class="row">
                                            <table id="myProjectTable" class="table table-hover table-striped align-middle mb-0" style="width:100%">
                                                <thead class="bg-primary">
                                                <tr class="bg-secondary">
                                                    <th  class="bg-primary-subtle">Name</th>
                                                    <th  class="bg-primary-subtle">Date</th>
                                                    <th  class="bg-primary-subtle">Total</th>
                                                    <th  class="bg-primary-subtle">Status</th>
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @forelse($holidays as $key => $holiday)
                                                    <tr class="fw-bold">
                                                        <td><small>{{$holiday->name}}</small></td>
                                                        <td>
                                                            <small>{{ \Illuminate\Support\Carbon::parse($holiday->date_from)->format('d M') }} -</small>
                                                            <small>{{ \Illuminate\Support\Carbon::parse($holiday->date_to)->format('d M, Y') }}</small>
                                                        </td>
                                                        <td><small>{{ $holiday->total_day }} {{$holiday->total_day <= 1 ? 'day':'days'}}</small></td>
                                                        <td><span class="p-1 px-3 rounded-2 text-white {{ $holiday->date_to > \Illuminate\Support\Carbon::now() ? 'bg-success' : 'bg-danger' }}">{{ $holiday->date_to > \Illuminate\Support\Carbon::now() ? 'In Coming' : 'Passed' }}</span></td>
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
                                <div class="holiday-btn">
                                    <a href="{{route('employee.holiday.index')}}" class="btn btn-primary p-1 my-2">
                                        View All <i class="fe fe-arrow-right-circle"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12 my-1">
                    <div class="card flex-fill my-1">
                        <div class="card-body">
                            <div class="statistic-header d-flex">
                                <h5 class="fw-bold">Attendance & Leaves {{ \Illuminate\Support\Carbon::now()->year }}</h5>
                            </div>
                            <div class="attendance-list">
                                <div class="row p-3">
                                    <div class="col-md-4">
                                        <div class="attendance-details">
                                            <h4 class="text-primary">{{ $totalWorkingDay }}</h4>
                                            <p>Working Days</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="attendance-details">
                                            <h4 class="text-primary">{{ 20 }}</h4>
                                            <p>Total Leave</p>
                                        </div>
                                    </div>

                                    <div class="col-md-4">
                                        <div class="attendance-details">
                                            <h4 class="text-pink">{{ ( 10 - auth()->user()->userInfo->sick_leave ) + ( 10 - auth()->user()->userInfo->casual_leave ) }}</h4>
                                            <p>Leaves Taken</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="attendance-details">
                                            <h4 class="text-success">{{ 20 - ( 10 - auth()->user()->userInfo->sick_leave ) + ( 10 - auth()->user()->userInfo->casual_leave ) }}</h4>
                                            <p>Leaves Left</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="attendance-details">
                                            <h4 class="text-purple">{{$leavesPending}}</h4>
                                            <p>Pending Approval</p>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="view-attendance">
                                <a href="{{route('employee.leave')}}" class="btn btn-primary">
                                    Apply Leave <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card flex-fill my-1">
                        <div class="card-body">
                            <div class="statistic-header">
                                <h4>Working hours</h4>
                            </div>
                            <div class="working-hour-info">
                                <div id="working_chart" class="table-responsive">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Date</th>
                                                <th>Working Hours</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($attendances as $attendance)
                                            <tr>
                                                <td>{{ \Illuminate\Support\Carbon::parse($attendance->created_at)->format('d M,Y')}}</td>
                                                <td>{{$attendance->working_time }} hour</td>
                                            </tr>
                                        @endforeach
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('js')
    <script>
        $(document).ready(function () {
            function updateButtonStatus() {
                $.ajax({
                    url: '{{route('employee.clock.status')}}',
                    type: 'GET',
                    success: function (response) {
                        if (response.isClockedIn) {
                            $('#clockInBtn').attr('hidden', true);
                            $('#clockOutBtn').removeAttr('hidden');
                        } else {
                            $('#clockInBtn').removeAttr('hidden');
                            $('#clockOutBtn').attr('hidden', true);
                        }
                    },
                    error: function () {
                        toastr.error('Error fetching clock status.');
                    }
                });
            }
            // Initial check on page load
            updateButtonStatus();

            $('#clockInBtn').on('click', function () {
                $.ajax({
                        url: '{{route('employee.clock.in')}}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            toastr.success(response.message);
                            $('#clockInBtn').attr('hidden', true);
                            $('#clockOutBtn').removeAttr('hidden');
                            $('#clock_in_time').text(response.clockIn);
                        },
                        error: function (xhr) {
                            // alert(xhr.responseJSON.message);
                            toastr.error(xhr.responseJSON.message);
                        }
                    });

            });

            $('#clockOutBtn').on('click', function () {
                if (confirm('Are you sure you want to clock Out ?')) {
                    $.ajax({
                        url: '{{route('employee.clock.out')}}',
                        type: 'POST',
                        data: {
                            _token: '{{ csrf_token() }}'
                        },
                        success: function (response) {
                            toastr.success(response.message);
                            $('#clockOutBtn').attr('hidden', true);
                            $('#clockInBtn').removeAttr('hidden');
                            $('#clock_out_time').text(response.clockOut);
                            $('#workingTime').text(response.working_time);
                        },
                        error: function (xhr) {
                            // alert(xhr.responseJSON.message);
                            toastr.error(xhr.responseJSON.message);
                        }
                    });
                }
            });
        });
    </script>
@endpush
