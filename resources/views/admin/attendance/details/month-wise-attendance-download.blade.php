<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Attendance Details</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.5;font-size: 15px; }
        h1 { text-align: center; }
        .content { margin: 0 auto; width: 90%; }
        .signature { margin-top: 50px; }
        table, th, td {
            border: 1px solid black;
            border-collapse: collapse;
        }
        /* Create four equal columns that floats next to each other */
        .column {
            float: left;
            width: 25%;
            padding: 10px;
        }
        .col-3 {
            float: left;
            width: 22%;
            padding: 10px;
        }
        .col-6 {
            float: left;
            width: 40%;
            padding: 10px;
        }

        .row:after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>
<body>
<div class="content">
    <div class="row" style="margin-top: 4px;">
        <div style="border-top: 1px solid black; border-left: 1px solid #000000; border-right: 1px solid black; margin:0">
            <h5  style="padding:5px; margin: 0; text-transform: uppercase;" align="center">Monthly Individual Attendance {{$month == '' ? 'All': date('F', mktime(0, 0, 0, $month, 1)) }}  {{$year}} </h5>
            <div class="row" style="border-top: 1px solid black; border-bottom: 1px solid black; justify-items: center">
                <div class="col-6">
                    <p style="font-size: 10px; margin: 2px">Employee No : {{$user->userInfo->employee_id}}</p>
                    <p style="font-size: 10px; margin: 2px">Department : {{$user->userInfo->designations->department->department_name}}</p>
                </div>
                <div class="col-6">
                    <p style="font-size: 10px; margin: 2px">Employee Name : {{$user->name}}</p>
                    <p style="font-size: 10px; margin: 2px">Designation : {{$user->userInfo->designations->name}}</p>
                </div>
            </div>
            <h6  style="padding:5px; margin: 0; text-transform: uppercase;" align="center">Attendance Summary</h6>
            <div class="row" style="border-top: 1px solid black">
                <div class="col-3">
                    <p style="font-size: 10px; margin: 2px;">Working Days : {{ $workingDaysRecord->working_day ?? 0}} Day</p>
                    <p style="font-size: 10px; margin: 2px;">Holidays : {{ count($holidayDates) }} Day</p>
                </div>
                <div class="col-3">
                    <p style="font-size: 10px; margin: 2px;">Present : {{ $present}} Day</p>
                    <p style="font-size: 10px; margin: 2px;">Absent : {{ ($workingDaysRecord->working_day ?? 0) - $present }} Day</p>
                </div>
                <div class="col-3">
                    <p style="font-size: 10px; margin: 2px;">Late : {{count($lateCount)}} Day</p>
                    <p style="font-size: 10px; margin: 2px;">Present Percentage : {{ number_format(($present * 100) / ($workingDaysRecord->working_day ?? 1),2) }} %</p>
                </div>
                <div class="col-3">
                    <p style="font-size: 10px; margin: 2px;">Leave : {{ count($leaveDates) }} Day</p>
                </div>
            </div>
        </div>
        <table style="width:100% ; text-align: center ; margin-bottom: 4px">
            <tr style="background-color: #5c636a; font-size: 10px; color: white">
                <th><span style="font-size: 10px">SL</span></th>
                <th><span style="font-size: 10px">Date</span></th>
                <th><span style="font-size: 10px">IN TIME</span></th>
                <th><span style="font-size: 10px">OUT TIME</span></th>
                <th><span style="font-size: 10px">Duty Hour</span></th>
                <th><span style="font-size: 10px">Status</span></th>
                <th><span style="font-size: 10px">Remarks</span></th>
            </tr>
            @foreach($attendanceData as $date => $data)
                <tr style="font-size: 12px">
                    <td><span style="font-size: 10px">{{ $loop->iteration }}</span></td>
                    <td><span style="font-size: 10px">{{ \Carbon\Carbon::parse($date)->format('d-M-Y') }}</span></td>
                    <td>
                        @if ($data->isEmpty())
                            <div>-</div>
                        @else
                            @foreach ($data as $att)
                                <div><span style="font-size: 10px">{{ \Carbon\Carbon::parse($att->clock_in)->format('H:i a')  }}</span></div>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if ($data->isEmpty())
                            <div>-</div>
                        @else
                            @foreach ($data as $att)
                                @if($att->clock_out)
                                    <div><span style="font-size: 10px">{{ \Carbon\Carbon::parse($att->clock_out)->format('H:i a') }}</span></div>
                                @else
                                    <div>-</div>
                                @endif
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if ($data->isEmpty())
                            <div>-</div>
                        @else
                            @foreach ($data as $att)
                                <div><span style="font-size: 10px">{{ $att->working_time ?? '-' }}</span></div>
                            @endforeach
                        @endif
                    </td>
                    <td>@if ($data->isEmpty()) <div><span style="font-size: 10px">A</span></div> @else <div><span style="font-size: 10px">P</span></div> @endif </td>
                    <td>
                        @php
                            $carbonDate = ($date instanceof \Illuminate\Support\Carbon) ? $date : \Illuminate\Support\Carbon::parse($date);
                        @endphp
                        @if ($carbonDate->dayOfWeek === \Illuminate\Support\Carbon::FRIDAY)
                            <div><span style="font-size: 10px">Friday</span></div>
                        @endif
                        @if(in_array(\Carbon\Carbon::parse($date)->format('Y-m-d'),$holidayDates))
                            @php
                                $holiday = \App\Models\Holiday::whereJsonContains('dates',\Carbon\Carbon::parse($date)->format('Y-m-d'))->where('status',1)->first();
                            @endphp
                            @if($holiday)
                                <div class=""><span style="font-size: 10px">HOLIDAY - {{$holiday->name}}</span></div>
                            @endif
                        @endif
                        @if(in_array(\Carbon\Carbon::parse($date)->format('Y-m-d'),$leaveDates))
                            <div class=""><span style="font-size: 10px"> Leave </span></div>
                        @endif
                    </td>
                </tr>
            @endforeach
        </table>
    </div>
</div>

</body>
</html>



