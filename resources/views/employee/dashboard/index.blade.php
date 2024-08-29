@extends('employee.layout.app')
@section('title','Your Dashboard')
@section('body')
{{--    <div class="row">
        <div class="col-md-12">
            <div class="employee-alert-box">
                <div class="alert alert-outline-success alert-dismissible fade show">
                    <div class="employee-alert-request">
                        <i class="far fa-circle-question"></i>
                        Your Leave Request on <span>“24th April 2024”</span> has been Approved!!!
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"><i class="fas fa-xmark"></i></button>
                </div>
            </div>
        </div>
    </div>--}}
    <div class="row">
        <div class="col-xxl-8 col-lg-12 col-md-12">
            <div class="row">

                <div class="col-lg-6 col-md-12">
                    <div class="card bg-primary-gradient flex-fill">
                        <div class="card-body">
                            <div class="d-flex">
                                <div class="">
                                    <h4>Welcome Back, {{auth()->user()->name ?? 'N/A'}}</h4>
{{--                                    <p>You have <span>4 meetings</span> today,</p>--}}
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
                    <div class="card bg-primary-subtle flex-fill">
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
                                    <button class="btn text-white btn-danger" hidden id="clockOutBtn"><i class="fa-sharp fa-solid fa-person-walking-arrow-right"></i> Clock Out</button>
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
                    <div class="card info-card flex-fill">
                        <div class="card-body">
                            <h4>Upcoming Holidays</h4>
                            <div class="holiday-details">
                                <div class="holiday-calendar">
                                    <div class="holiday-calendar-icon">
                                        <img src="assets/img/icons/holiday-calendar.svg" alt="Icon">
                                    </div>
                                    <div class="holiday-calendar-content">
                                        <h6>Ramzan</h6>
                                        <p>Mon 20 May 2024</p>
                                    </div>
                                </div>
                                <div class="holiday-btn">
                                    <a href="holidays.html" class="btn">View All</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-6 col-md-12">
                    <div class="card flex-fill">
                        <div class="card-body">
                            <div class="statistic-header d-flex">
                                <h5 class="fw-bold">Attendance & Leaves</h5>
                                <div class=" px-4">
                                    <select name="" id="" class="p-1">
                                        <option value="">2024</option>
                                    </select>
                                </div>
                            </div>
                            <div class="attendance-list">
                                <div class="row p-3">
                                    <div class="col-md-4">
                                        <div class="attendance-details">
                                            <h4 class="text-primary">20</h4>
                                            <p>Total Leaves</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="attendance-details">
                                            <h4 class="text-pink">5.5</h4>
                                            <p>Leaves Taken</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="attendance-details">
                                            <h4 class="text-success">04</h4>
                                            <p>Leaves Absent</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="attendance-details">
                                            <h4 class="text-purple">0</h4>
                                            <p>Pending Approval</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="attendance-details">
                                            <h4 class="text-info">214</h4>
                                            <p>Working Days</p>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="attendance-details">
                                            <h4 class="text-danger">2</h4>
                                            <p>Loss of Pay</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="view-attendance">
                                <a href="leaves-employee.html" class="btn btn-primary">
                                    Apply Leave <i class="fa fa-arrow-right"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                    <div class="card flex-fill">
                        <div class="card-body">
                            <div class="statistic-header">
                                <h4>Working hours</h4>
                                <div class="dropdown statistic-dropdown">
                                    <a class="dropdown-toggle" data-bs-toggle="dropdown" href="javascript:void(0);">
                                        This Week
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <a href="javascript:void(0);" class="dropdown-item">
                                            Last Week
                                        </a>
                                        <a href="javascript:void(0);" class="dropdown-item">
                                            This Month
                                        </a>
                                        <a href="javascript:void(0);" class="dropdown-item">
                                            Last 30 Days
                                        </a>
                                    </div>
                                </div>
                            </div>
                            <div class="working-hour-info">
                                <div id="working_chart"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xxl-4 col-lg-12 col-md-12 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="statistic-header">
                        <h4>Important</h4>
                        <div class="important-notification">
                            <a href="activities.html">
                                View All <i class="fe fe-arrow-right-circle"></i>
                            </a>
                        </div>
                    </div>
                    <div class="notification-tab">
                        <ul class="nav nav-tabs">
                            <li>
                                <a href="#" class="active" data-bs-toggle="tab" data-bs-target="#notification_tab">
                                    <i class="la la-bell"></i> Notifications
                                </a>
                            </li>
                            <li>
                                <a href="#" data-bs-toggle="tab" data-bs-target="#schedule_tab">
                                    <i class="la la-list-alt"></i> Schedules
                                </a>
                            </li>
                        </ul>
                        <div class="tab-content">
                            <div class="tab-pane active" id="notification_tab">
                                <div class="employee-noti-content">
                                    <ul class="employee-notification-list">
                                        <li class="employee-notification-grid">
                                            <div class="employee-notification-icon">
                                                <a href="activities.html">
                                                    <span class="badge-soft-danger rounded-circle">HR</span>
                                                </a>
                                            </div>
                                            <div class="employee-notification-content">
                                                <h6>
                                                    <a href="activities.html">
                                                        Your leave request has been
                                                    </a>
                                                </h6>
                                                <ul class="nav">
                                                    <li>02:10 PM</li>
                                                    <li>21 Apr 2024</li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="employee-notification-grid">
                                            <div class="employee-notification-icon">
                                                <a href="activities.html">
                                                    <span class="badge-soft-info rounded-circle">ER</span>
                                                </a>
                                            </div>
                                            <div class="employee-notification-content">
                                                <h6>
                                                    <a href="activities.html">
                                                        You’re enrolled in upcom....
                                                    </a>
                                                </h6>
                                                <ul class="nav">
                                                    <li>12:40 PM</li>
                                                    <li>21 Apr 2024</li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="employee-notification-grid">
                                            <div class="employee-notification-icon">
                                                <a href="activities.html">
                                                    <span class="badge-soft-warning rounded-circle">SM</span>
                                                </a>
                                            </div>
                                            <div class="employee-notification-content">
                                                <h6>
                                                    <a href="activities.html">
                                                        Your annual compliance trai
                                                    </a>
                                                </h6>
                                                <ul class="nav">
                                                    <li>11:00 AM</li>
                                                    <li>21 Apr 2024</li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="employee-notification-grid">
                                            <div class="employee-notification-icon">
                                                <a href="activities.html">
