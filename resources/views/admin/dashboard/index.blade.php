@extends('admin.layout.app')
@section('title','Dashboard')
@section('body')
    @if(auth()->user()->role == 'admin')
        <div class="row clearfix g-3">
            <div class="col-md-6">
                <div class="row g-3">
                    <div class="col-md-3 col-6">
                        <a href="{{route('admin.department.index')}}">
                            <div class="card bg-primary" style="width: 100%; height: 100%;">
                                <div class="card-body text-center row">
                                    <div class="col">
                                        <h2 class="fw-bold text-white">{{$departments}}</h2>
                                        <span class="text-white">Departments</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="{{route('admin.designation.index')}}">
                            <div class="card bg-success" style="width: 100%; height: 100%;">
                                <div class="card-body text-center  row">
                                    <div class="col">
                                        <h2 class="fw-bold text-white ">{{$designations}}</h2>
                                        <span class="text-white ">Designation</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="{{route('admin.termination.index')}}">
                            <div class="card bg-secondary" style="width: 100%; height: 100%;">
                                <div class="card-body text-center  row">
                                    <div class="col">
                                        <h2 class="fw-bold text-white">{{$terminations}}</h2>
                                        <span class="text-white">Termination</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-3 col-6">
                        <a href="{{route('admin.asset.index')}}">
                            <div class="card bg-warning" style="width: 100%; height: 100%;">
                                <div class="card-body text-center  row">
                                    <div class="col">
                                        <h2 class="fw-bold text-white ">{{ count($assets) }}</h2>
                                        <span class="text-white">Assets</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{route('admin.salary.payment.index')}}">
                            <div class="card" style="background-color: #ff253a">
                                <div class="card-body text-center row">
                                    <div class="col p-1">
                                        <p class="fw-bold text-white" style="font-size: 150%;">৳ {{ number_format($totalSalaryPayment, 2) }}</p>
                                        <span class="text-white">Total Salary</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{route('admin.salary.payment.index')}}">
                            <div class="card" style="background-color: #2c0b0e">
                                <div class="card-body text-center row">
                                    <div class="col p-1">
                                        <p class="fw-bold text-white" style="font-size: 150%;">৳ {{ $totalEmployees->count() != 0 ? number_format($totalSalaryPayment / $totalEmployees->count(), 2) : 0  }}</p>
                                        <span class="text-white">Average Salary</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{route('admin.asset.index')}}">
                            <div class="card" style="background-color: #990055">
                                <div class="card-body text-center row">
                                    <div class="col p-1">
                                        <p class="fw-bold text-white" style="font-size: 150%;">৳ {{ number_format($totalAssets, 2) }}</p>
                                        <span class="text-white">Total Assets</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{route('admin.asset.index')}}">
                            <div class="card" style="background-color: #6a1a21">
                                <div class="card-body text-center row">
                                    <div class="col p-1">
                                        <p class="fw-bold text-white" style="font-size: 150%;">৳ {{ $totalEmployees->count() != 0 ? number_format($totalAssets / $totalEmployees->count(), 2) : 0  }}</p>
                                        <span class="text-white">Average Assets</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-6">
                        <a href="{{route('admin.office.expenses.index')}}">
                            <div class="card" style="background-color: #111111">
                                <div class="card-body text-center row">
                                    <div class="col p-1">
                                        <p class="fw-bold text-white" style="font-size: 150%;">৳ {{ number_format( \App\Models\OfficeExpense::where('status',1)->where('soft_delete',0)->sum('amount') , 2) }}</p>
                                        <span class="text-white">Total Expense</span>
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-12 col-lg-12 col-xl-12">
                        <div class="card">
                            <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                                <h6 class="mb-0 fw-bold ">Upcoming Holidays</h6>
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
                                                            <td><span style="font-size: 7px" class="p-1 rounded-2 text-white {{ $holiday->date_to > \Illuminate\Support\Carbon::now() ? 'bg-success' : 'bg-danger' }}">{{ $holiday->date_to > \Illuminate\Support\Carbon::now() ? 'In Coming' : 'Passed' }}</span></td>
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
                                        <a href="{{route('admin.holiday.index')}}" class="btn btn-primary p-1 my-2">
                                            View All <i class="fe fe-arrow-right-circle"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 flex-column">
                <div class="row g-3">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                            <h6 class="mb-0 fw-bold ">
                                <select style="font-size: 12px;" class="select2-example my-2" name="month" id="user_id_attendance">
                                    <option value="">select one</option>
                                        @foreach($users as $user)
                                            <option value="{{ $user->id }}">{{ $user->name.' '.'('.$user->userInfo->employee_id.')' }}</option>
                                        @endforeach
                                </select>
                                <select class="my-2" name="month" id="month">
                                    <option value="">All Month</option>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                        @endfor
                                    </select>
                                <select class="my-2" name="year" id="year" required>
                                        @for ($i = date('Y'); $i >= 2022; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                <button id="filter-btn"  class="btn-success mx-2 px-3 my-2 rounded-2">Apply</button>
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row" id="attendanceFilter">
                                <div class="col-6 my-1 text-center">
                                    <a href="{{route('admin.attendance.index')}}">
                                        <div class="card" style="background-color: #990055; width: 100%;">
                                            <div class="card-body">
                                                <i class="icofont-checked fs-3 text-white"></i>
                                                <h6 class="mt-3 mb-2 text-white fw-bold small-14"> Attendance</h6>
                                                <span class="text-white fs-4 fw-bold">{{$totalPresent}}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6 my-1 text-center">
                                    <a href="{{route('admin.attendance.index')}}">
                                        <div class="card" style="background-color: #2c0b0e; width: 100%;">
                                            <div class="card-body ">
                                                <i class="icofont-stopwatch fs-3 text-white"></i>
                                                <h6 class="mt-3 mb-2 fw-bold small-14 text-white">Late Attendance</h6>
                                                <span class="text-white fs-4 fw-bold">{{$totalLate}}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6 my-1 text-center">
                                    <a href="{{route('admin.attendance.index')}}">
                                        <div class="card" style="background-color: #000000; width: 100%;">
                                            <div class="card-body ">
                                                <i class="icofont-ban fs-3 text-white text-left"></i>
                                                <h6 class="mt-3 mb-2 fw-bold small-14 text-white">Absent</h6>
                                                <span class="text-white fs-4 fw-bold">{{$totalAbsent}}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                                <div class="col-6 my-1 text-center">
                                    <a href="{{route('admin.leave.requests')}}">
                                        <div class="card" style="background-color: #ff253a; width: 100%;">
                                            <div class="card-body ">
                                                <i class="icofont-beach-bed fs-3 text-white"></i>
                                                <h6 class="mt-3 mb-2 fw-bold small-14 text-white">Leave Apply</h6>
                                                <span class="text-white fs-4 fw-bold">{{$leaveApply}}</span>
                                            </div>
                                        </div>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12">
                    <div class="card">
                        <div class="card-header py-3 d-flex justify-content-between bg-transparent border-bottom-0">
                            <h6 class="mb-0 fw-bold ">Total Employees</h6>
                            <h5 class="mb-0 fw-bold ">{{count($totalEmployees)}}</h5>
                        </div>
                        <div class="card-body">
                            <div class="mt-3" id="apex-MainCategories"></div>
                        </div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    @else
        <style>
            .clock {
                font-family: 'Courier New', Courier, monospace;
                font-size: 35px;
                font-weight: bold;
                color: #fff;
                padding: 20px;
                border: 10px solid white;
                border-radius: 10px;
                background-color: #111;
                box-shadow: 0 0 15px rgba(0, 255, 0, 0.5);
                text-align: center;
                height: 170px;
            }

            .date {
                font-size: 20px;
                color: #aaa;
            }
        </style>
        <div class="row">
            <div class="col-xxl-12 col-lg-12 col-md-12">
                <div class="row">
                    <div class="col-lg-6 col-md-12 my-1">
                        <div class="card bg-primary-gradient my-1">
                            <div class="card-body">
                                <div class="d-flex">
                                    <div class="">
                                        <h5>Welcome Back, <span class="fw-bold">{{auth()->user()->name ?? 'N/A'}}</span></h5>
                                        <p><span class="">{{ auth()->user()->userInfo->designations->name ?? 'N/A'}}</span></p>
                                        <p><span class="">ID : SL{{ auth()->user()->userInfo->employee_id ?? 'N/A'}}</span></p>
                                    </div>
                                    <div class="">
                                        @if(file_exists(auth()->user()->userInfo->image))
                                            <img src="{{asset(auth()->user()->userInfo->image)}}" alt="profile"  width="100" height="100" style="border-radius: 100%" class="img-responsive">
                                        @else
                                            <img class="img-responsive" src="{{asset('/')}}admin/assets/images/lg/{{auth()->user()->userInfo->gender == '1' ? 'avatar5.jpg':''}}{{auth()->user()->userInfo->gender == '2' ? 'avatar2.jpg':''}}{{auth()->user()->userInfo->gender == '3' ? 'avatar4.jpg':''}}"  width="100" style="border-radius: 100%" height="100"  alt="profile">
                                        @endif

                                    </div>
                                </div>
                                <div class="">
                                    <a href="{{route('employee.profile.details')}}" class="btn btn-primary">View Profile</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-12 my-1">
                        <div class="clock">
                            <div id="digital-clock">00:00:00 AM</div>
                            <div class="date" id="digital-date">Sunday, December 9, 2024</div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="">
                        <div class="card flex-fill my-1">
                            <div class="card-body">
                                <div class="attendance-list">
                                    <div class="text-end">
                                        <select class="my-2" name="month" id="allMonth">
                                            <option value="">All Month</option>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                            @endfor
                                        </select>
                                        <select class="my-2" name="year" id="allYear">
                                            @for ($i = date('Y'); $i >= 2022; $i--)
                                                <option value="{{ $i }}">{{ $i }}</option>
                                            @endfor
                                        </select>
                                        <button id="allfilter-btn" class="px-4">Filter</button>
                                    </div>
                                    <div class="row" id="allFilter">
                                        <div class="col-md-3 col-6 my-1" align="center">
                                            <div class="attendance-details bg-success p-2 rounded-2">
                                                <h5 class="fw-bold text-white">{{$totalWorkingDay ?? 0}}</h5>
                                                <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Working Days</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6 my-1" align="center">
                                            <div class="attendance-details bg-primary p-2 rounded-2">
                                                <h5 class="fw-bold text-white">{{$totalAttend ?? 0}}</h5>
                                                <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Total Attend</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6 my-1" align="center">
                                            <div class="attendance-details p-2 rounded-2" style="background-color: #98427e">
                                                <h5 class="fw-bold text-white">{{$totalLate ?? 0}}</h5>
                                                <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Total Late</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6 my-1" align="center">
                                            <div class="attendance-details bg-primary-gradient p-2 rounded-2">
                                                <h5 class="fw-bold text-white">{{ $totalAbsent ?? 0 }}</h5>
                                                <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Total Absent</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6 my-1" align="center">
                                            <div class="attendance-details bg-dark-defualt p-2 rounded-2">
                                                <h5 class="fw-bold text-white">{{ $totalHolidays  ?? 0 }}</h5>
                                                <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Holidays</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6 my-1" align="center">
                                            <div class="attendance-details p-2 rounded-2" style="background-color: blue">
                                                <h5 class="fw-bold text-white">{{ (($leave->sick ?? 0) + ($leave->casual ?? 0)) }}</h5>
                                                <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Total Leave</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6 my-1" align="center">
                                            <div class="attendance-details p-2 rounded-2" style="background-color: orangered">
                                                <h5 class="fw-bold text-white">{{ (($leave->sick_spent ?? 0) + ($leave->casual_spent ?? 0)) }}</h5>
                                                <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Leaves Taken</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6 my-1" align="center">
                                            <div class="attendance-details p-2 rounded-2" style="background-color: #006b60">
                                                <h5 class="fw-bold text-white">{{ (($leave->sick_left ?? 0) + ($leave->casual_left ?? 0)) }}</h5>
                                                <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Leaves Left</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6 my-1" align="center">
                                            <div class="attendance-details p-2 rounded-2" style="background-color: #990055">
                                                <h5 class="fw-bold text-white">{{ $leaveBalance->half_day_total ?? 0}}</h5>
                                                <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Half Day</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6 my-1" align="center">
                                            <div class="attendance-details p-2 rounded-2" style="background-color: #D63B38">
                                                <h5 class="fw-bold text-white">{{ $leaveBalance->spent_total ?? 0}}</h5>
                                                <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Half Day Spent</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6 my-1" align="center">
                                            <div class="attendance-details p-2 rounded-2" style="background-color: olivedrab">
                                                <h5 class="fw-bold text-white">{{$leaveBalance->left_total ?? 0}}</h5>
                                                <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Half Day Left</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6 my-1" align="center">
                                            <div class="attendance-details p-2 rounded-2" style="background-color: #444444">
                                                <h5 class="fw-bold text-white">{{ $totalAssets->count() ?? 0}}</h5>
                                                <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Total Asset</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6 my-1" align="center">
                                            <div class="attendance-details p-2 rounded-2" style="background-color: #3788d8">
                                                <h5 class="fw-bold text-white">{{ number_format($totalAssets->sum('value')) ??  0}}</h5>
                                                <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Asset Value</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6 my-1" align="center">
                                            <div class="attendance-details p-2 rounded-2" style="background-color: #7b5e3e">
                                                <h5 class="fw-bold text-white">{{ number_format($totalAdvanceAmount) ??  0 }}</h5>
                                                <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Advance Money</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6 my-1" align="center">
                                            <div class="attendance-details p-2 rounded-2" style="background-color: #021e16">
                                                <h5 class="fw-bold text-white">{{number_format($totalMoneyAmount) ??  0}}</h5>
                                                <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Money Receipt</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6 my-1" align="center">
                                            <div class="attendance-details p-2 rounded-2" style="background-color: #6c757d">
                                                <h5 class="fw-bold text-white">{{number_format($totalPayment) ??  0}}</h5>
                                                <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Payment</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6 my-1" align="center">
                                            <div class="attendance-details p-2 rounded-2" style="background-color: #523e02">
                                                <h5 class="fw-bold text-white">
                                                    @if($totalMoneyAmount < ($totalAdvanceAmount + $totalPayment))
                                                        {{ $TOTaldue = number_format(str_replace('-','', (($totalAdvanceAmount + $totalPayment) - $totalMoneyAmount))) }}
                                                    @else
                                                        {{ $TOTaldue = 0 }}
                                                    @endif
                                                </h5>
                                                <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Due</p>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-6 my-1" align="center">
                                            <div class="attendance-details p-2 rounded-2" style="background-color: #033b3a">
                                                <h5 class="fw-bold text-white">
                                                    @php
                                                        if($totalMoneyAmount > ($totalAdvanceAmount + $totalPayment)){
                                                            $t = $totalMoneyAmount - ($totalAdvanceAmount + $totalPayment );
                                                            }
                                                            else{
                                                                $t = 0;
                                                            }
                                                    @endphp
                                                    {{ number_format(str_replace('-','', ($t))) }}
                                                </h5>
                                                <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Receivable</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="my-2">
                                    <a href="{{route('employee.attendance.list')}}" class="btn text-white my-1 bg-success">
                                        Attendance <i class="fa fa-arrow-right"></i>
                                    </a>
                                    <a href="{{route('employee.leave')}}" class="btn text-white my-1" style="background-color: #990055">
                                        Apply Leave <i class="fa fa-arrow-right"></i>
                                    </a>
                                    <a href="{{route('employee.advance.money.index')}}" class="btn my-1 text-white" style="background-color: #006b60">
                                        Apply Advance Money <i class="fa fa-arrow-right"></i>
                                    </a>
                                    <a href="{{route('employee.holiday.index')}}" class="btn text-white  my-1 bg-dark-defualt">
                                        Holidays <i class="fa fa-arrow-right"></i>
                                    </a>
                                    <a href="{{route('employee.profile.details')}}" class="btn my-1 text-white btn-secondary">
                                        Profile <i class="fa fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="">
                        <div class="card bg-dark-subtle my-1">
                            <div class="card-body">
                                <h5 class="fw-bold">Latest Attendances</h5>
                                <div class="row table-responsive">
                                    <table class="table text-center table-bordered text-nowrap table-secondary key-buttons border-bottom w-100" style="font-size: 12px;">
                                        <thead class="bg-primary">
                                        <tr class="bg-secondary">
                                            <th class="bg-primary-subtle">No</th>
                                            <th class="bg-primary-subtle">Date</th>
                                            <th class="bg-primary-subtle">Attend</th>
                                            <th class="bg-primary-subtle">Late</th>
                                            <th class="bg-primary-subtle">Absent</th>
                                            <th class="bg-primary-subtle">Attachment</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @forelse($attendances as $key => $attendance)
                                            <tr>
                                                <td><span class="fw-bold">{{$loop->iteration}}</span></td>
                                                <td align="center">{{ date('F', mktime(0, 0, 0, $attendance->month, 1)) }} , {{ $attendance->year }}</td>
                                                <td class="text-center">{{ $attendance->attend ?? '-' }}</td>
                                                <td class="text-center">{{ $attendance->late ?? '-' }}</td>
                                                <td align="center">{{ $attendance->absent ?? '-' }}</td>
                                                <td align="center">
                                                    @if(!empty($attendance->attachment))
                                                    <a href="{{ route('admin.attendance.showFile', $attendance->id) }}" target="_blank" class="btn btn-success">View Attachment</a>
                                                    @else
                                                        -
                                                    @endif
                                                </td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="6" class="text-center"><span class="fw-bold">No Result</span></td>
                                            </tr>
                                        @endforelse
                                        </tbody>
                                    </table>
                                </div>
                                <div class="view-attendance">
                                    <a href="{{route('employee.attendance.list')}}" class="btn btn-primary p-1 my-2">
                                        View All <i class="fe fe-arrow-right-circle"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card info-card my-1">
                            <div class="card-body">
                                <h5 class="fw-bold">Upcoming Holidays</h5>
                                <div class="">
                                    <div class="">
                                        <div class="">
                                            <div class="row table-responsive">
                                                <table class="table text-center table-bordered text-nowrap table-secondary key-buttons border-bottom w-100">
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
                                                            <td align="left"><small>{{$holiday->name}}</small></td>
                                                            <td>
                                                                <small>{{ \Illuminate\Support\Carbon::parse($holiday->date_from)->format('d M') }} -</small>
                                                                <small>{{ \Illuminate\Support\Carbon::parse($holiday->date_to)->format('d M, Y') }}</small>
                                                            </td>
                                                            <td><small>{{ $holiday->total_day }} {{$holiday->total_day <= 1 ? 'day':'days'}}</small></td>
                                                            <td><span style="font-size: 10px" class="p-1 px-3 rounded-2 text-dark">{{ $holiday->date_to > \Illuminate\Support\Carbon::now() ? 'In Coming' : 'Passed' }}</span></td>
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
        <script>
            $(document).ready(function() {
                $('#filter-btn').click(function() {
                    const user_id = $('#user_id_attendance').val();
                    const month = $('#month').val();
                    const year = $('#year').val();
                    console.log(month,year);
                    $.ajax({
                        url: '{{ route('admin.dashboard.attendance.filter') }}',
                        method: 'GET',
                        data: {
                            user_id: user_id,
                            month: month,
                            year: year
                        },
                        success: function(response) {
                            $('#attendanceFilter').empty();
                            $('#attendanceFilter').html(response.html);
                        }
                    });
                });
            });
        </script>

    @else
        <script>
            function updateClock() {
                const now = new Date();

                let hours = now.getHours();
                const minutes = String(now.getMinutes()).padStart(2, '0');
                const seconds = String(now.getSeconds()).padStart(2, '0');

                // Determine AM or PM
                const period = hours >= 12 ? 'PM' : 'AM';

                // Convert to 12-hour format
                hours = hours % 12;
                hours = hours ? String(hours).padStart(2, '0') : '12'; // 0 becomes 12

                // Format time as HH:MM:SS AM/PM
                const timeString = `${hours}:${minutes}:${seconds} ${period}`;

                // Update the clock time
                document.getElementById('digital-clock').innerText = timeString;

                // Get the current date
                const day = now.toLocaleString('default', { weekday: 'long' });
                const month = now.toLocaleString('default', { month: 'long' });
                const date = now.getDate();
                const year = now.getFullYear();

                // Format date as Day, Month Date, Year
                const dateString = `${day}, ${month} ${date}, ${year}`;

                // Update the clock date
                document.getElementById('digital-date').innerText = dateString;
            }

            // Update the clock and date every 1000ms (1 second)
            setInterval(updateClock, 1000);

            // Initialize the clock and date immediately
            updateClock();
        </script>
        <script>
            $(document).ready(function() {
                $('#allfilter-btn').click(function() {
                    const month = $('#allMonth').val();
                    const year = $('#allYear').val();
                    console.log(month,year);
                    $.ajax({
                        url: '{{ route('employee.dashboard.all.filter') }}',
                        method: 'GET',
                        data: {
                            month: month,
                            year: year
                        },
                        success: function(response) {
                            $('#allFilter').empty();
                            $('#allFilter').html(response.html);
                        }
                    });
                });
            });
        </script>
    @endif
@endpush
