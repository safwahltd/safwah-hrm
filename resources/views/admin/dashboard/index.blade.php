@extends('admin.layout.app')
@section('title','Dashboard')
@section('body')
    @if(auth()->user()->role == 'admin')
        <div class="row clearfix g-3">
        <div class="col-xl-8 col-lg-8 col-md-6 flex-column">
            <div class="row g-3">
                <div class="col-md-12 col-xl-6 col-lg-6 col-6">
                    <div class="card">
                        <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                            <h6 class="mb-0 fw-bold ">Employees Availability</h6>
                        </div>
                        <div class="card-body">
                            <div class="row g-2 row-deck">
                                <div class="col-md-6 col-sm-6">
                                    <a href="{{route('admin.attendance.list')}}">
                                        <div class="card">
                                            <div class="card-body">
                                                <i class="icofont-checked fs-3"></i>
                                                <h6 class="mt-3 mb-0 fw-bold small-14">Today Attendance</h6>
                                                <span class="text-black">{{count($totalPresent)}}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <a href="{{route('admin.attendance.list')}}">
                                        <div class="card">
                                            <div class="card-body ">
                                                <i class="icofont-stopwatch fs-3"></i>
                                                <h6 class="mt-3 mb-0 fw-bold small-14">Today Late Coming</h6>
                                                <span class="text-black">{{$totalLateAttend}}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <a href="{{route('admin.attendance.list')}}">
                                        <div class="card">
                                            <div class="card-body ">
                                                <i class="icofont-ban fs-3"></i>
                                                <h6 class="mt-3 mb-0 fw-bold small-14">Today Absent</h6>
                                                <span class="text-black">{{$absentEmployees}}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-md-6 col-sm-6">
                                    <a href="{{route('admin.leave.requests')}}">
                                        <div class="card">
                                            <div class="card-body ">
                                                <i class="icofont-beach-bed fs-3"></i>
                                                <h6 class="mt-3 mb-0 fw-bold small-14">Leave Apply</h6>
                                                <span class="text-black">{{$leaveApply}}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-12 col-xl-6 col-lg-6 col-6">
                    <div class="card">
                        <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                            <h6 class="mb-0 fw-bold ">Total Employees</h6>
                            <h4 class="mb-0 fw-bold ">{{count($totalEmployees)}}</h4>
                        </div>
                        <div class="card-body">
                            <div class="mt-3" id="apex-MainCategories"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-4 col-lg-4 col-md-6">
            <div class="row g-3 row-deck">
                <div class="col-md-6 col-lg-6 col-xl-6 col-6">
                    <a href="{{route('departments.index')}}">
                        <div class="card bg-primary">
                            <div class="card-body row">
                                <div class="col">
                                    <h1 class="mt-3 mb-0 fw-bold text-white">{{$departments}}</h1>
                                    <span class="text-white">Departments</span>
                                </div>
                                <div class="col">
                                    <img class="img-fluid" src="{{asset('/')}}admin/assets/images/interview.svg" alt="interview">
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-6 col-6">
                    <a href="{{route('designations.index')}}">
                        <div class="card bg-primary">
                            <div class="card-body row">
                                <div class="col">
                                    <h1 class="mt-3 mb-0 fw-bold text-white">{{$designations}}</h1>
                                    <span class="text-white">Designation</span>
                                </div>
                                <div class="col">
                                    <img class="img-fluid" src="{{asset('/')}}admin/assets/images/interview.svg" alt="interview">
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-6 col-6">
                    <a href="{{route('admin.termination.index')}}">
                        <div class="card bg-primary">
                            <div class="card-body row">
                                <div class="col">
                                    <h1 class="mt-3 mb-0 fw-bold text-white">{{$terminations}}</h1>
                                    <span class="text-white">Termination</span>
                                </div>
                                <div class="col">
                                    <img class="img-fluid" src="{{asset('/')}}admin/assets/images/interview.svg" alt="interview">
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-6 col-lg-6 col-xl-6 col-6">
                    <a href="{{route('asset.index')}}">
                        <div class="card bg-primary">
                            <div class="card-body row">
                                <div class="col">
                                    <h1 class="mt-3 mb-0 fw-bold text-white">{{$assets}}</h1>
                                    <span class="text-white">Assets</span>
                                </div>
                                <div class="col">
                                    <img class="img-fluid" src="{{asset('/')}}admin/assets/images/interview.svg" alt="interview">
                                </div>
                            </div>
                        </div>
                    </a>
                </div>
                <div class="col-md-12 col-lg-12 col-xl-12">
                    <div class="card">
                        <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                            <h6 class="mb-0 fw-bold ">Upcomming Holidays</h6>
                        </div>
                        <div class="card-body">
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
                                    <a href="{{route('holidays.index')}}" class="btn btn-primary p-1 my-2">
                                        View All <i class="fe fe-arrow-right-circle"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div><!-- Row End -->
    @else
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
                                                <h4 class="text-primary">{{$totalAttend}}</h4>
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
    @endif
@endsection
@push('js')
    @if(auth()->user()->role == 'admin')
        <script>
        $(document).ready(function() {
           var male = {{$totalEmployeeMale}};
           var female = {{$totalEmployeeFeMale}};
           var other = {{$totalEmployeeOther}};

            var options = {
                align: 'center',
                chart: {
                    height: 250,
                    type: 'donut',
                    align: 'center',
                },
                labels: ['Man', 'Women','Other'],
                dataLabels: {
                    enabled: false,
                },
                legend: {
                    position: 'bottom',
                    horizontalAlign: 'center',
                    show: true,
                },
                colors: ['var(--chart-color5)', 'var(--chart-color3)','var(--chart-color2)'],
                series: [male, female,other],
                responsive: [{
                    breakpoint: 1000,
                    options: {
                        chart: {
                            width: 200
                        },
                        legend: {
                            position: 'bottom'
                        }
                    }
                }]
            }
            var chart = new ApexCharts( document.querySelector("#apex-MainCategories"),options);
            chart.render();
        });
    </script>
    @else
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
    @endif
@endpush
