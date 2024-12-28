@extends('admin.layout.app')
@section('title','HR Dashboard')
@section('body')
        <div class="text-center text-white">
            <h2 class="fw-bold">HR DASHBOARD</h2>
            <hr>
        </div>
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
                                        <p class="fw-bold text-white" style="font-size: 150%;">৳ {{ number_format( \App\Models\OfficeExpense::where('status',1)->sum('amount') , 2) }}</p>
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
@endsection
@push('js')
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
@endpush

