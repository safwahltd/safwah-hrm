@extends('admin.layout.app')
@section('title','Dashboard')
@section('body')
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
                                                <h6 class="mt-3 mb-0 fw-bold small-14">Attendance</h6>
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
                                                <h6 class="mt-3 mb-0 fw-bold small-14">Late Coming</h6>
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
                                                <h6 class="mt-3 mb-0 fw-bold small-14">Absent</h6>
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
                    breakpoint: 480,
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
@endpush
