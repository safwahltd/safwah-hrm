@extends('admin.layout.app')
@section('title','Daily Report')
@section('body')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Daily Report</h3>
            </div>
        </div>
    </div>
    <!-- Row end  -->

    <div class="row clearfix g-3">
        <div class="row filter-row justify-content-end">
            <div class="col-sm-6 col-4 text-end my-2">
                <form method="get" action="{{route('admin.daily.report')}}">
                    <select class="form-control-sm" name="month" id="month" required>
                        <option {{ $month == 0 ? 'selected' : '' }} value="0">All</option>
                        @for ($i = 1; $i <= 12; $i++)
                            <option {{ $i == $month ? 'selected' : '' }} value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                        @endfor
                    </select>

                    <select class="form-control-sm" name="year" id="year" required>
                        <option {{ $year == 0 ? 'selected' : '' }} value="0">All</option>
                        @for ($i = date('Y'); $i >= 2022; $i--)
                            <option {{ $i == $year ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                        @endfor
                    </select>
                    <select class="form-control-sm"  name="day" id="day">
                        <option value="">All Days</option>
                        @for($d = 1; $d <= 31; $d++)
                            <option value="{{ $d }}" {{ $d == $day ? 'selected' : '' }}>{{ $d }}</option>
                        @endfor
                    </select>
                    <button class="form-control-sm text-white bg-success px-3"  type="submit">Filter</button>
                </form>
            </div>
        </div>
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="row g-2 row-deck">
                        <div class="col-md-3 col-sm-4">
                            <a href="{{route('admin.attendance.list')}}">
                                <div class="card">
                                    <div class="card-body">
                                        <i class="icofont-checked fs-3"></i>
                                        <h6 class="mt-3 mb-0 fw-bold small-14">Attendance</h6>
                                        <span class="text-black">{{$attendanceReport}}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-4">
                            <a href="{{route('admin.termination.index')}}">
                                <div class="card">
                                    <div class="card-body ">
                                        <i class="icofont-ban fs-3"></i>
                                        <h6 class="mt-3 mb-0 fw-bold small-14">Termination</h6>
                                        <span class="text-black">{{$terminationReport}}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-4">
                            <a href="{{route('asset.index')}}">
                                <div class="card">
                                    <div class="card-body ">
                                        <i class="icofont-abacus fs-3"></i>
                                        <h6 class="mt-3 mb-0 fw-bold small-14">Asset</h6>
                                        <span class="text-black">{{$assetReport}}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-4">
                            <a href="{{route('admin.salary.payment.index')}}">
                                <div class="card">
                                    <div class="card-body ">
                                        <i class="icofont-money-bag fs-3"></i>
                                        <h6 class="mt-3 mb-0 fw-bold small-14">Salary Paid</h6>
                                        <span class="text-black">{{ $salaryReport }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>
                        <div class="col-md-3 col-sm-4">
                            <a href="{{route('admin.notice.index')}}">
                                <div class="card">
                                    <div class="card-body ">
                                        <i class="icofont-beach-bed fs-3"></i>
                                        <h6 class="mt-3 mb-0 fw-bold small-14">Notice</h6>
                                        <span class="text-black">{{ $noticeReport }}</span>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->
@endsection
