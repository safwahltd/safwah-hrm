@extends('admin.layout.app')
@section('title','Leave Report')
@section('body')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Asset Report</h3>
            </div>
        </div>
    </div>
    <div class="row g-3 mb-3">
        <form method="get" target="_blank" action="{{route('admin.asset.report.show')}}">
            @csrf
            <div class="row">
                <div class="col my-2">
                    <div class="card ">
                        <div class="card-header"><label for="leave_type" class="text-dark">Employee</label></div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <select class="form-control select2-example"  name="user_id" id="user_id">
                                    <option value="">All</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} <sub>({{ $user->userInfo->employee_id }})</sub></option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col my-2">
                    <div class="card ">
                        <div class="card-header"><label for="leave_type" class="text-dark">Status</label></div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <select class="form-control-sm" name="status" id="status">
                                    <option value="">All</option>
                                    <option  value="1">Active</option>
                                    <option  value="0">Inactive</option>
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



