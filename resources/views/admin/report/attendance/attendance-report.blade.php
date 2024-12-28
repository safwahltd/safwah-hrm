<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Attendance Report</title>
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

        @foreach($reportData as $month => $monthData)
            <div class="row" style="margin-top: 20px;">
                <div style="border-top: 1px solid black; border-left: 1px solid #000000; border-right: 1px solid black; margin:0">
                    <h5 style="padding:15px; margin: 0; text-transform: uppercase;" align="center">Attendance Report For {{$month == '' ? 'All': date('F', mktime(0, 0, 0, $month, 1)) }}  {{$year}} </h5>
                </div>
                <table style="width:100% ; text-align: center;">
                    <thead>
                    <tr style="background-color: #5c636a; color: white; font-size: 11px; text-transform: uppercase">
                        <th>SL</th>
                        <th>Name</th>
                        <th>Id</th>
                        <th>Designation</th>
                        <th>Working Day</th>
                        <th>Attendance</th>
                        <th>Late Attendance</th>
                        <th>Absent</th>
                        <th>Leave</th>
                    </tr>
                    </thead>
                    <tbody>
                    @forelse($monthData as $data)
                        <tr style="font-size: 11px">
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $data['user_name'] }}</td>
                            <td>{{ $data['user_id'] }}</td>
                            <td>{{ $data['designation'] }}</td>
                            <td>{{ $data['total_working_days'] }}</td>
                            <td>{{ $data['total_presents'] }}</td>
                            <td>{{ $data['total_late'] }}</td>
                            <td>{{ $data['total_absents'] }}</td>
                            <td>{{ $data['totalLeave'] }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td class="text-center" colspan="9">No Data Found</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        @endforeach
        </div>
    <div class="floating-button">
            <form action="{{ route('admin.download.attendance.report') }}" method="get">
                <input type="hidden" name="month" value="{{$mon}}">
                <input type="hidden" name="year" value="{{$year}}">
                <input type="hidden" name="user_id" value="{{$user_id}}">
                <button class="btn btn-black" style="position: absolute; bottom: 0px; right: 0;">Download</button>
            </form>
        </div>
</div>
</body>
</html>


