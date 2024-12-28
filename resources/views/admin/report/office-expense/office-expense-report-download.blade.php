<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Office Expense Report</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.5;font-size: 15px; }
        h1 { text-align: center; }
        .content { margin: 0 auto; width: 100%; }
        .signature { margin-top: 50px; }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        @media only screen and (max-width: 600px) {
            * {
                font-size: 8px;
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
            <h4  style="margin: 0; padding: 5px; text-transform: uppercase;" align="center">Office Expense Report </h4>
            <p align="center" style="margin-bottom: 0; padding-bottom: 5px; text-transform: uppercase;">Period : {{$start_date}}  < >  {{$end_date}}</p>
        </div>
        <table style="width:100% ; text-align: center ;margin-bottom: 4px">
            <tr style="background-color: aliceblue; font-size: 11px; text-transform: uppercase;">
                <th>SL</th>
                <th>Date</th>
                <th>Purpose</th>
                <th>Payment Type</th>
                <th>Amount</th>
                <th>Remarks</th>
            </tr>
            @foreach($expenses as $expense)
                <tr style="font-size: 11px;">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $expense->date }}</td>
                    <td>{{ ucwords(str_replace('_',' ',$expense->purpose))}}</td>
                    <td>{{ $expense->payment_type}}</td>
                    <td>{{ number_format($expense->amount) }}</td>
                    <td>{{ $expense->remarks ?? '-'}}</td>
                </tr>
            @endforeach
            <tr style="font-weight: bold; font-size: 11px;">
                <td colspan="4">Total</td>
                <td>{{ number_format($expenses->sum('amount')) }} </td>
                <td></td>
            </tr>
        </table>
    </div>
</div>
</body>
</html>


