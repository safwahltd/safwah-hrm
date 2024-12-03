<!DOCTYPE html>
<html>
<head>
    <title>Leave Request Form</title>

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
        *{
            font-size: 12px;
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
                            <div style="margin-bottom: 5px;">
                                <img class="img-responsive" width="200" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path($setting->logo))) }}" alt="">
                            </div>
                            <p style="font-size: 10px;">{{ $setting->address }}</p>
                        </div>
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table table-striped table-bordered" style="border: 1px solid black">
                                        <thead class="text-center">
                                            <th colspan="2" class="p-2">
                                                <small class="p-0 fw-bold mx-0" style="font-size: 13px">LEAVE REQUEST FORM</small>
                                            </th>
                                        </thead>
                                        <tbody class="">
                                        <tr>
                                            <td><small class="fw-bold" style="font-weight: bold">DATE OF APPLICATION:</small> <small> {{\Illuminate\Support\Carbon::parse($data->created_at)->format('d-m-Y')}}</small></td>
                                            <td><small class="fw-bold" style="font-weight: bold">EMPLOYEE NAME: </small> <small> {{$data->user->name}}</small></td>
                                        </tr>
                                        <tr>
                                            <td><small class="fw-bold" style="font-weight: bold">JOINING DATE: </small><smal>{{$data->user->userInfo->join}}</smal></td>
                                            <td><small class="fw-bold" style="font-weight: bold">EMPLOYEE ID: </small> <small>{{$data->user->userInfo->employee_id}}</small></td>
                                        </tr>
                                        <tr>
                                            <td><small class="fw-bold" style="font-weight: bold">DESIGNATION: </small> <small>{{$data->user->userInfo->designations->name}}</small></td>
                                            <td> <small class="fw-bold" style="font-weight: bold">DEPARTMENT: </small> <small>{{$data->user->userInfo->designations->department->department_name}}</small></td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-striped table-bordered" style="border: 1px solid black; text-align: center; margin-top: 15px">
                                        <thead class="text-center">
                                        <th colspan="3"><small class="p-0 fw-bold my-0" style="font-size: 13px; font-weight: bold">LEAVE APPLICATION</small></th>
                                        <th colspan="3"><small class="p-0 fw-bold my-0" style="font-size: 13px; font-weight: bold">REMAINING ENTILEMENT</small></th>
                                        </thead>
                                        <tbody class="" style="border: 1px solid black">
                                        <tr class="bg-secondary-subtle">
                                            <td style="width: 200px"><small class="fw-bold py-0 my-0" style="font-weight: bold">LEAVE TYPE</small></td>
                                            <td style="width: 200px"><small class="fw-bold py-0 my-0" style="font-weight: bold">DATE</small></td>
                                            <td><small class="fw-bold py-0 my-0" style="font-weight: bold">NO. OF DAYS</small></td>
                                            <td><small class="fw-bold py-0 my-0" style="font-weight: bold">ENTILEMENT</small></td>
                                            <td><small class="fw-bold py-0 my-0" style="font-weight: bold">TAKEN</small></td>
                                            <td><small class="fw-bold py-0 my-0" style="font-weight: bold">BALANCE</small></td>
                                        </tr>
                                        <tr>
                                            <td class="col-3" style="text-align: left"><small class="fw-bold py-0 my-0" style="font-weight: bold"><small>CASUAL LEAVE</small></small></td>
                                            <td><small>{{$data->leave_type == 'casual' ? \Illuminate\Support\Carbon::parse($data->start_date)->format('d-m-Y')." -> ".\Illuminate\Support\Carbon::parse($data->end_date)->format('d-m-Y'):''}}</small></td>
                                            <td>{{$data->leave_type == 'casual' ? $data->days_taken:''}}</td>
                                            <td>{{$data->leave_type == 'casual' ? $leaveBalance->casual:''}}</td>
                                            <td>{{$data->leave_type == 'casual' ? $leaveBalance->casual_spent:''}}</td>
                                            <td>{{$data->leave_type == 'casual' ? $leaveBalance->casual_left:''}}</td>
                                        </tr>
                                        <tr>
                                            <td class="col-3" style="text-align: left"><small class="fw-bold py-0 my-0" style="font-weight: bold"><small>SICK LEAVE</small></small></td>
                                            <td><small>{{$data->leave_type == 'sick' ? \Illuminate\Support\Carbon::parse($data->start_date)->format('d-m-Y')." -> ".\Illuminate\Support\Carbon::parse($data->end_date)->format('d-m-Y'):''}}</small></td>
                                            <td>{{$data->leave_type == 'sick' ? $data->days_taken:''}}</td>
                                            <td>{{ $data->leave_type == 'sick' ? $leaveBalance->sick:''}}</td>
                                            <td>{{ $data->leave_type == 'sick' ? $leaveBalance->sick_spent :''}}</td>
                                            <td>{{ $data->leave_type == 'sick' ? $leaveBalance->sick_left :''}}</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: left"><small class="fw-bold py-0 my-0" style="font-weight: bold"><small>HALF DAY LEAVE</small></small></td>
                                            <td><small>{{$data->leave_type == 'half_day' ? \Illuminate\Support\Carbon::parse($data->start_date)->format('d-m-Y')." -> ".\Illuminate\Support\Carbon::parse($data->end_date)->format('d-m-Y'):''}}</small></td>
                                            <td>{{$data->leave_type == 'half_day' ? $data->days_taken :''}}</td>
                                            <td>{{$data->leave_type == 'half_day' ? $leaveBalance->half_day :''}}</td>
                                            <td>{{ $data->leave_type == 'half_day' ? $leaveBalance->spent :''}}</td>
                                            <td>{{ $data->leave_type == 'half_day' ? $leaveBalance->left :''}}</td>
                                        </tr>
                                        <tr>
                                            <td style="text-align: left"><small class="fw-bold py-0 my-0"><small style="font-weight: bold">LEAVE WITHOUT PAY</small></small></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        <tr>
                                            <td class="col-3" style="text-align: left"><small class="fw-bold py-0 my-0" style="font-weight: bold"><small>REASON FOR LEAVE</small></small></td>
                                            <td colspan="5" style="text-align: left">{{$data->reason}}</td>
                                        </tr>
                                        <tr>
                                            <td class="col-3" style="text-align: left"><small class="fw-bold py-0 my-0" style="font-weight: bold"><small>ADDRESS & CONTACT DURING LEAVE</small></small></td>
                                            <td colspan="5" style="text-align: left">{{$data->address_contact}}</td>
                                        </tr>
                                        <tr>
                                            <td class="col-3" style="text-align: left"><small class="fw-bold py-0 my-0" style="font-weight: bold"><small>CONCERN PERSON DURING LEAVE</small></small></td>
                                            <td colspan="5" style="text-align: left">{{$data->concern_person}}</td>
                                        </tr>
                                        <tr>
                                            <td colspan="6">
                                                <div align="center" class="" style="alignment: center">
                                                    <span class="py-0 my-0">
                                                    <small>I WISH TO APPLY FOR LEAVE AS STATED ABOVE</small>
                                                    <p align="left" style="margin-top: 4px; font-size: 12px; font-weight: bold">SIGNATURE & DATE:</p>
                                                </span>
                                                </div>
                                            </td>
                                        </tr>
                                        </tbody>
                                    </table>
                                    <table class="table table-striped table-bordered" style="border: 1px solid black; margin-top: 12px">
                                        <thead class="text-center">
                                        <th><small class="p-0 fw-bold mx-0">COMMENTS OR SPECIAL INSTRUCTION: </small></th>
                                        <th><small class="p-0 fw-bold mx-0">CHECKED BY: </small></th>
                                        <th><small class="p-0 fw-bold mx-0">APPROVED BY: </small></th>
                                        </thead>
                                        <tbody class="">
                                        <tr>
                                            <td><p class="my-4"></p></td>
                                            <td><p class="my-4"></p></td>
                                            <td><p class="my-4"></p></td>
                                        </tr>
                                        </tbody>
                                    </table>
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
