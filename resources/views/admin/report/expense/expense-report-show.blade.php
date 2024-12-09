<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Report</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.5;font-size: 15px; }
        h1 { text-align: center; }
        .content { margin: 0 auto; width: 95%; }
        .signature { margin-top: 50px; }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        @media only screen and (max-width: 600px) {
            * {
                font-size: 10px;
            }
            table, th {
                font-size: 8px;
            }
            table, td {
                font-size: 8px;
            }
        }
    </style>
    <style>
        .floating-button {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000; /* Ensure it stays above other content */
        }

        .floating-button .btn {
            background-color:  black; /* Bootstrap primary color */
            color: white;
            padding: 15px 20px;
            border-radius: 50px; /* Makes it look like a pill */
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            text-align: center;
            text-decoration: none;
        }

        .floating-button .btn:hover {
            background-color: black; /* Darker shade on hover */
            text-decoration: none;
        }
    </style>

</head>
<body>
<div class="content">
    <div class="row" style="margin-top: 4px;">
        <div style="border-top: 1px solid black; border-left: 1px solid #000000; border-right: 1px solid black; margin:0">
            <h4  style="margin: 0; padding: 5px; text-transform: uppercase;" align="center">Expense Report </h4>
            <p align="center" style="margin-bottom: 0; padding-bottom: 5px; text-transform: uppercase;">Period : {{$start_date}}  < >  {{$end_date}}</p>
        </div>
        @if($receipt_type == 'advance_money_receipt')
            <table style="width:100% ; text-align: center ;margin-bottom: 4px">
            <tr style="background-color: aliceblue; font-size: 14px; text-transform: uppercase;">
                <th>SL</th>
                <th>Date</th>
                <th>User</th>
                <th>id</th>
                <th>Receipt Type</th>
                <th>Receipt No</th>
                <th>Payment Type</th>
                <th>Status</th>
                <th>Amount</th>
            </tr>
            @php
                $AdvanceAmount = 0;
            @endphp
            @foreach($expenses as $expense)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $expense->date }}</td>
                    <td align="left" style="padding-left: 5px;">{{ $expense->user->name }}</td>
                    <td>{{ $expense->user->userInfo->employee_id }}</td>
                    <td>{{ ucwords(str_replace('_',' ',$expense->receipt_type))}}</td>
                    <td>{{ $expense->receipt_no}}</td>
                    <td>{{ $expense->advance_payment_type ? ucwords($expense->advance_payment_type) : ucwords($expense->money_payment_type)}}</td>
                    <td>{{ $expense->status == 0 ? 'Pending':'' }}{{ $expense->status == 1 ? 'Accepted':'' }}{{ $expense->status == 0 ? 'Rejected':'' }}</td>
                    <td>{{ $expense->amount ?? '-'  }}</td>
                </tr>
                <p hidden>{{ $AdvanceAmount = $AdvanceAmount + $expense->amount}}</p>
            @endforeach
            <tr style="font-weight: bold">
                <td colspan="8">Total</td>
                <td>{{ $AdvanceAmount }}</td>
            </tr>
        </table>
        @elseif($receipt_type == 'money_receipt')
            <table style="width:100% ; text-align: center ;margin-bottom: 4px">
            <tr style="background-color: aliceblue; font-size: 14px; text-transform: uppercase;">
                <th>SL</th>
                <th>Date</th>
                <th>User</th>
                <th>id</th>
                <th>Receipt Type</th>
                <th>Receipt No</th>
                <th>Ref. Receipt No</th>
                <th>Payment Type</th>
                <th>Amount</th>
                <th>Payment</th>
                <th>Due</th>
            </tr>
            @php
                $amount = 0;
                $payment = 0;
                $due = 0;
            @endphp
            @foreach($expenses as $expense)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $expense->date }}</td>
                    <td align="left" style="padding-left: 5px;">{{ $expense->user->name }}</td>
                    <td>{{ $expense->user->userInfo->employee_id }}</td>
                    <td>{{ ucwords(str_replace('_',' ',$expense->receipt_type))}}</td>
                    <td>{{ $expense->receipt_no}}</td>
                    <td>{{ $expense->adjusted_receipt_no ?? '-'}}</td>
                    <td>{{ $expense->advance_payment_type ? ucwords($expense->advance_payment_type) : ucwords($expense->money_payment_type)}}</td>
                    <td>{{ $expense->amount ?? '-'  }}</td>
                    <td>{{ $expense->payment ?? '-'  }}</td>
                    <td>{{ $expense->due ?? '-' }}</td>
                </tr>
                <p hidden>{{ $amount = $amount + $expense->amount}}</p>
                <p hidden>{{ $payment = $payment + $expense->payment}}</p>
                <p hidden>{{ $due = $due + $expense->due}}</p>
            @endforeach
            <tr style="font-weight: bold">
                <td colspan="8">Total</td>
                <td>{{ $amount }}</td>
                <td>{{ $payment }}</td>
                <td>{{ $due }}</td>
            </tr>
        </table>
        @else
            <table style="width:100% ; text-align: center ;margin-bottom: 4px">
                <tr style="background-color: aliceblue; font-size: 14px; text-transform: uppercase;">
                    <th>SL</th>
                    <th>Date</th>
                    <th>User</th>
                    <th>id</th>
                    <th>Receipt Type</th>
                    <th>Receipt No</th>
                    <th>Ref. Receipt No</th>
                    <th>Payment Type</th>
                    <th>Amount</th>
                    <th>Payment</th>
                    <th>Due</th>
                    <th>Receivable</th>
                </tr>
                @php
                    $AdAmount = 0;
                    $MAmount = 0;
                    $Tpayment = 0;
                    $Tdue = 0;
                @endphp
                @foreach($expenses as $expense)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $expense->date }}</td>
                        <td align="left" style="padding-left: 5px;">{{ $expense->user->name }}</td>
                        <td>{{ $expense->user->userInfo->employee_id }}</td>
                        <td>{{ ucwords(str_replace('_',' ',$expense->receipt_type))}}</td>
                        <td>{{ $expense->receipt_no}}</td>
                        <td>{{ $expense->adjusted_receipt_no ?? '-'}}</td>
                        <td>{{ $expense->advance_payment_type ? ucwords($expense->advance_payment_type) : ucwords($expense->money_payment_type)}}</td>
                        <td>{{ $expense->amount ?? '-'  }}</td>
                        <td>{{ $expense->payment ?? '-'  }}</td>
                        <td>{{ $expense->due ?? '-' }}</td>
                    </tr>
                    <p hidden>
                        @if($expense->receipt_type == 'advance_money_receipt')
                            {{ $AdAmount = $AdAmount + $expense->amount}}
                        @elseif($expense->receipt_type == 'money_receipt')
                            {{ $MAmount = $MAmount + $expense->amount}}
                        @endif
                    </p>
                    <p hidden>{{ $Tpayment = $Tpayment + $expense->payment}}</p>
                    <p hidden>{{ $Tdue = $Tdue + $expense->due}}</p>
                @endforeach
                <tr style="font-weight: bold">
                    <td colspan="8">Total</td>
                    <td>AD : {{ $AdAmount }} | MO : {{ $MAmount }} </td>
                    <td>{{ $Tpayment }}</td>
                    <td>
                        @if($MAmount < ($AdAmount + $Tpayment))
                            {{ $TOTaldue = ($AdAmount + $Tpayment) - $MAmount }}
                        @else
                            {{ $TOTaldue = 0 }}
                        @endif
                    </td>
                    <td>
                        @if($MAmount > ($AdAmount + $Tpayment))
                            {{ str_replace('-','', ($MAmount - ($AdAmount + $Tpayment ))) }}
                        @else
                            0
                        @endif
                    </td>
                </tr>
            </table>
        @endif
    </div>
    <div class="floating-button">
        <form action="{{ route('admin.download.expense.report') }}" method="get">
            @csrf
            <input type="hidden" name="start_date" value="{{$start_date}}">
            <input type="hidden" name="end_date" value="{{$end_date}}">
            <input type="hidden" name="user_id" value="{{$user_id}}">
            <input type="hidden" name="receipt_type" value="{{$receipt_type}}">
            <button class="btn btn-black" style="position: absolute; bottom: 0px; right: 0;">Download</button>
        </form>
    </div>
</div>
</body>
</html>


