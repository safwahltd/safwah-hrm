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
                    <table id="basic-datatable" class="table table-bordered text-nowrap table-secondary key-buttons border-bottom w-100" style="font-size: 13px;">
                        <thead>
                            <tr>
                                <th>SL</th>
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
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $salary->user->name }}</td>
                                <td>{{ date('F', mktime(0, 0, 0, $salary->month, 1)) }}, {{ $salary->year }}</td>
                                <td>{{ $salary->basic_salary }} </td>
                                <td>
                                        @php
                                        $pay = 0 ;
                                            if($salary->payment != ''){
                                                $payment = json_decode($salary->payment);
                                            foreach($salaryPaymentInputs as $paymentInput){
                                                $pay = $pay + ($payment->{$paymentInput->name} ?? 0);
                                            }
                                            }

                                        @endphp
                                    {{ $allowance = ($salary->basic_salary + $salary->house_rent + $salary->medical_allowance + $salary->conveyance_allowance + $salary->others + $salary->mobile_allowance + $salary->bonus + $pay) }}
                                </td>
                                <td>
                                    @php
                                        $deduct = 0 ;
                                            if($salary->deduct != ''){
                                                $deducts = json_decode($salary->deduct);
                                                /*dd(gettype($deduct->expense));*/
                                                foreach($salaryDeductInputs as $deductsInput){
                                                    $deduct = $deduct + ($deducts->{$deductsInput->name} ?? 0);
                                                }
                                            }

                                    @endphp
                                    {{ $deductions = ($salary->meal_deduction + $salary->income_tax + $salary->other_deduction + $salary->attendance_deduction + $deduct)}}
                                </td>
                                <td>{{ $allowance - $deductions }} </td>
                                <td><span class="p-1 rounded-2  text-white {{ $salary->status == 1 ? 'bg-success':'bg-danger' }}">{{ $salary->status == 1 ? 'Active':'Inactive' }}</span></td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#salaryShow{{$key}}"><i class="icofont-eye text-success"></i></button>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#salaryEdit{{$key}}"><i class="icofont-edit text-success"></i></button>
                                        <form action="{{route('admin.salary.destroy',$salary->id)}}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" onclick="return confirm('are you sure to delete ? ')" class="btn btn-outline-secondary mx-1 deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                        </form>
                                        <a href="{{route('admin.salary.download',$salary->id)}}" target="_blank" class="btn btn-outline-secondary"><i class="icofont-download text-success"></i></a>
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
                                                        <h6 align="center" style="border: 1px solid black; padding: 5px;">BASIC INFO</h6>
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
                                                        <h6 align="center" style="border: 1px solid black; padding: 5px;">PAYMENT DETAILS</h6>
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
                                                        <div class="col-sm-12">
                                                            <div class="input-group mb-3">
                                                                <span class="input-group-text">Bonus</span>
                                                                <input type="text" name="bonus_note" class="form-control" value="{{ $salary->bonus_note }}"  id="" placeholder="Bonus Note">
                                                                <input type="number" min="0" value="{{$salary->bonus}}"  name="bonus" class="form-control" id="" placeholder="example : 10000">
                                                            </div>
                                                        </div>
                                                        @if($salary->payment != '')
                                                        @php
                                                        $payment = json_decode($salary->payment);
                                                        @endphp
                                                        @foreach($salaryPaymentInputs as $paymentInput)
                                                            <div class="col-sm-6">
                                                                <label for="" class="form-label">{{ ucwords(str_replace('_',' ',$paymentInput->name)) }}</label>
                                                                <input type="number" min="0" value="{{ $payment->{$paymentInput->name} ?? 0 }}" name="{{$paymentInput->name}}" class="form-control" id="" placeholder="{{$paymentInput->placeholder}}">
                                                            </div>
                                                        @endforeach
                                                        @endif
                                                        <h6 align="center" style="border: 1px solid black; padding: 5px;">DEDUCTION DETAILS</h6>
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
                                                        @if($salary->deduct != '')
                                                            @php
                                                                $deduct = json_decode($salary->deduct);
                                                            @endphp
                                                            @foreach($salaryDeductInputs as $deductInput)
                                                                <div class="col-sm-6">
                                                                    <label for="" class="form-label">{{ ucwords(str_replace('_',' ',$deductInput->name)) }}</label>
                                                                    <input type="number" min="0" value="{{ $deduct->{$deductInput->name} ?? 0 }}" name="{{$deductInput->name}}" class="form-control" id="" placeholder="{{$deductInput->placeholder}}">
                                                                </div>
                                                            @endforeach
                                                        @endif
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
                            @php
                                $user_id = $salary->user_id;
                                $yearr = $salary->year;
                                $monthh = $salary->month;

                                    $attendancesForDay = \App\Models\Attendance::with('user')->where(function($query) use ($user_id, $yearr, $monthh) {
                                        $query->when($user_id, function($q) use ($user_id) {
                                            $q->where('user_id', $user_id);
                                        })->when($yearr, function($q) use ($yearr) {
                                            $q->where('year', $yearr);
                                        })->when($monthh, function($q) use ($monthh) {
                                            $q->where('month', $monthh);
                                        });
                                    })->first();
                            @endphp
                            <div class="modal fade" id="salaryShow{{$key}}" tabindex="-1"  aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold text-uppercase" id="depaddLabel"> SALARY VOUCHER FOR THE MONTH OF {{ date('F', mktime(0, 0, 0, $salary->month, 1)) }}  {{ $salary->year }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <p><small class="fw-bold" style="font-weight: bold">NAME </small> : <small> {{$salary->user->name}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">DESIGNATION </small> : <small> {{$salary->user->userInfo->designations->name}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">DEPARTMENT </small> : <small> {{$salary->user->userInfo->designations->department->department_name}}</small></p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p><small class="fw-bold" style="font-weight: bold">ID </small> : <small> {{$salary->user->userInfo->employee_id}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">TOTAL ATTENDENCE </small> : <small> {{ $attendancesForDay->attend ?? 0}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">TOTAL WORKING DAY </small> : <small> {{ $attendancesForDay->working_day ?? 0}} </small></p>
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 border p-2">
                                                                    <h6 class="text-center fw-bold">PAYMENT DETAILS</h6>
                                                                    <hr>
                                                                    <p><small class="fw-bold" style="font-weight: bold">BASIC SALARY </small> : <small> {{$salary->basic_salary}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">HOUSE RENT </small> : <small> {{$salary->house_rent}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">MEDICAL ALLOWANCE </small> : <small> {{$salary->medical_allowance}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">CONVEYANCE ALLOWANCE </small> : <small> {{$salary->conveyance_allowance}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">OTHERS </small> : <small> {{$salary->others}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">MOBILE ALLOWANCE </small> : <small> {{$salary->mobile_allowance}} </small></p>
                                                                    @php
                                                                        $pay = 0 ;
                                                                            if($salary->payment != ''){
                                                                                $paymentSalary = json_decode($salary->payment);
                                                                            foreach($salaryPaymentInputs as $paymentInput){
                                                                                $pay = $pay + ($paymentSalary->{$paymentInput->name} ?? 0);
                                                                            }
                                                                            }

                                                                    @endphp
                                                                    @if($salary->payment != '')
                                                                        @php
                                                                            $paymentSalary = json_decode($salary->payment);
                                                                        @endphp
                                                                        @foreach($salaryPaymentInputs as $paymentInput)
                                                                            <p><small class="fw-bold text-uppercase" style="font-weight: bold">{{ ucwords(str_replace('_',' ',$paymentInput->name)) }} </small> : <small> {{ $paymentSalary->{$paymentInput->name} ?? 0 }} </small></p>
                                                                        @endforeach
                                                                    @endif
                                                                    <hr>
                                                                    <p><small class="fw-bold" style="font-weight: bold">TOTAL PAY </small> : <small> {{ $allowance = ($pay + $salary->basic_salary + $salary->house_rent + $salary->medical_allowance + $salary->conveyance_allowance + $salary->others + $salary->mobile_allowance + $salary->bonus) }} </small></p>
                                                                </div>
                                                                <div class="col-md-6 border p-2">
                                                                    <h6 class="text-center fw-bold">DEDUCTION DETAILS</h6>
                                                                    <hr>
                                                                    <p><small class="fw-bold" style="font-weight: bold">MEAL DEDUCTION </small> : <small> {{$salary->meal_deduction}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">INCOME TAX </small> : <small> {{$salary->income_tax}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">OTHER DEDUCTON </small> : <small> {{$salary->other_deduction}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">ATTENDENCE DEDUCTION </small> : <small> {{$salary->attendance_deduction}}</small></p>
                                                                    @php
                                                                        $deduct = 0 ;
                                                                            if($salary->deduct != ''){
                                                                                $deducts = json_decode($salary->deduct);
                                                                                /*dd(gettype($deduct->expense));*/
                                                                                foreach($salaryDeductInputs as $deductsInput){
                                                                                    $deduct = $deduct + ($deducts->{$deductsInput->name} ?? 0);
                                                                                }
                                                                            }

                                                                    @endphp
                                                                    @if($salary->deduct != '')
                                                                        @php
                                                                            $deducts = json_decode($salary->deduct);
                                                                        @endphp
                                                                        @foreach($salaryDeductInputs as $deductInput)
                                                                            <p><small class="fw-bold text-uppercase" style="font-weight: bold">{{ ucwords(str_replace('_',' ',$deductInput->name)) }} </small> : <small> {{ $deducts->{$deductInput->name} ?? 0 }}</small></p>
                                                                        @endforeach
                                                                    @endif
                                                                    <br>
                                                                    <br>
                                                                    <br>
                                                                    <br class="mb-2">
                                                                    <hr>
                                                                    <p><small class="fw-bold" style="font-weight: bold">TOTAL DEDUCTION </small> : <small> {{ $deductions = ($deduct + $salary->meal_deduction + $salary->income_tax + $salary->other_deduction + $salary->attendance_deduction)}} </small></p>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            <div class="text-center">
                                                                <h6 class="fw-bold">NET TOTAL : {{ $net = $allowance - $deductions }}</h6>
                                                            </div>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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
                                <h6 align="center" style="border: 1px solid black; padding: 5px;">BASIC INFO</h6>
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
                                <h6 align="center" style="border: 1px solid black; padding: 5px;">PAYMENT DETAILS</h6>
                                <div class="col-sm-6">
                                    <label for="" class="form-label">Basic Salary <span class="text-danger">*</span></label>
                                    <input type="number" min="0" required name="basic_salary" class="form-control" id="" placeholder="example : 10000">
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label">House Rent</label>
                                    <input type="number" min="0"  name="house_rent" class="form-control" id="" placeholder="example : 10000">
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label">Medical Allowance</label>
                                    <input type="number" min="0"  name="medical_allowance" class="form-control" id="" placeholder="example : 10000">
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label">Conveyance Allowance</label>
                                    <input type="number" min="0"  name="conveyance_allowance" class="form-control" id="" placeholder="example : 10000">
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label">Others</label>
                                    <input type="number" min="0"  name="others" class="form-control" id="" placeholder="example : 10000">
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label">Mobile Allowance</label>
                                    <input type="number" min="0"  name="mobile_allowance" class="form-control" id="" placeholder="example : 10000">
                                </div>
                                <div class="col-sm-12">
                                    <div class="input-group mb-3">
                                        <span class="input-group-text" >Bonus</span>
                                        <input type="text" name="bonus_note"  class="form-control" placeholder="Bonus Note">
                                        <input type="number" min="0"  name="bonus" class="form-control" placeholder="Bonus Amount">
                                    </div>
                                </div>

                                @foreach($salaryPaymentInputs as $paymentInput)
                                    <div class="col-sm-6">
                                        <label for="" class="form-label">{{ ucwords(str_replace('_',' ',$paymentInput->name)) }}</label>
                                        <input type="number" min="0"  name="{{$paymentInput->name}}" class="form-control" id="" placeholder="{{$paymentInput->placeholder}}">
                                    </div>
                                @endforeach

                                <h6 align="center" style="border: 1px solid black; padding: 5px;">DEDUCTION DETAILS</h6>
                                <div class="col-sm-6">
                                    <label for="" class="form-label">Meal Deduction</label>
                                    <input type="number" min="0"  name="meal_deduction" class="form-control" id="" placeholder="example : 10000">
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label">Income Tax</label>
                                    <input type="number" min="0"  name="income_tax" class="form-control" id="" placeholder="example : 10000">
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label">Other Deduction</label>
                                    <input type="number" min="0"  name="other_deduction" class="form-control" id="" placeholder="example : 10000">
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label">Attendance Deduction</label>
                                    <input type="number" min="0"  name="attendance_deduction" class="form-control" id="" placeholder="example : 10000">
                                </div>
                                @foreach($salaryDeductInputs as $deductInput)
                                    <div class="col-sm-6">
                                        <label for="" class="form-label">{{ ucwords(str_replace('_',' ',$deductInput->name)) }}</label>
                                        <input type="number" min="0"  name="{{$deductInput->name}}" class="form-control" id="" placeholder="{{$deductInput->placeholder}}">
                                    </div>
                                @endforeach
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

