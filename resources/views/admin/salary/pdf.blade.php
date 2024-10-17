<!DOCTYPE html>
<html>
<head>
    <title>Payment Slip</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid black;
            padding: 4px;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
    <style>
        /* Prevent page breaking inside elements */
        .page-break-inside-avoid {
            page-break-inside: avoid;
        }

        /* Force page break before this element */
        .page-break-before {
            page-break-before: always;
        }
        .table>:not(caption)>*>* {
            padding: .4rem .4rem;
        }
        /* Force page break after this element */
        .page-break-after {
            page-break-after: always;
        }
        @media print {
            .page-break {
                page-break-before: always;
            }
            .no-page-break {
                page-break-inside: avoid;
            }
        }
        .net-total-column {
            text-align: center;
            border: none;
        }
        .net-total-column-row td {
            border-bottom: 1px solid black;
        }
    </style>
</head>
<body class="" style="">

<div class="page-break-inside-avoid">
    <section class="">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-8">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="">
                                <img class="img-responsive" width="400" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('admin/assets/Safwah-Limited-logo.webp'))) }}" alt="">
                            </div>
                            <p>Confidence Center, Building-2, 10B, Shahjadpur, Gulshan-2, Dhaka, Bangladesh</p>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 style="font-size: 15px; padding: 5px; border: 1px solid black; font-weight: bold; margin-bottom: 25px;" align="center">EMPLOYEE SALARY PAYMENT SLIP</h5>
                                    <table class="table table-striped table-bordered" style="border: 1px solid black">
                                        <thead class="text-center">
                                        <th colspan="2" class="p-2">
                                            <small class="p-0 fw-bold mx-0" style="font-size: 15px">Employee Copy</small>
                                        </th>
                                        </thead>
                                        <tbody >
                                        <tr>
                                            <td><small class="fw-bold" style="font-weight: bold">NAME </small></td>
                                            <td><small> {{$salary->user->name}}</small></td>
                                        </tr>
                                        <tr>
                                            <td><small class="fw-bold" style="font-weight: bold">DESIGNATION</small></td>
                                            <td><small> {{$salary->user->userInfo->designations->name}}</small></td>
                                        </tr>
                                        <tr>
                                            <td><small class="fw-bold" style="font-weight: bold">DEPARTMENT</small></td>
                                            <td><small> {{$salary->user->userInfo->designations->department->department_name}}</small></td>
                                        </tr>
                                        <tr>
                                            <td><small class="fw-bold" style="font-weight: bold">ID</small></td>
                                            <td><small> {{$salary->user->userInfo->employee_id}}</small></td>
                                        </tr>
                                        <tr>
                                            <td><small class="fw-bold" style="font-weight: bold">TOTAL ATTENDENCE</small></td>
                                            <td><small> {{$totalAttendance}}</small></td>
                                        </tr>
                                        <tr>
                                            <td><small class="fw-bold" style="font-weight: bold">TOTAL WORKING DAY</small></td>
                                            <td><small> 26 </small></td>
                                        </tr>

                                        </tbody>
                                    </table>
                                    <h5 style="font-size: 15px; padding: 5px; border: 1px solid black; margin-bottom: 25px; text-transform: uppercase;" align="center">SALARY VOUCHER FOR THE MONTH OF {{ date('F', mktime(0, 0, 0, $salary->month, 1)) }}  {{ $salary->year }}</h5>
                                    <table  style="border: 1px solid black; margin-top: 12px">
                                        <tr>
                                            <th><small class="p-0 fw-bold mx-0">PAYMENT DETAILS</small></th>
                                            <th><small class="p-0 fw-bold mx-0">AMOUNT (BDT)</small></th>
                                            <th><small class="p-0 fw-bold mx-0">DEDUCTION DETAILS</small></th>
                                            <th><small class="p-0 fw-bold mx-0">AMOUNT (BDT)</small></th>
                                            <th><small class="p-0 fw-bold mx-0">NET PAY (BDT)</small></th>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 14px;">BASIC SALARY</td>
                                            <td style="font-size: 14px;">{{$salary->basic_salary}}</td>
                                            <td style="font-size: 14px;">MEAL DEDUCTION</td>
                                            <td style="font-size: 14px;">{{$salary->meal_deduction}}</td>
                                            <td style="border-bottom: none;"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 14px;">HOUSE RENT</td>
                                            <td style="font-size: 14px;">{{$salary->house_rent}}</td>
                                            <td style="font-size: 14px;">INCOME TAX</td>
                                            <td style="font-size: 14px;">{{$salary->income_tax}}</td>
                                            <td class="net-total-column"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 14px;">MEDICAL ALLOWANCE</td>
                                            <td style="font-size: 14px;">{{$salary->medical_allowance}}</td>
                                            <td style="font-size: 14px;">OTHER DEDUCTON</td>
                                            <td style="font-size: 14px;">{{$salary->other_deduction}}</td>
                                            <td class="net-total-column"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 14px;">CONVEYANCE ALLOWANCE</td>
                                            <td style="font-size: 14px;">{{$salary->conveyance_allowance}}</td>
                                            <td style="font-size: 14px;">ATTENDENCE DEDUCTION</td>
                                            <td style="font-size: 14px;">{{$salary->attendance_deduction}}</td>
                                            <td class="net-total-column">{{$net}}</td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 14px;">OTHERS</td>
                                            <td style="font-size: 14px;">{{$salary->others}}</td>
                                            <td style="font-size: 14px;"></td>
                                            <td style="font-size: 14px;"></td>
                                            <td class="net-total-column"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 14px;">MOBILE ALLOWANCE</td>
                                            <td style="font-size: 14px;">{{$salary->mobile_allowance}}</td>
                                            <td style="font-size: 14px;"></td>
                                            <td style="font-size: 14px;"></td>
                                            <td class="net-total-column"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-size: 14px;">BONUS</td>
                                            <td style="font-size: 14px;">{{$salary->bonus}}</td>
                                            <td style="font-size: 14px;"></td>
                                            <td style="font-size: 14px;"></td>
                                            <td class="net-total-column"></td>
                                        </tr>
                                        <tr>
                                            <td style="font-weight: bold;font-size: 14px;">TOTAL PAY</td>
                                            <td style="font-weight: bold;font-size: 14px;">{{ $allowance = ($salary->basic_salary + $salary->house_rent + $salary->medical_allowance + $salary->conveyance_allowance + $salary->others + $salary->mobile_allowance + $salary->bonus) }}</td>
                                            <td style="font-weight: bold;font-size: 14px;">TOTAL DEDUCTION</td>
                                            <td style="font-weight: bold;font-size: 14px;">{{ $deductions = ($salary->meal_deduction + $salary->income_tax + $salary->other_deduction + $salary->attendance_deduction)}}</td>
                                            <td style="font-weight: bold;font-size: 14px;"><span id="net-total">{{ $net = $allowance - $deductions }}</span> </td>
                                        </tr>
                                    </table>
                                    <p style="font-size: 15px; padding: 5px; border: 1px solid black; margin-top: 10px; text-transform: uppercase;">In Words : {{$netWords}}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</body>
</html>
