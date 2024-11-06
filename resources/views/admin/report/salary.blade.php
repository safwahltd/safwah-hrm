@extends('admin.layout.app')
@section('title','Salary Report')
@section('body')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Salary Report</h3>
            </div>
        </div>
    </div>
    <!-- Row end  -->
    <div class="row">
        <div class="col-md-12">
            <form method="get" target="_blank" action="{{route('admin.salary.report.show')}}">
                <label for="Month" class="text-white mx-2">Month</label>
                <select class="form-control-lg" name="month" id="month" required>
                    <option value="0">All</option>
                    @for ($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                    @endfor
                </select>
                <label for="year" class="text-white mx-2">Year</label>
                <select class="form-control-lg" name="year" id="year" required>
                    <option value="0">All</option>
                    @for ($i = date('Y'); $i >= 2022; $i--)
                        <option  value="{{ $i }}">{{ $i }}</option>
                    @endfor
                </select>
                <button class="form-control-lg text-white bg-success px-3"  type="submit">Show Report</button>
            </form>
        </div>
    </div>
@endsection

