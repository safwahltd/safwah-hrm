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
    <div class="row">
        <div class="col-md-12">
            <form method="get" target="_blank" action="{{route('admin.asset.report.show')}}">
                <label for="Month" class="text-white mx-2">Employee</label>
                <select class="form-control-lg select2-example"  name="user_id" id="user_id">
                    <option value="">All</option>
                    @foreach($users as $user)
                        <option value="{{ $user->id }}">{{ $user->name }}</option>
                    @endforeach
                </select>
                <label for="status" class="text-white mx-2">Status</label>
                <select class="form-control-sm" name="status" id="status">
                    <option value="">All</option>
                    <option  value="1">Active</option>
                    <option  value="0">Inactive</option>
                </select>
                <button class="form-control-sm text-white bg-success px-3"  type="submit">Show Report</button>
            </form>
        </div>
    </div>
@endsection



