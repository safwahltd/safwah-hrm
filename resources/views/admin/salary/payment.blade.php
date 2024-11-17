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
                    <table id="basic-datatable" class="table table-bordered text-nowrap table-secondary key-buttons border-bottom w-100">
                        <thead>
                        <tr>
                            <th>Employee</th>
                            <th>ID</th>
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
                                <td>{{ $payment->user->userInfo->employee_id }}</td>
                                <td>{{ $payment->paid_amount }}</td>
                                <td>{{ \Illuminate\Support\Carbon::parse($payment->payment_date)->format('d M Y') }}</td>
                                <td>{{ $payment->payment_method }}</td>
                                <td>{{ $payment->payment_reference }}</td>
                                <td>
                                    <div class="btn-group" role="group" aria-label="Basic outlined example">
                                        <button type="button" class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#salaryEdit{{$key}}"><i class="icofont-edit text-success"></i></button>
                                        <form action="{{route('admin.salary.payment.destroy',$payment->id)}}" method="post">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" onclick="return confirm('are you sure to delete ? ')" class="btn btn-outline-secondary mx-1 deleterow"><i class="icofont-ui-delete text-danger"></i></button>
                                        </form>
                                        <a href="{{--{{route('admin.salary.payment.download',$payment->id)}}--}}"  class="btn btn-outline-secondary"><i class="icofont-download text-success"></i></a>
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
                                                            <p><strong>Total Pay:</strong> <span id="">{{ $allowance = ($payment->salary->basic_salary + $payment->salary->house_rent + $payment->salary->medical_allowance + $payment->salary->conveyance_allowance + $payment->salary->others + $payment->salary->mobile_allowance + $payment->salary->bonus) }}</span></p>
                                                            <p><strong>Total Deduction:</strong> <span id="">{{ $deductions = ($payment->salary->meal_deduction + $payment->salary->income_tax + $payment->salary->other_deduction + $payment->salary->attendance_deduction)}}</span></p>
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
                    <h5 class="modal-title  fw-bold" id="depaddLabel"> Salary Add</h5>
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
                                    <p><strong>Net Pay:</strong> <span id="total_payable"></span></p>
                                </div>

                                <div class="col-sm-6">
                                    <label for="" class="form-label">Paid Amount</label>
                                    <input type="number" name="paid_amount" class="form-control" id="" placeholder="example : 10000">
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

