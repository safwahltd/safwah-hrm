<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Report</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.5;font-size: 15px; }
        h1 { text-align: center; }
        .content { margin: 0 auto; width: 90%; }
        .signature { margin-top: 50px; }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
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
<div class="">
    <div class="row" style="margin-top: 4px;">
        <div class="">
            <h4 align="center">Leave Report For {{$month == '' ? 'All': date('F', mktime(0, 0, 0, $month, 1)) }}  {{$year}} </h4>
        </div>
        <table style="width:100% ;  text-align: center ; padding: 2px ;margin-bottom: 4px">
            <tr style="background-color: aliceblue; font-size: 14px">
                <th>SL</th>
                <th>Name</th>
                <th>E.ID</th>
                <th>Designation</th>
                @if($type == 'half_day' || $type == 'all')
                    <th>Half Day</th>
                @endif
                @if($type == 'sick' || $type == 'all')
                    <th>Sick</th>
                @endif
                @if($type == 'casual' || $type == 'all')
                    <th>Casual</th>
                @endif
            </tr>
            @foreach($users as $key => $user)
                <tr style="font-size: 13px">
                    <td align="center"><span class="fw-bold">{{$loop->iteration}}</span></td>
                    <td align="center"><span class="fw-bold">{{$user->name}}</span></td>
                    <td align="center"><span class="fw-bold">{{$user->userInfo->employee_id}}</span></td>
                    <td align="center"><span class="fw-bold">{{$user->userInfo->designations->name}}</span></td>
                    @if($type == 'half_day' || $type == 'all')
                        @php
                            $halfDayLeave = \App\Models\Leave::where('user_id', $user->id)
                                ->whereIn('leave_type', ['half_day'])
                                ->where('status',1)
                                ->when($month, function ($q) use ($month) {return $q->whereMonth('start_date', $month);})
                                ->whereYear('start_date', $year)
                                ->sum('days_taken');
                        @endphp
                        <td>
                            @if($month)
                                <span class="fw-bold text-success">Available : 2 </span><br>
                                <span class="fw-bold text-danger">Spent : {{ $halfDayLeave }}</span><br>
                                <span class="fw-bold text-primary">Left : {{ 2 - $halfDayLeave }}</span>
                            @else
                                <span class="fw-bold text-success">Available : 24 </span><br>
                                <span class="fw-bold text-success">Spent : {{ $halfDayLeave }} </span><br>
                                <span class="fw-bold text-success">Left : {{ 24 - $halfDayLeave }} </span><br>
                            @endif

                        </td>
                    @endif
                    @if($type == 'sick' || $type == 'all')
                        @php
                            $sickLeave = \App\Models\Leave::where('user_id', $user->id)
                                ->whereIn('leave_type', ['sick'])
                                ->where('status',1)
                                ->whereYear('start_date', $year)
                                ->sum('days_taken');
                        @endphp
                        <td>
                            <span class="fw-bold text-success">Available : 10 </span><br>
                            <span class="fw-bold text-danger">Spent : {{ $sickLeave }}</span><br>
                            <span class="fw-bold text-primary">Left : {{ 10 - $sickLeave }}</span>
                        </td>
                    @endif
                    @if($type == 'casual' || $type == 'all')
                        @php
                            $casualLeave = \App\Models\Leave::where('user_id', $user->id)
                            ->whereIn('leave_type', ['casual'])
                            ->where('status',1)
                            ->whereYear('start_date', $year)
                            ->sum('days_taken');
                        @endphp
                        <td>
                            <span class="fw-bold text-success">Available : 10 </span><br>
                            <span class="fw-bold text-danger">Spent : {{ $casualLeave }}</span><br>
                            <span class="fw-bold text-primary">Left : {{ 10 - $casualLeave }}</span>
                        </td>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>
</div>
</body>
</html>


