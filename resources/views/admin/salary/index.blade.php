@extends('admin.layout.app')
@section('title','Salary Management')
@section('body')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Salary Management</h3>
                <div class="col-auto d-flex w-sm-100">
                    <button type="button" class="btn btn-dark btn-set-task w-sm-100" data-bs-toggle="modal" data-bs-target="#salaryAdd"><i class="icofont-plus-circle me-2 fs-6"></i>Add</button>
                </div>
            </div>
        </div>
    </div>
    <!-- Row end  -->

    <div class="row clearfix g-3">
        <div class="col-sm-12">
            <div class="row filter-row justify-content-end">
                <div class="col-sm-12 text-end my-2">
                    <form method="get" action="{{route('admin.salary.index')}}">
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
                        <button class="form-control-sm text-white bg-primary px-3"  type="submit">Filter</button>
                    </form>
                </div>

            </div>

            <div class="card mb-3">
                <div class="card-body table-responsive bg-dark-subtle table-responsive">
                    <table id="basic-datatable" class="table table-bordered text-nowrap table-secondary key-buttons border-bottom w-100">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Date</th>
                                <th>Basic Salary <sub>(BDT)</sub></th>
                                <th>Total Pay <sub>(BDT)</sub></th>
                                <th>Total Deduction <sub>(BDT)</sub></th>
                                <th>Net Pay <sub>(BDT)</sub></th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($salaries as $key => $salary)
                            <tr>
                                <td>{{ $salary->user->name }}</td>
                                <td>{{ date('F', mktime(0, 0, 0, $salary->month, 1)) }}, {{ $salary->year }}</td>
                                <td>{{ $salary->basic_salary }} </td>
                                <td>{{ $allowance = ($salary->house_rent + $salary->medical_allowance + $salary->conveyance_allowance + $salary->others + $salary->mobile_allowance + $salary->bonus) }} </td>
                                <td>{{ $deductions = ($salary->meal_deduction + $salary->income_tax + $salary->other_deduction + $salary->attendance_deduction)}} </td>
                                <td>{{ ($salary->basic_salary + $allowance) - $deductions }} </td>
                                <td><span class="p-1 rounded-2  text-white {{ $salary->status == 1 ? 'bg-success':'bg-danger' }}">{{ $salary->status == 1 ? 'Active':'Inactive' }}</span></td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#salaryEdit{{$key}}"><i class="icofont-edit text-success"></i></button>
                                        <form action="{{route('admin.salary.destroy',$salary->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('are you sure to delete ? ')" class="btn btn-outline-secondary mx-1 deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                        </form>
                                        <a href="{{route('admin.salary.download',$salary->id)}}"  class="btn btn-outline-secondary"><i class="icofont-download text-success"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <div class="modal fade" id="salaryEdit{{$key}}" tabindex="-1"  aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title  fw-bold" id="depaddLabel"> Salary Edit</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>

                                        <div class="modal-body">
                                            <form action="{{route('admin.salary.update',$salary->id)}}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <div class="deadline-form">
                                                    <div class="row g-3 mb-3">
                                                        <div class="col-sm-6">
                                                            <label for="department_head" class="form-label">Employee <span class="text-danger">*</span></label>
                                                            <select class="form-control" name="user_id" id="department_head">
                                                                @foreach($users as $user)
                                                                    <option {{ $salary->user_id == $user->id ? 'selected':''}} value="{{$user->id}}">{{$user->name}} ({{$user->userInfo->employee_id}})</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="month" class="form-label">Month <span class="text-danger">*</span></label>
                                                            <select class="form-control" name="month" id="month" required>
                                                                @for ($i = 1; $i <= 12; $i++)
                                                                    <option {{$salary->month == $i ? 'selected':''}} value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="year" class="form-label">Year <span class="text-danger">*</span></label>
                                                            <select class="form-control" name="year" id="year" required>
                                                                @for ($i = date('Y'); $i >= 2022; $i--)
                                                                    <option {{$salary->year == $i ? 'selected':''}}  value="{{ $i }}">{{ $i }}</option>
                                                                @endfor
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="" class="form-label">Basic Salary <span class="text-danger">*</span></label>
                                                            <input type="number" name="basic_salary" value="{{$salary->basic_salary}}" class="form-control" id="" placeholder="example : 10000">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="" class="form-label">House Rent</label>
                                                            <input type="number" name="house_rent" value="{{$salary->house_rent}}" class="form-control" id="" placeholder="example : 10000">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="" class="form-label">Medical Allowance</label>
                                                            <input type="number" name="medical_allowance" value="{{$salary->medical_allowance}}" class="form-control" id="" placeholder="example : 10000">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="" class="form-label">Conveyance Allowance</label>
                                                            <input type="number" name="conveyance_allowance" value="{{$salary->conveyance_allowance}}" class="form-control" id="" placeholder="example : 10000">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="" class="form-label">Others</label>
                                                            <input type="number" name="others" value="{{$salary->others}}" class="form-control" id="" placeholder="example : 10000">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="" class="form-label">Mobile Allowance</label>
                                                            <input type="number" name="mobile_allowance" value="{{$salary->mobile_allowance}}" class="form-control" id="" placeholder="example : 10000">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="" class="form-label">Bonus</label>
                                                            <input type="number" name="bonus" value="{{$salary->bonus}}" class="form-control" id="" placeholder="example : 10000">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="" class="form-label">Meal Deduction</label>
                                                            <input type="number" name="meal_deduction" value="{{$salary->meal_deduction}}" class="form-control" id="" placeholder="example : 10000">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="" class="form-label">Income Tax</label>
                                                            <input type="number" name="income_tax" value="{{$salary->income_tax}}" class="form-control" id="" placeholder="example : 10000">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="" class="form-label">Other Deduction</label>
                                                            <input type="number" name="other_deduction" value="{{$salary->other_deduction}}" class="form-control" id="" placeholder="example : 10000">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="" class="form-label">Attendance Deduction</label>
                                                            <input type="number" name="attendance_deduction" value="{{$salary->attendance_deduction}}" class="form-control" id="" placeholder="example : 10000">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="status" class="form-label">Status</label>
                                                            <select class="form-control" name="status" id="status">
                                                                <option {{$salary->status == 1 ? 'selected':''}} value="1">Active</option>
                                                                <option {{$salary->status == 0 ? 'selected':''}} value="0">Inactive</option>
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="submit" class="btn btn-primary">Update</button>
                                                </div>
                                            </form>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="text-white my-3 d-grid justify-content-center">
                        {{$salaries->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->

    <!-- Add Salary-->
    <div class="modal fade" id="salaryAdd" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title  fw-bold" id="depaddLabel"> Salary Add</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="{{route('admin.salary.store')}}" method="post">
                        @csrf
                        <div class="deadline-form">
                            <div class="row g-3 mb-3">
                                <div class="col-sm-6">
                                    <label for="user_id" class="form-label">Employee <span class="text-danger">*</span></label>
                                    <select class="form-control" required name="user_id" id="user_id">
                                        @foreach($users as $user)
                                            <option {{ old('user_id') == $user->id ? 'selected':''}} value="{{$user->id}}">{{$user->name}} ({{$user->userInfo->employee_id}})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="month" class="form-label">Month <span class="text-danger">*</span></label>
                                    <select class="form-control" name="month" id="month" required>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="year" class="form-label">Year <span class="text-danger">*</span></label>
                                    <select class="form-control" name="year" id="year" required>
                                        @for ($i = date('Y'); $i >= 2022; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label">Basic Salary <span class="text-danger">*</span></label>
                                    <input type="number" required name="basic_salary" class="form-control" id="" placeholder="example : 10000">
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label">House Rent</label>
                                    <input type="number" name="house_rent" class="form-control" id="" placeholder="example : 10000">
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label">Medical Allowance</label>
                                    <input type="number" name="medical_allowance" class="form-control" id="" placeholder="example : 10000">
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label">Conveyance Allowance</label>
                                    <input type="number" name="conveyance_allowance" class="form-control" id="" placeholder="example : 10000">
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label">Others</label>
                                    <input type="number" name="others" class="form-control" id="" placeholder="example : 10000">
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label">Mobile Allowance</label>
                                    <input type="number" name="mobile_allowance" class="form-control" id="" placeholder="example : 10000">
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label">Bonus</label>
                                    <input type="number" name="bonus" class="form-control" id="" placeholder="example : 10000">
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label">Meal Deduction</label>
                                    <input type="number" name="meal_deduction" class="form-control" id="" placeholder="example : 10000">
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label">Income Tax</label>
                                    <input type="number" name="income_tax" class="form-control" id="" placeholder="example : 10000">
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label">Other Deduction</label>
                                    <input type="number" name="other_deduction" class="form-control" id="" placeholder="example : 10000">
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label">Attendance Deduction</label>
                                    <input type="number" name="attendance_deduction" class="form-control" id="" placeholder="example : 10000">
                                </div>
                                <div class="col-sm-6">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-control" name="status" id="status">
                                        <option selected value="1">Active</option>
                                        <option value="0">Inactive</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">Add</button>
                        </div>
                    </form>
                </div>

            </div>
        </div>
    </div>
@endsection

