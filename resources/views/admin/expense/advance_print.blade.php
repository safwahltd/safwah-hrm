<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Advance Money Receipt</title>
    <link rel="stylesheet" href="style.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .receipt-container {
            width: 670px;
            padding: 20px;
            padding-bottom: 0;
            border: 1px solid #333;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        /*header .logo {
            width: 50%;
        }
        header .logo h1 {
            font-size: 18px;
            margin: 0;
            font-weight: bold;
        }
        header .logo p {
            margin: 0;
            font-size: 12px;
            font-style: italic;
        }*/
        /*header .receipt-info {
            width: 40%;
            text-align: right;
            font-size: 14px;
        }*/
        .title {
            text-align: center;
            margin: 0;
            font-weight: bold;
            font-size: 20px;
            text-transform: uppercase;
        }
        .section {
            margin: 10px 0;
        }
        .section-row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 5px;
            font-size: 14px;
        }
        .section-row strong {
            width: 30%;
        }
        .section-row span {
            width: 68%;
            border-bottom: 1px dashed #000;
            display: inline-block;
        }
        .checkbox-row {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 14px;
            margin-top: 5px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .table td, .table th {
            border: 1px solid #333;
            padding: 2px;
            text-align: center;
            font-size: 11px;
        }
        .footer {
            margin-top: 20px;
            font-size: 12px;
        }
        .footer p {
            margin: 0;
            line-height: 1.6;
        }

        .grid-item {
            padding: 5px;
            font-size: 12px;
            text-align: center;
        }
        *{
            font-size: 11px;
        }
        * {
            box-sizing: border-box;
        }

        /* Create three equal columns that floats next to each other */
        .column {
            float: left;
            width: 30%;
            padding: 3px;
        }
        .col-6{
            float: left;
            width: 50%;
            padding: 3px;
        }
        .col-8{
            float: left;
            width: 75%;
            padding: 3px;
        }
        .col-4{
            float: left;
            width: 25%;
            padding: 3px;
        }
        .col-12{
            float: left;
            width: 100%;
            padding: 3px;
        }

        /* Clear floats after the columns */
        .row:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
<div class="receipt-container">
    <header class="row">
        <div class="logo column">
            <h1><img class="img-responsive" width="150" src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path($setting->logo))) }}" alt=""></h1>
        </div>
        <div class="column">
            <h2 style="text-transform: uppercase; font-size: 13px; text-align: center">{{ str_replace('_',' ',$expense->receipt_type)}}</h2>
        </div>
        <div class="column" style=" text-align: right; font-size: 10px;">
            <p>
                <strong>Receipt No:</strong>
                <span style="width: 50%; border-bottom: 1px dashed #000; display: inline-block;">{{$expense->receipt_no}}</span>
            </p>
            <p>
                <strong>Date:</strong>
                <span style="width: 50%; border-bottom: 1px dashed #000; display: inline-block;">{{$expense->date}}</span>
            </p>
        </div>
    </header>
    <div class="row">
        <div class="col-6" style="">
            <p style="margin-top: 0; margin-bottom: 1px;"><strong style="text-transform: uppercase; font-size: 10px;">Name : </strong> {{$expense->user->name}}</p>
        </div>
        <div class="col-6">
            <p style="margin-top: 0; margin-bottom: 1px;"><strong style="text-transform: uppercase; font-size: 10px;">Id : </strong> {{ $expense->user->userInfo->employee_id }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-6" style="">
            <p style="margin-top: 0; margin-bottom: 1px;"><strong style="text-transform: uppercase; font-size: 10px;">Dept : </strong> {{$expense->user->userInfo->designations->department->department_name}}</p>
        </div>
        <div class="col-6" style="">
            <p style="margin-top: 0; margin-bottom: 1px;"><strong style="text-transform: uppercase; font-size: 10px;">Designation : </strong> {{ $expense->user->userInfo->designations->name }}</p>
        </div>
    </div>
    <div class="row">
        <div class="col-6" style="">
            <p style="margin-top: 0; margin-bottom: 1px;"><strong style="text-transform: uppercase; font-size: 10px;">Contact No : </strong> 0{{ $expense->user->userInfo->mobile ?? '-' }}</p>
        </div>
        <div class="col-6" style="">

        </div>
    </div>
    <div class="row">
        <div class="col-4" style="">
            <strong style="width:100%; text-transform: uppercase; font-size: 10px;">Reason:</strong>
        </div>
        <div class="col-8" style="">
            <span style="width: 90%; text-align: justify;  border-bottom: 1px dashed #000; display: inline-block;">{{$expense->reason ?? '-'}}</span>
        </div>
    </div>
    <div class="row">
        <div class="col-4" style="">
            <strong style="width:100%; text-transform: uppercase; font-size: 10px;">Amount:</strong>
        </div>
        <div class="col-8" style="">
            <span style="width: 90%; border-bottom: 1px dashed #000; display: inline-block;">{{ $expense->amount ?? 0 }} /-</span>
        </div>
    </div>
    <div class="row">
        <div class="col-4" style="">
            <strong style="width:100%; text-transform: uppercase; font-size: 10px;">In Words:</strong>
        </div>
        <div class="col-8" style="">
            <span style="width: 90%; border-bottom: 1px dashed #000; display: inline-block;">{{ ucwords($netWords)}}</span>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <label><input {{ $expense->advance_payment_type == 'cash' ? 'checked':'' }} type="checkbox"> Cash</label>
            <label><input {{ $expense->advance_payment_type == 'bank' ? 'checked':'' }} type="checkbox"> Bank</label>
            <label><input {{ $expense->advance_payment_type == 'mfs' ? 'checked':'' }} type="checkbox"> MFS</label>
        </div>
    </div>
    <div class="row">
        <div class="col-4" style="padding-top: 45px; text-align: right">
                <span>
                <span> ____________</span>
                <br><strong>Raised By </strong>
            </span>
        </div>
        <div class="col-4" style="padding-top: 45px; text-align: right">
                <span>
                <span> ____________</span>
                <br>
                <strong>Checked By </strong>
            </span>
        </div>
        <div class="col-4" style="padding-top: 45px; text-align: right">
                <span>
                <span> ____________</span>
                <br>
                <strong>Approved By </strong>
            </span>
        </div>
    </div>
    <div class="" style=" padding-top: 3px; text-align: center; ">
        <p style="background-color: black; font-size: 7px; color: white; padding: 3px;">{{$setting->address}}</p>
    </div>
</div>
</body>
</html>



