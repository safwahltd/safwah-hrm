@extends('admin.layout.app')
@section('title','Salary Payment Management')
@section('body')
    <style>
        .input-groups {
            display: none; /* Hide all input groups by default */
        }
    </style>
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Salary Payment Management</h3>
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
                <div class="col-sm-6 col-12 d-grid justify-content-end text-end my-2">
                    <form method="get" class="d-flex" action="{{route('admin.salary.payment.index')}}">
                        <select class="form-control-sm me-1" name="month" id="month" required>
                            <option {{ $month == 0 ? 'selected' : '' }} value="0">All</option>
                            @for ($i = 1; $i <= 12; $i++)
                                <option {{ $i == $month ? 'selected' : '' }} value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                            @endfor
                        </select>
                        <select class="form-control-sm me-1" name="year" id="year" required>
                            <option {{ $year == 0 ? 'selected' : '' }} value="0">All</option>
                            @for ($i = date('Y'); $i >= 2022; $i--)
                                <option {{ $i == $year ? 'selected' : '' }} value="{{ $i }}">{{ $i }}</option>
                            @endfor
                        </select>
                        <select class="form-control-sm me-1"  name="day" id="day">
                            <option value="">All Days</option>
                            @for($d = 1; $d <= 31; $d++)
                                <option value="{{ $d }}" {{ $d == $day ? 'selected' : '' }}>{{ $d }}</option>
                            @endfor
                        </select>
                        <button class="form-control-sm  m-1 text-white bg-success px-3"  type="submit">Filter</button>
                    </form>
                </div>
            </div>
            <div class="card mb-3">
                <div class="card-body table-responsive bg-dark-subtle">
                    <table id="basic-datatable" class="table table-bordered table-secondary border-bottom w-100" style="font-size: 13px;">
                        <thead>
                        <tr>
                            <th>SL</th>
                            <th>Employee</th>
                            <th>ID</th>
                            <th>Salary Date</th>
                            <th>Paid Amount</th>
                            <th>Payment Date</th>
                            <th>Payment Method</th>
                            <th>Reference</th>
                            <th>Action</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach($payments as $key => $payment)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $payment->user->name }}</td>
                                <td>{{ $payment->user->userInfo->employee_id }}</td>
                                <td>{{ date('F', mktime(0, 0, 0, $payment->salary->month, 1)) }}, {{ $payment->salary->year }}</td>
                                <td>{{ $payment->paid_amount }}</td>
                                <td>{{ \Illuminate\Support\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                                <td>{{ $payment->payment_method }}</td>
                                <td>{{ $payment->payment_reference }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#salaryShow{{$key}}"><i class="icofont-eye text-success"></i></button>
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#salaryEdit{{$key}}"><i class="icofont-edit text-success"></i></button>
                                        <form action="{{route('admin.salary.payment.destroy',$payment->id)}}" method="post">
                                            @csrf
                                            @method('PUT')
                                            <button type="submit" onclick="return confirm('are you sure to delete ? ')" class="btn btn-outline-secondary mx-1 deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                        </form>
                                        <a href="{{route('admin.salary.payment.download',$payment->salary->id)}}" target="_blank" class="btn btn-outline-secondary"><i class="icofont-download text-success"></i></a>
                                    </div>
                                </td>
                            </tr>
                            <div class="modal fade" id="salaryEdit{{$key}}" tabindex="-1"  aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold" id="depaddLabel"> Salary Edit</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <form action="{{route('admin.salary.payment.update',$payment->id)}}" method="post">
                                                @csrf
                                                @method('PUT')
                                                <div class="deadline-form">
                                                    <div class="row g-3 mb-3">
                                                        <div class="col-sm-6">
                                                            <label for="salary_id" class="form-label">Employee <span class="text-danger">*</span></label>
                                                            <select class="form-control" disabled id="" name="salary_id" required>
                                                                <option  selected value="">-- Select Employee --</option>
                                                                @foreach($salaries as $salary)
                                                                    <option {{ $payment->salary_id == $salary->id ? 'selected':''}}  value="{{ $salary->id }}">{{ $salary->user->name }} ({{$salary->user->userInfo->employee_id}})</option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6" id="">
                                                            <h5>Salary Details</h5>
                                                            <hr>
                                                            @php
                                                                $pay = 0 ;
                                                                    if($payment->salary->payment != ''){
                                                                        $paymentss = json_decode($payment->salary->payment);
                                                                    foreach($salaryPaymentInputs as $paymentInput){
                                                                        $pay = $pay + ($paymentss->{$paymentInput->name} ?? 0);
                                                                    }
                                                                    }

                                                            @endphp
                                                            @php
                                                                $deduct = 0 ;
                                                                    if($payment->salary->deduct != ''){
                                                                        $deducts = json_decode($payment->salary->deduct);
                                                                        /*dd(gettype($deduct->expense));*/
                                                                        foreach($salaryDeductInputs as $deductsInput){
                                                                            $deduct = $deduct + ($deducts->{$deductsInput->name} ?? 0);
                                                                        }
                                                                    }
                                                            @endphp
                                                            <p><strong>Total Pay:</strong> <span id="">{{ $allowance = ($pay + $payment->salary->basic_salary + $payment->salary->house_rent + $payment->salary->medical_allowance + $payment->salary->conveyance_allowance + $payment->salary->others + $payment->salary->mobile_allowance + $payment->salary->bonus) }}</span></p>
                                                            <p><strong>Total Deduction:</strong> <span id="">{{ $deductions = ($deduct + $payment->salary->meal_deduction + $payment->salary->income_tax + $payment->salary->other_deduction + $payment->salary->attendance_deduction)}}</span></p>
                                                            <p><strong>Net Pay:</strong> <span id="">{{ $allowance - $deductions }}</span></p>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="" class="form-label">Paid Amount</label>
                                                            <input type="number" name="paid_amount" class="form-control" value="{{$payment->paid_amount}}" placeholder="example : 10000">
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="" class="form-label">Payment Date</label>
                                                            <input type="date" name="payment_date" value="{{$payment->payment_date}}" class="form-control" >
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="status" class="form-label">payment_method</label>
                                                            <select class="form-control" name="payment_method" id="status">
                                                                <option {{$payment->payment_method == 'cash' ? 'selected':''}} value="cash">Cash</option>
                                                                <option {{$payment->payment_method == 'bank' ? 'selected':''}} value="bank">Bank</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-sm-6">
                                                            <label for="" class="form-label">Payment Reference</label>
                                                            <input type="text" name="payment_reference" value="{{$payment->payment_reference}}" class="form-control" id="">
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
                                $user_id = $payment->salary->user_id;
                                $yearr = $payment->salary->year;
                                $monthh = $payment->salary->month;
                                $daysInaMonth = \Illuminate\Support\Carbon::create($yearr, $monthh, 1)->daysInMonth;
                                $startDate = \Illuminate\Support\Carbon::create($yearr, $monthh, 1);
                                $endDate = $startDate->copy()->endOfMonth();
                                $allDates = [];
                                for ($date = $startDate; $date <= $endDate; $date->addDay()) {
                                    $allDates[] = $date->toDateString(); // Store the dates in an array
                                }
                                for ($day = 1; $day <= $daysInaMonth; $day++) {
                                    $attendancesForDay = \App\Models\Attendance::with('user')->where(function($query) use ($user_id, $yearr, $monthh, $day) {
                                        $query->when($user_id, function($q) use ($user_id) {
                                            $q->where('user_id', $user_id);
                                        })->when($yearr, function($q) use ($yearr) {
                                            $q->where('year', $yearr);
                                        })->when($monthh, function($q) use ($monthh) {
                                            $q->where('month', $monthh);
                                        });
                                    })->get();

                                    $attendanceData = collect($allDates)->mapWithKeys(function ($date) use ($attendancesForDay) {
                                        return [$date => $attendancesForDay->get($date, collect())];
                                    });
                                }

                            @endphp
                            <div class="modal fade" id="salaryShow{{$key}}" tabindex="-1"  aria-hidden="true">
                                <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title fw-bold text-uppercase" id="depaddLabel"> SALARY VOUCHER FOR THE MONTH OF {{ date('F', mktime(0, 0, 0, $payment->salary->month, 1)) }}  {{ $payment->salary->year }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="row">
                                                                <div class="col-md-6">
                                                                    <p><small class="fw-bold" style="font-weight: bold">NAME </small> : <small> {{$payment->salary->user->name}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">DESIGNATION </small> : <small> {{$payment->salary->user->userInfo->designations->name}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">DEPARTMENT </small> : <small> {{$payment->salary->user->userInfo->designations->department->department_name}}</small></p>
                                                                </div>
                                                                <div class="col-md-6">
                                                                    <p><small class="fw-bold" style="font-weight: bold">ID </small> : <small> {{$payment->salary->user->userInfo->employee_id}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">TOTAL ATTENDENCE </small> : <small> {{$attendancesForDay->sum('attend')}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">TOTAL WORKING DAY </small> : <small>  {{$attendancesForDay->sum('working_day')}} </small></p>
                                                                </div>

                                                            </div>
                                                            <div class="row">
                                                                <div class="col-md-6 border p-2">
                                                                    <h6 class="text-center fw-bold">PAYMENT DETAILS</h6>
                                                                    <hr>
                                                                    <p><small class="fw-bold" style="font-weight: bold">BASIC SALARY </small> : <small> {{$payment->salary->basic_salary}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">HOUSE RENT </small> : <small> {{$payment->salary->house_rent}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">MEDICAL ALLOWANCE </small> : <small> {{$payment->salary->medical_allowance}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">CONVEYANCE ALLOWANCE </small> : <small> {{$payment->salary->conveyance_allowance}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">OTHERS </small> : <small> {{$payment->salary->others}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">MOBILE ALLOWANCE </small> : <small> {{$payment->salary->mobile_allowance}} </small></p>
                                                                    @php
                                                                        $pay = 0 ;
                                                                            if($payment->salary->payment != ''){
                                                                                $paymentSalary = json_decode($payment->salary->payment);
                                                                            foreach($salaryPaymentInputs as $paymentInput){
                                                                                $pay = $pay + ($paymentSalary->{$paymentInput->name} ?? 0);
                                                                            }
                                                                            }

                                                                    @endphp
                                                                    @if($payment->salary->payment != '')
                                                                        @php
                                                                            $paymentSalary = json_decode($payment->salary->payment);
                                                                        @endphp
                                                                        @foreach($salaryPaymentInputs as $paymentInput)
                                                                            <p><small class="fw-bold text-uppercase" style="font-weight: bold">{{ ucwords(str_replace('_',' ',$paymentInput->name)) }} </small> : <small> {{ $paymentSalary->{$paymentInput->name} ?? 0 }} </small></p>
                                                                        @endforeach
                                                                    @endif
                                                                    <hr>
                                                                    <p><small class="fw-bold" style="font-weight: bold">TOTAL PAY </small> : <small> {{ $allowance = ($pay + $payment->salary->basic_salary + $payment->salary->house_rent + $payment->salary->medical_allowance + $payment->salary->conveyance_allowance + $payment->salary->others + $payment->salary->mobile_allowance + $payment->salary->bonus) }} </small></p>
                                                                </div>
                                                                <div class="col-md-6 border p-2">
                                                                    <h6 class="text-center fw-bold">DEDUCTION DETAILS</h6>
                                                                    <hr>
                                                                    <p><small class="fw-bold" style="font-weight: bold">MEAL DEDUCTION </small> : <small> {{$payment->salary->meal_deduction}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">INCOME TAX </small> : <small> {{$payment->salary->income_tax}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">OTHER DEDUCTON </small> : <small> {{$payment->salary->other_deduction}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">ATTENDENCE DEDUCTION </small> : <small> {{$payment->salary->attendance_deduction}}</small></p>
                                                                    @php
                                                                        $deduct = 0 ;
                                                                            if($payment->salary->deduct != ''){
                                                                                $deducts = json_decode($payment->salary->deduct);
                                                                                /*dd(gettype($deduct->expense));*/
                                                                                foreach($salaryDeductInputs as $deductsInput){
                                                                                    $deduct = $deduct + ($deducts->{$deductsInput->name} ?? 0);
                                                                                }
                                                                            }

                                                                    @endphp
                                                                    @if($payment->salary->deduct != '')
                                                                        @php
                                                                            $deducts = json_decode($payment->salary->deduct);
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
                                                                    <p><small class="fw-bold" style="font-weight: bold">TOTAL DEDUCTION </small> : <small> {{ $deductions = ($deduct + $payment->salary->meal_deduction + $payment->salary->income_tax + $payment->salary->other_deduction + $payment->salary->attendance_deduction)}} </small></p>
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
                        {{$payments->links()}}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->

    <!-- Add Payment-->
    <div class="modal fade" id="salaryAdd" tabindex="-1"  aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-lg modal-dialog-scrollable">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title  fw-bold" id="depaddLabel"> Salary Payment Add</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>

                <div class="modal-body">
                    <form action="{{route('admin.salary.payment.store')}}" method="post">
                        @csrf
                        <div class="deadline-form">
                            <div class="row g-3 mb-3">
                                <div class="col-sm-6">
                                    <label for="monthAdd" class="form-label">Month <span class="text-danger">*</span></label>
                                    <select class="form-control" name="month" id="monthAdd" required>
                                        @for ($i = 1; $i <= 12; $i++)
                                            <option value="{{ $i }}">{{ date('F', mktime(0, 0, 0, $i, 1)) }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="yearAdd" class="form-label">Year <span class="text-danger">*</span></label>
                                    <select class="form-control" name="year" id="yearAdd" required>
                                        @for ($i = date('Y'); $i >= 2022; $i--)
                                            <option value="{{ $i }}">{{ $i }}</option>
                                        @endfor
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="salary_id" class="form-label">Employee <span class="text-danger">*</span></label>
                                    <select class="form-control" id="salary_id" name="salary_id" required>
                                        <option disabled selected value="">-- Select Employee --</option>
                                    </select>
                                </div>
                                <div class="col-sm-6" id="salary-details" style="display: none;">
                                    <h5>Salary Details</h5>
                                    <hr>
                                    <p><strong>Total Pay:</strong> <span id="total_pay"></span></p>
                                    <p><strong>Total Deduction:</strong> <span id="deductions"></span></p>
                                    <p><strong>Net Pay:</strong> <input name="netPay" class="border-0" value="" readonly id="total_payable"></p>
                                </div>

                                <div class="col-sm-6">
                                    <label for="" class="form-label">Paid Amount</label>
                                    <input type="number" name="paid_amount" min="0" value="" max="" class="form-control" id="PaidAmountAdd" placeholder="example : 10000">
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label">Payment Date</label>
                                    <input type="date" name="payment_date" class="form-control" id="">
                                </div>
                                <div class="col-sm-6">
                                    <label for="status" class="form-label">payment_method</label>
                                    <select class="form-control" name="payment_method" id="status">
                                        <option selected value="cash">Cash</option>
                                        <option value="bank">Bank</option>
                                    </select>
                                </div>
                                <div class="col-sm-6">
                                    <label for="" class="form-label">Payment Reference</label>
                                    <input type="text" name="payment_reference" class="form-control" id="">
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
@push('js')
    <script>
        $(document).ready(function() {
            $('#salary_id').change(function() {
                var salaryId = $(this).val();
                if (salaryId) {
                    $.ajax({
                        url: 'get-salary-details/' + salaryId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#salary-details').show();
                            console.log(data[0].basic_salary);
                            // Populate the salary details
                            var allowance = parseFloat(data[0].basic_salary) + parseFloat(data[0].house_rent) + parseFloat(data[0].medical_allowance) + parseFloat(data[0].conveyance_allowance) + parseFloat(data[0].others) + parseFloat(data[0].mobile_allowance) + parseFloat(data[0].bonus) + parseFloat(data[1]);
                            var deduction = parseFloat(data[0].meal_deduction) + parseFloat(data[0].income_tax) + parseFloat(data[0].other_deduction) + parseFloat(data[0].attendance_deduction) + parseFloat(data[2]);
                            $('#total_pay').text(allowance ? allowance : 0.00);
                            $('#deductions').text(deduction ? deduction : 0.00);
                            var totalPayable = (parseFloat(allowance) - parseFloat(deduction)).toFixed(2);
                            $('#total_payable').val(totalPayable);
                            // $('#PaidAmountAdd').max(totalPayable);
                            $('#PaidAmountAdd').val(totalPayable);
                        },
                        error: function() {

                        }
                    });
                } else {
                    $('#salary-details').hide();
                }
            });
        });
    </script>
    <script>
        $(document).ready(function () {
            $('#monthAdd, #yearAdd').on('change', function () {
                var month = $('#monthAdd').val();
                var year = $('#yearAdd').val();
                console.log(month,year);

                if (month && year) {
                    $.ajax({
                        url: "{{ route('salaries.getEmployees') }}",
                        type: "GET",
                        data: { month: month, year: year },
                        success: function (data) {

                            $('#salary_id').empty();
                            $('#salary_id').append('<option value="">Select Employee</option>');

                            // Populate the employee dropdown
                            $.each(data, function (key, employee) {
                                $('#salary_id').append('<option value="' + employee.id + '">' + employee.user.name + ' (' + employee.user_info.employee_id + ') ' + '</option>');
                            });
                        }
                    });
                } else {
                    $('#salary_id').empty();
                    $('#salary_id').append('<option value="">Select Employee</option>');
                }
            });
        });
    </script>
@endpush

