@extends('admin.layout.app')
@section('title','Attendance Monthly Details')
@section('body')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Attendance Monthly Details</h3>
            </div>
        </div>
    </div>
    <!-- Row end  -->

    <div class="row g-3 mb-3">
        <form method="get" target="_blank" action="{{route('admin.attendance.month.details')}}">
            @csrf
            <div class="row">
                <div class="col my-2">
                    <div class="card ">
                        <div class="card-header"><label for="leave_type" class="text-dark">Employee <span class="text-danger">*</span></label></div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <select class="form-control select2-example"  name="user_id" id="user_id" required>
                                    <option value="">All</option>
                                    @foreach($users as $user)
                                        <option value="{{ $user->id }}">{{ $user->name }} ({{$user->userInfo->employee_id}})</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col my-2">
                    <div class="card ">
                        <div class="card-header"><label for="leave_type" class="text-dark">Month <span class="text-danger">*</span></label></div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <select class="form-control-sm" name="month" id="month" required>
                                    @for ($i = 1; $i <= 12; $i++)
                                        <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col my-2">
                    <div class="card ">
                        <div class="card-header"><label for="leave_type" class="text-dark">Year <span class="text-danger">*</span></label></div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <select class="form-control-lg select2-example" name="year" id="year" required>
                                    @for ($i = date('Y'); $i >= 2022; $i--)
                                        <option  value="{{ $i }}">{{ $i }}</option>
                                    @endfor
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
            <div class="my-3 text-center">
                <button class="form-control-lg text-white bg-dark px-3"  type="submit">Show Details</button>
            </div>

        </form>
    </div><!-- Row End -->
    <!-- Row End -->
@endsection