<span class="rounded-circle">
<img src="assets/img/avatar/avatar-1.jpg" class="img-fluid rounded-circle" alt="User">
</span>
                                                </a>
                                            </div>
                                            <div class="employee-notification-content">
                                                <h6>
                                                    <a href="activities.html">
                                                        Jessica has requested feedba
                                                    </a>
                                                </h6>
                                                <ul class="nav">
                                                    <li>10:30 AM</li>
                                                    <li>21 Apr 2024</li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="employee-notification-grid">
                                            <div class="employee-notification-icon">
                                                <a href="activities.html">
                                                    <span class="badge-soft-warning rounded-circle">DT</span>
                                                </a>
                                            </div>
                                            <div class="employee-notification-content">
                                                <h6>
                                                    <a href="activities.html">
                                                        Gentle remainder about train
                                                    </a>
                                                </h6>
                                                <ul class="nav">
                                                    <li>09:00 AM</li>
                                                    <li>21 Apr 2024</li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="employee-notification-grid">
                                            <div class="employee-notification-icon">
                                                <a href="activities.html">
                                                    <span class="badge-soft-danger rounded-circle">AU</span>
                                                </a>
                                            </div>
                                            <div class="employee-notification-content">
                                                <h6>
                                                    <a href="activities.html">
                                                        Our HR system will be down
                                                    </a>
                                                </h6>
                                                <ul class="nav">
                                                    <li>11:50 AM</li>
                                                    <li>21 Apr 2024</li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                            <div class="tab-pane fade" id="schedule_tab">
                                <div class="employee-noti-content">
                                    <ul class="employee-notification-list">
                                        <li class="employee-notification-grid">
                                            <div class="employee-notification-icon">
                                                <a href="activities.html">
