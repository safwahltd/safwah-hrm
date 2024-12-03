<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leave Report</title>
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
<div class="">
    <div class="row" style="margin-top: 4px;">
        <div class="" style="background-color: #00a686; color: white">
            <h4 align="center" style="padding: 3px;">Leave Report For {{ $month == '' ? 'All Month': date('F', mktime(0 , 0 , 0 , $month , 1)) }}  {{ $year }} </h4>
        </div>
        <table style="width:100% ;  text-align: center ; padding: 2px ;margin-bottom: 4px">
            <tr style="background-color: #5c636a; font-size: 12px; color: white; text-transform: uppercase">
                <th>SL</th>
                <th>Name</th>
                <th>Id</th>
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
                <tr style="font-size: 13px;">
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
                        <td align="left" style="padding-left: 10px;">
                            @if($month)
                                @php
                                    $leaveBalance = $leaveBalance = \App\Models\HalfDayLeaveBalance::where('user_id',$user->id)->where('year',$year)->where('month',$month)->first();
                                @endphp
                                <span class="fw-bold text-success">Available : {{ $leaveBalance->half_day ?? 0 }} </span><br>
                                <span class="fw-bold text-danger">Spent : {{ $leaveBalance->spent ?? 0 }}</span><br>
                                <span class="fw-bold text-primary">Left : {{ $leaveBalance->left ?? 0 }}</span>
                            @else
                                @php
                                    $leaveBalance = \App\Models\HalfDayLeaveBalance::where('user_id',$user->id)->where('year',$year)->select([
    \Illuminate\Support\Facades\DB::raw('SUM(half_day) as half_day_total'),
    \Illuminate\Support\Facades\DB::raw('SUM(spent) as spent_total'),
    \Illuminate\Support\Facades\DB::raw('SUM(`left`) as left_total'),
])->first();
                                @endphp
                                <span class="fw-bold text-success">Available : {{$leaveBalance->half_day_total ?? 0}}  </span><br>
                                <span class="fw-bold text-success">Spent : {{ $leaveBalance->spent_total ?? 0 }} </span><br>
                                <span class="fw-bold text-success">Left : {{ $leaveBalance->left_total ?? 0 }} </span><br>
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
                            $leaveBalance = \App\Models\LeaveBalance::where('user_id',$user->id)->where('year',$year)->first();
                        @endphp
                        <td align="left" style="padding-left: 10px;">
                            <span class="fw-bold text-success">Available : {{ $leaveBalance->sick ?? 0 }} </span><br>
                            <span class="fw-bold text-danger">Spent : {{ $leaveBalance->sick_spent ?? 0 }}</span><br>
                            <span class="fw-bold text-primary">Left : {{ $leaveBalance->sick_left ?? 0 }}</span>
                        </td>
                    @endif
                    @if($type == 'casual' || $type == 'all')
                        @php
                            $casualLeave = \App\Models\Leave::where('user_id', $user->id)
                            ->whereIn('leave_type', ['casual'])
                            ->where('status',1)
                            ->whereYear('start_date', $year)
                            ->sum('days_taken');
                            $casualLeaveBalance = \App\Models\LeaveBalance::where('user_id',$user->id)->where('year',$year)->first();
                        @endphp
                        <td align="left" style="padding-left: 10px;">
                            <span class="fw-bold text-success">Available : {{$casualLeaveBalance->casual ?? 0}} </span><br>
                            <span class="fw-bold text-danger">Spent : {{ $casualLeaveBalance->casual_spent ?? 0 }}</span><br>
                            <span class="fw-bold text-primary">Left : {{ $casualLeaveBalance->casual_left ?? 0 }}</span>
                        </td>
                    @endif
                </tr>
            @endforeach
        </table>
    </div>
</div>
</body>
</html>


