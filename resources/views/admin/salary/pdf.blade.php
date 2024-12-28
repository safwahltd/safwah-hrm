<!DOCTYPE html>
<html>
<head>
    <title>{{\Illuminate\Support\Facades\Request::route()->getName() == 'admin.salary.download' ? 'Salary':'Payment'}} Slip</title>

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
        * {
            font-size: 11px;
        }

        .table {
            display: table;
            width: 100%; /* Optional */
            border-collapse: collapse; /* Optional */
        }

        .table-row {
            display: table-row;
        }

        .table-cell {
            display: table-cell;
            border: 1px solid black;
            padding: 10px;
            text-align: left; /* Adjust alignment as needed */
        }

        .table-cell:first-child {
            font-weight: bold; /* Example: Highlight the first cell in a row */
        }

        .table-row:nth-child(even) {
            background-color: #f9f9f9; /* Add zebra-striping for rows */
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
    <style>
        /* Styling the container row */
        .row {
            display: flex; /* Use flexbox for layout */
            justify-content: space-between; /* Space out columns */
            align-items: flex-start; /* Align columns at the top */
        }

        .column {
            flex: 1;
            text-align: center;
            border-collapse: collapse;/* Center align content */
        }

        /* Styling headers */
        .header {
            font-weight: bold;
            font-size: 10px;
            margin-bottom: 5px;
        }

        /* Styling amount text */
        .amount {
            font-size: 10px;
            color: #333;
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
                        <div class="col-6">
                            <div class="">
                                <img class="img-responsive" width="200" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path($setting->logo))) }}" alt="">
                            </div>
                        </div>

                        <div class="col-md-12" style="margin-top: 10px">
                            <div class="row">
                                <div class="col-md-12">
                                    <h5 style="font-size: 13px; padding: 5px; border: 1px solid black; font-weight: bold; margin-bottom: 25px;" align="center">EMPLOYEE {{\Illuminate\Support\Facades\Request::route()->getName() == 'admin.salary.download' ? 'SALARY':'SALARY PAYMENT'}} SLIP</h5>
                                    <table class="table table-striped table-bordered" style="border: 1px solid black;">
                                        <thead class="text-center">
                                            <th colspan="4" class="p-2">
                                                <small class="p-0 fw-bold mx-0" style="font-size: 12px; font-weight: bold; text-transform: uppercase">Employee Information</small>
                                            </th>
                                        </thead>
                                        <tbody>

                                        <tr>
                                            <td style="text-transform: uppercase"><small class="fw-bold" style="font-weight: bold">NAME </small></td>
                                            <td style="text-transform: uppercase"><small> {{$salary->user->name ?? '-'}}</small></td>
                                            <td style="text-transform: uppercase"><small style="font-weight: bold"> DESIGNATION</small></td>
                                            <td style="text-transform: uppercase"><small> {{$salary->user->userInfo->designations->name ?? '-'}}</small></td>
                                        </tr>
                                        <tr>
                                            <td><small class="fw-bold" style="font-weight: bold">ID</small></td>
                                            <td><small> {{$salary->user->userInfo->employee_id ?? '-'}}</small></td>
                                            <td><small class="fw-bold" style="font-weight: bold">DEPARTMENT</small></td>
                                            <td style="text-transform: uppercase"><small> {{$salary->user->userInfo->designations->department->department_name ?? '-'}}</small></td>
                                        </tr>
                                        <tr>
                                            <td><small class="fw-bold" style="font-weight: bold">TOTAL ATTENDENCE</small></td>
                                            <td><small> {{ $totalAttendance->attend ?? 0 }}</small></td>
                                            <td><small class="fw-bold" style="font-weight: bold">TOTAL WORKING DAY</small></td>
                                            <td><small> {{ $totalAttendance->working_day ?? 0 }} </small></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <h5 style="font-size: 12px; padding: 5px; border: 1px solid black; margin-bottom: 25px; text-transform: uppercase;" align="center">SALARY VOUCHER FOR THE MONTH OF {{ date('F', mktime(0, 0, 0, $salary->month, 1)) }}  {{ $salary->year }}</h5>
                                    <table  style="/*border: 1px solid black;*/ margin-top: 12px;">
                                        <tr align="center">
                                            <th style=" width: 250px;"><small class="p-0 fw-bold mx-0" style="font-weight: bold">PAYMENT DETAILS</small></th>
                                            <th style=" width: 250px;"><small class="p-0 fw-bold mx-0" style="font-weight: bold">DEDUCTION DETAILS</small></th>
                                            <th style=" width: 100px;"><small class="p-0 fw-bold mx-0" style="font-weight: bold">{{\Illuminate\Support\Facades\Request::route()->getName() == 'admin.salary.download' ? 'NET TOTAL':'PAID AMOUNT'}} (BDT)</small></th>
                                        </tr>
                                        <tr style="border: none;">
                                            <td style="padding: 0; border: none;">
                                                <table style="border-collapse: collapse">
                                                    <tr style="border-top: none;  border-collapse: collapse">
                                                        <td style="width: 150px; border-top: none;">BASIC SALARY</td>
                                                        <td align="center" style="width: 70px; border-top: none;">{{$salary->basic_salary ?? 0}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>HOUSE RENT</td>
                                                        <td align="center">{{$salary->house_rent ?? 0}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>MEDICAL ALLOWANCE</td>
                                                        <td align="center">{{$salary->medical_allowance ?? 0}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>CONVEYANCE ALLOWANCE</td>
                                                        <td align="center">{{$salary->conveyance_allowance ?? 0}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>OTHERS</td>
                                                        <td align="center">{{$salary->others ?? 0}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>MOBILE ALLOWANCE</td>
                                                        <td align="center">{{$salary->mobile_allowance ?? 0}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td>BONUS @if($salary->bonus_note) <span style="text-transform: uppercase">({{$salary->bonus_note ?? '-'}})</span> @endif</td>
                                                        <td align="center">{{$salary->bonus ?? 0}}</td>
                                                    </tr>
                                                    @if($salary->payment != '')
                                                        @php
                                                            $payment = json_decode($salary->payment);
                                                        @endphp
                                                        @foreach($salaryPaymentInputs as $paymentInput)
                                                            @if(!empty($payment->{$paymentInput->name}))
                                                            <tr>
                                                                <td style="text-transform: uppercase">{{ ucwords(str_replace('_',' ',$paymentInput->name)) }}</td>
                                                                <td align="center">{{ $payment->{$paymentInput->name} ?? 0 }}</td>
                                                            </tr>
                                                            @endif
                                                        @endforeach
                                                    @endif

                                                </table>
                                            </td>
                                            <td style="padding: 0; width: 100%; border: none; display: grid;">
                                                <table style="border-collapse: collapse;">
                                                    <tr>
                                                        <td style="width: 220px; border: none; border-right: 1px solid black ">MEAL DEDUCTION</td>
                                                        <td style="border: none; border-collapse: collapse;" align="center">{{$salary->meal_deduction ?? 0}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border-left: none; ">INCOME TAX</td>
                                                        <td style="border-right: none;" align="center">{{$salary->income_tax ?? 0}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border-left: none; ">OTHER DEDUCTION</td>
                                                        <td style="border-right: none;" align="center">{{$salary->other_deduction ?? 0}}</td>
                                                    </tr>
                                                    <tr>
                                                        <td style="border-left: none; ">ATTENDANCE DEDUCTION</td>
                                                        <td style="border-right: none;" align="center">{{$salary->attendance_deduction}}</td>
                                                    </tr>
                                                    @if($salary->deduct != '')
                                                        @php
                                                            $deduct = json_decode($salary->deduct);
                                                        @endphp
                                                        @foreach($salaryDeductInputs as $deductInput)
                                                            @if(!empty($deduct->{$deductInput->name}))
                                                                <tr style="text-transform: uppercase">
                                                                    <td style="border-left: none; ">{{ ucwords(str_replace('_',' ',$deductInput->name)) }}</td>
                                                                    <td style="border-right: none; "align="center">{{$deduct->{$deductInput->name} ?? 0 }}</td>
                                                                </tr>
                                                            @endif
                                                        @endforeach
                                                    @endif


                                                </table>
                                            </td>
                                            <td style="" align="center">
                                                <span style="font-weight: bold">{{ $net ?? 0}}</span>
                                            </td>
                                        </tr>
                                        <tr align="center">
                                            @php
                                                $pay = 0 ;
                                                    if($salary->payment != ''){
                                                        $payment = json_decode($salary->payment);
                                                    foreach($salaryPaymentInputs as $paymentInput){
                                                        $pay = $pay + ($payment->{$paymentInput->name} ?? 0);
                                                    }
                                                    }
                                                    $deduct = 0 ;
                                                    if($salary->deduct != ''){
                                                        $deducts = json_decode($salary->deduct);
                                                        foreach($salaryDeductInputs as $deductsInput){
                                                            $deduct = $deduct + ($deducts->{$deductsInput->name} ?? 0);
                                                        }
                                                    }
                                            @endphp
                                            <td style="font-weight: bold; border-top: none;">TOTAL PAY :  {{ $allowance = ($pay + $salary->basic_salary + $salary->house_rent + $salary->medical_allowance + $salary->conveyance_allowance + $salary->others + $salary->mobile_allowance + $salary->bonus) }}</td>
                                            <td style="font-weight: bold;">TOTAL DEDUCTION : {{ $deductions = ($deduct + $salary->meal_deduction + $salary->income_tax + $salary->other_deduction + $salary->attendance_deduction)}}</td>
                                            <td style="font-weight: bold;" align="center"><span id="net-total">{{ $net}}</span> </td>
                                        </tr>
                                    </table>
                                    <p style="font-weight:bold; font-size: 12px; padding: 5px; border: 1px solid black; margin-top: 10px; text-transform: uppercase;">In Words : {{ $netWords }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="">
                            <p align="right" style="font-size: 8px;">This copy is computer generated. Does not need any authorization.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>
</body>
</html>