<span class="rounded-circle">
<img src="assets/img/avatar/avatar-2.jpg" class="img-fluid rounded-circle" alt="User">
</span>
                                                </a>
                                            </div>
                                            <div class="employee-notification-content">
                                                <h6>
                                                    <a href="activities.html">
                                                        John has requested feedba
                                                    </a>
                                                </h6>
                                                <ul class="nav">
                                                    <li>10:30 AM</li>
                                                    <li>21 Apr 2024</li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="employee-notification-grid">
                                            <div class="employee-notification-icon">
                                                <a href="activities.html">
                                                    <span class="badge-soft-danger rounded-circle">HR</span>
                                                </a>
                                            </div>
                                            <div class="employee-notification-content">
                                                <h6>
                                                    <a href="activities.html">
                                                        Your leave request has been
                                                    </a>
                                                </h6>
                                                <ul class="nav">
                                                    <li>02:10 PM</li>
                                                    <li>21 Apr 2024</li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="employee-notification-grid">
                                            <div class="employee-notification-icon">
                                                <a href="activities.html">
                                                    <span class="badge-soft-info rounded-circle">ER</span>
                                                </a>
                                            </div>
                                            <div class="employee-notification-content">
                                                <h6>
                                                    <a href="activities.html">
                                                        You’re enrolled in upcom....
                                                    </a>
                                                </h6>
                                                <ul class="nav">
                                                    <li>12:40 PM</li>
                                                    <li>21 Apr 2024</li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="employee-notification-grid">
                                            <div class="employee-notification-icon">
                                                <a href="activities.html">
                                                    <span class="badge-soft-warning rounded-circle">SM</span>
                                                </a>
                                            </div>
                                            <div class="employee-notification-content">
                                                <h6>
                                                    <a href="activities.html">
                                                        Your annual compliance trai
                                                    </a>
                                                </h6>
                                                <ul class="nav">
                                                    <li>11:00 AM</li>
                                                    <li>21 Apr 2024</li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="employee-notification-grid">
                                            <div class="employee-notification-icon">
                                                <a href="activities.html">
                                                    <span class="badge-soft-warning rounded-circle">DT</span>
                                                </a>
                                            </div>
                                            <div class="employee-notification-content">
                                                <h6>
                                                    <a href="activities.html">
                                                        Gentle remainder about train
                                                    </a>
                                                </h6>
                                                <ul class="nav">
                                                    <li>09:00 AM</li>
                                                    <li>21 Apr 2024</li>
                                                </ul>
                                            </div>
                                        </li>
                                        <li class="employee-notification-grid">
                                            <div class="employee-notification-icon">
                                                <a href="activities.html">
                                                    <span class="badge-soft-danger rounded-circle">AU</span>
                                                </a>
                                            </div>
                                            <div class="employee-notification-content">
                                                <h6>
                                                    <a href="activities.html">
                                                        Our HR system will be down
                                                    </a>
                                                </h6>
                                                <ul class="nav">
                                                    <li>11:50 AM</li>
                                                    <li>21 Apr 2024</li>
                                                </ul>
                                            </div>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    {{--<div class="row">
        <div class="col-xl-6 col-md-12 d-flex">
            <div class="card employee-month-card flex-fill">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-lg-9 col-md-12">
                            <div class="employee-month-details">
                                <h4>Employee of the month</h4>
                                <p>We are really proud of the difference you have made which gives everybody the reason to applaud & appreciate</p>
                            </div>
                            <div class="employee-month-content">
                                <h6>Congrats, Hanna</h6>
                                <p>UI/UX Team Lead</p>
                            </div>
                        </div>
                        <div class="col-lg-3 col-md-12">
                            <div class="employee-month-img">
                                <img src="assets/img/employee-img.png" class="img-fluid" alt="User">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


        <div class="col-xl-6 col-md-12 d-flex">
            <div class="card flex-fill">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-sm-8">
                            <div class="statistic-header">
                                <h4>Company Policy</h4>
                            </div>
                        </div>
                        <div class="col-sm-4 text-sm-end">
                            <div class="owl-nav company-nav nav-control"></div>
                        </div>
                    </div>
                    <div class="company-slider owl-carousel">

                        <div class="company-grid company-soft-tertiary">
                            <div class="company-top">
                                <div class="company-icon">
                                    <span class="company-icon-tertiary rounded-circle">HR</span>
                                </div>
                                <div class="company-link">
                                    <a href="companies.html">HR Policy</a>
                                </div>
                            </div>
                            <div class="company-bottom d-flex">
                                <ul>
                                    <li>Policy Name : Work policy</li>
                                    <li>Updated on : Today</li>
                                </ul>
                                <div class="company-bottom-links">
                                    <a href="#"><i class="la la-download"></i></a>
                                    <a href="#"><i class="la la-eye"></i></a>
                                </div>
                            </div>
                        </div>


                        <div class="company-grid company-soft-success">
                            <div class="company-top">
                                <div class="company-icon">
                                    <span class="company-icon-success rounded-circle">EP</span>
                                </div>
                                <div class="company-link">
                                    <a href="companies.html">Employer Policy</a>
                                </div>
                            </div>
                            <div class="company-bottom d-flex">
                                <ul>
                                    <li>Policy Name : Parking</li>
                                    <li>Updated on : 25 Jan 2024</li>
                                </ul>
                                <div class="company-bottom-links">
                                    <a href="#"><i class="la la-download"></i></a>
                                    <a href="#"><i class="la la-eye"></i></a>
                                </div>
                            </div>
                        </div>


                        <div class="company-grid company-soft-info">
                            <div class="company-top">
                                <div class="company-icon">
                                    <span class="company-icon-info rounded-circle">LP</span>
                                </div>
                                <div class="company-link">
                                    <a href="companies.html">Leave Policy</a>
                                </div>
                            </div>
                            <div class="company-bottom d-flex">
                                <ul>
                                    <li>Policy Name : Annual Leave</li>
                                    <li>Updated on : 25 Jan 2023</li>
                                </ul>
                                <div class="company-bottom-links">
                                    <a href="#"><i class="la la-download"></i></a>
                                    <a href="#"><i class="la la-eye"></i></a>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>

    </div>--}}
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
