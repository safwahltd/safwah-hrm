@extends('admin.layout.app')
@section('title','Money Receipt Report')
@section('body')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Money Receipt Report</h3>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-3">
        <form method="get" target="_blank" action="{{route('admin.expense.report.show')}}">
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
                    <div class="card ">
                        <div class="card-header"><label for="leave_type" class="text-dark">Receipt Type</label></div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <select class="w-100"  name="receipt_type" id="user_id">
                                    <option value="">Select Receipt Type</option>
                                    <option value="advance_money_receipt">Advance Money Receipt</option>
                                    <option value="money_receipt">Money Receipt</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 col-6 my-2">
                    <div class="card ">
                        <div class="card-header"><label for="leave_type" class="text-dark">Status</label></div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <select class="w-100"  name="status" id="user_id">
                                    <option value="">Select Receipt Type</option>
                                    <option value="0">Pending</option>
                                    <option value="1">Approved</option>
                                    <option value="2">Rejected</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-8 col-12 my-2">
                    <div class="card ">
                        <div class="card-header"><label for="leave_type" class="text-dark">Employee</label></div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <select class="form-control-lg select2-example w-100" style="width: 100%;" name="user_id" id="user_id">
                                    <option value="">All Employee</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} <sub>({{ $user->userInfo->employee_id }})</sub></option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="my-3 text-center">
                <button class="form-control-lg text-white bg-dark px-3"  type="submit">Show Report</button>
            </div>

        </form>
    </div>
@endsection



