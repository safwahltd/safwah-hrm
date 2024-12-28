@extends('admin.layout.app')
@section('title','Office Expense Report')
@section('body')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Office Expense Report</h3>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-3">
        <form method="get" target="_blank" action="{{route('admin.expense.office.report.show')}}">
            <div class="row">
                <div class="col-md-4 col-6 my-2">
                    <div class="card ">
                        <div class="card-header"><label for="leave_type" class="text-dark"> Start Date <span class="text-danger">*</span></label></div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <input class="w-100" type="date" name="start_date" required>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-6 my-2">
                    <div class="card ">
                        <div class="card-header"><label for="leave_type" class="text-dark">End Date</label></div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <input class="w-100" type="date" name="end_date">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-6 my-2">
                    <div class="d-flex my-4 align-items-center">
                        <button class="form-control-lg text-white bg-success px-3"  type="submit">Show Report</button>
                    </div>
                </div>
            </div>
            <div class="my-3 text-center">

            </div>

        </form>
    </div>
@endsection



