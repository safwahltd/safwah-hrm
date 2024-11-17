@extends('admin.layout.app')
@section('title','Salary')
@section('body')
    <style>
        .input-groups {
            display: none; /* Hide all input groups by default */
        }
    </style>
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Salary</h3>
                {{--<div class="col-auto d-flex w-sm-100">
                    <button type="button" class="btn btn-dark btn-set-task w-sm-100" data-bs-toggle="modal" data-bs-target="#salaryAdd"><i class="icofont-plus-circle me-2 fs-6"></i>Add</button>
                </div>--}}
            </div>
        </div>
    </div>
    <!-- Row end  -->

    <div class="row clearfix g-3">
        <div class="col-sm-12">
            <div class="row filter-row justify-content-end">
                <div class=" text-end my-2">
                    <form method="get" action="{{route('employee.salary.index')}}">
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
            <div class="card mb-3">
                <div class="card-body bg-dark-subtle table-responsive">
                    <table id="" class="table table-bordered text-nowrap table-secondary key-buttons border-bottom w-100">
                        <thead>
                        <tr>
                            <th>Employee</th>
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
                                <td>{{ $payment->user->name }}</td>
                                <td>{{ $payment->paid_amount }}</td>
                                <td>{{ $payment->payment_date }}</td>
                                <td>{{ $payment->payment_method }}</td>
                                <td>{{ $payment->payment_reference }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#salaryShow{{$key}}"><i class="icofont-eye text-success"></i></button>
                                        <form action="{{route('admin.salary.payment.destroy',$payment->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('are you sure to delete ? ')" class="btn btn-outline-secondary mx-1 deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                        </form>
                                        <a href="{{route('admin.salary.payment.download',$payment->salary->id)}}"  class="btn btn-outline-secondary"><i class="icofont-download text-success"></i></a>
                                    </div>
                                </td>
                            </tr>
                            @php
                                $totalAttendance = \App\Models\Attendance::where('user_id', $payment->salary->user_id)
                                ->whereMonth('clock_in', $payment->salary->month)
                                ->whereYear('clock_in', $payment->salary->year)
                                ->count();
            $net = ($payment->salary->basic_salary + $payment->salary->house_rent + $payment->salary->medical_allowance + $payment->salary->conveyance_allowance + $payment->salary->others + $payment->salary->mobile_allowance + $payment->salary->bonus) - ($payment->salary->meal_deduction + $payment->salary->income_tax + $payment->salary->other_deduction + $payment->salary->attendance_deduction);
            /*$netWords = $this->numberToWords($net);*/

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
                                                                    <p><small class="fw-bold" style="font-weight: bold">TOTAL ATTENDENCE </small> : <small> {{$totalAttendance}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">TOTAL WORKING DAY </small> : <small> 26 </small></p>
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
                                                                    <p><small class="fw-bold" style="font-weight: bold">BONUS </small> : <small> {{$payment->salary->bonus}} </small></p>
                                                                    <hr>
                                                                    <p><small class="fw-bold" style="font-weight: bold">TOTAL PAY </small> : <small> {{ $allowance = ($payment->salary->basic_salary + $payment->salary->house_rent + $payment->salary->medical_allowance + $payment->salary->conveyance_allowance + $payment->salary->others + $payment->salary->mobile_allowance + $payment->salary->bonus) }} </small></p>
                                                                </div>
                                                                <div class="col-md-6 border p-2">
                                                                    <h6 class="text-center fw-bold">DEDUCTION DETAILS</h6>
                                                                    <hr>
                                                                    <p><small class="fw-bold" style="font-weight: bold">MEAL DEDUCTION </small> : <small> {{$payment->salary->meal_deduction}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">INCOME TAX </small> : <small> {{$payment->salary->income_tax}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">OTHER DEDUCTON </small> : <small> {{$payment->salary->other_deduction}}</small></p>
                                                                    <p><small class="fw-bold" style="font-weight: bold">ATTENDENCE DEDUCTION </small> : <small> {{$payment->salary->attendance_deduction}}</small></p>
                                                                    <br>
                                                                    <br>
                                                                    <br>
                                                                    <br class="mb-2">
                                                                    <hr>
                                                                    <p><small class="fw-bold" style="font-weight: bold">TOTAL DEDUCTION </small> : <small> {{ $deductions = ($payment->salary->meal_deduction + $payment->salary->income_tax + $payment->salary->other_deduction + $payment->salary->attendance_deduction)}} </small></p>
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
@endsection
@push('js')
    <script>
        $(document).ready(function() {
            $('#salary_id').change(function() {
                console.log('click');
                var salaryId = $(this).val();
                if (salaryId) {
                    $.ajax({
                        url: 'get-salary-details/' + salaryId,
                        type: 'GET',
                        dataType: 'json',
                        success: function(data) {
                            $('#salary-details').show();
                            // Populate the salary details
                            var allowance = parseFloat(data.basic_salary) + parseFloat(data.house_rent) + parseFloat(data.medical_allowance) + parseFloat(data.conveyance_allowance) + parseFloat(data.others) + parseFloat(data.mobile_allowance) + parseFloat(data.bonus);
                            var deduction = parseFloat(data.meal_deduction) + parseFloat(data.income_tax) + parseFloat(data.other_deduction) + parseFloat(data.attendance_deduction);
                            $('#total_pay').text(allowance ? allowance : 0.00);
                            $('#deductions').text(deduction ? deduction : 0.00);
                            var totalPayable = (parseFloat(allowance) - parseFloat(deduction)).toFixed(2);
                            $('#total_payable').text(totalPayable);
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
            $('#month, #year').on('change', function () {
                var month = $('#month').val();
                var year = $('#year').val();

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

