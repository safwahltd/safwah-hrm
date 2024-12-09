<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Report</title>
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
                <h4  style="padding:15px; margin: 0" align="center">Daily Report For {{$month == '' ? 'All': date('F', mktime(0, 0, 0, $month, 1)) }}  {{$year}} </h4>
            </div>
            <table style="width:100% ; text-align: center ;margin-bottom: 4px">
                <tr style="background-color: aliceblue; font-size: 14px">
                    <th>SL</th>
                    <th>Date</th>
                    <th>Leave</th>
                    <th>Termination</th>
                    <th>Asset</th>
                    <th>Salary</th>
                    <th>Notice</th>
                </tr>
                @foreach($reportData as $data)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ \Carbon\Carbon::parse($data['date'])->format('d-M-Y') }}</td>
                        <td>{{ $data['leave_count'] }}</td>
                        <td>{{ $data['termination_count'] }}</td>
                        <td>{{ $data['asset_count'] }}</td>
                        <td>{{ $data['salary_count'] }}</td>
                        <td>{{ $data['notice_count'] }}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    <div class="floating-button">
            <form action="{{ route('admin.download.daily.report') }}" method="get">
                @csrf
                <input type="hidden" name="month" value="{{$month}}">
                <input type="hidden" name="year" value="{{$year}}">
                <input type="hidden" name="day" value="{{$dayreport}}">
                <button class="btn btn-black" style="position: absolute; bottom: 0px; right: 0;">Download</button>
            </form>
        </div>
</div>
</body>
</html>


