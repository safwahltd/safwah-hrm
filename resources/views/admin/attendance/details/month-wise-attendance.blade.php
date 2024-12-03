<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Monthly Attendance Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
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
        *{
            font-size: 11px;
        }
    </style>

</head>
<body>
<div class="content">
    <div class="row" style="margin-top: 4px;">
        <div style="border-top: 1px solid black; border-left: 1px solid #000000; border-right: 1px solid black; margin:0">
            <h5  style="padding:5px; margin: 0; text-transform: uppercase; font-weight: bold" align="center">Monthly Individual Attendance {{$month == '' ? 'All': date('F', mktime(0, 0, 0, $month, 1)) }}  {{$year}} </h5>
            <div class="row p-2" style="border-top: 1px solid black; border-bottom: 1px solid black; ">
                <div class="col-6 col-md-4">
                    <h6 style="font-size: 11px"><span style="font-weight: bold">ID : </span>{{$user->userInfo->employee_id}}</h6>
                    <h6 style="font-size: 11px"><span style="font-weight: bold">DEPARTMENT : </span>{{$user->userInfo->designations->department->department_name}}</h6>
                </div>
                <div class="col-6 col-md-4">
                    <h6 style="font-size: 11px"><span style="font-weight: bold">NAME : </span>{{$user->name}}</h6>
                    <h6 style="font-size: 11px"><span style="font-weight: bold">DESIGNATION : </span>{{$user->userInfo->designations->name}}</h6>
                </div>
            </div>
            <h6  style="padding:5px; margin: 0; text-transform: uppercase; font-weight: bold" align="center">Attendance Summary</h6>
            <div class="row justify-content-center p-2" style="border-top: 1px solid black">
                <div class="col-4">
                    <h6 style="font-size: 10px"><span style="font-weight: bold">Working Days : </span>{{ $workingDaysRecord->working_day ?? 0}} Day</h6>
                    <h6 style="font-size: 10px"><span style="font-weight: bold">Holidays : </span>{{ count($holidayDates) }} Day</h6>
                    <h6 style="font-size: 10px"><span style="font-weight: bold">Leave : </span>{{ count($leaveDates) }} Day</h6>
                </div>
                <div class="col-4">
                    <h6 style="font-size: 10px"><span style="font-weight: bold">Present : </span>{{ $present}} Day</h6>
                    <h6 style="font-size: 10px"><span style="font-weight: bold">Absent : </span>{{ ($workingDaysRecord->working_day ?? 0) - $present }} Day</h6>
                    <h6 style="font-size: 10px"><span style="font-weight: bold">Late : </span>{{count($lateCount)}} Day</h6>
                </div>
                <div class="col-4">
                    <h6 style="font-size: 10px"><span style="font-weight: bold">Present Percentage : </span>{{ number_format(($present * 100) / ($workingDaysRecord->working_day ?? 1),2) }} %</h6>
                </div>
            </div>
        </div>
        <table style="width:100% ; text-align: center ; margin-bottom: 4px">
            <tr style="background-color: #5c636a; font-size: 10px; color: white">
                <th>SL</th>
                <th>Date</th>
                <th>IN</th>
                <th>OUT</th>
                <th>Duty Hour <sub>(hour)</sub></th>
                <th>Status</th>
                <th>Remarks</th>
            </tr>
            @foreach($attendanceData as $date => $data)
                <tr style="font-size: 10px">
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($date)->format('d-M-Y') }}</td>
                    <td>
                    @if ($data->isEmpty())
                            <div>-</div>
                    @else
                            @foreach ($data as $att)
                                <div>{{ \Carbon\Carbon::parse($att->clock_in)->format('H:i a')  }} - Just In Time</div>
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if ($data->isEmpty())
                            <div>-</div>
                        @else
                            @foreach ($data as $att)
                                @if($att->clock_out)
                                <div>{{ \Carbon\Carbon::parse($att->clock_out)->format('H:i a') }} - Just Out Time</div>
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
                                <div>{{ $att->working_time ?? '-' }}</div>
                            @endforeach
                        @endif
                    </td>
                    <td>@if ($data->isEmpty()) <div>A</div> @else <div>P</div> @endif </td>
                    <td>
                        @php
                            $carbonDate = ($date instanceof \Illuminate\Support\Carbon) ? $date : \Illuminate\Support\Carbon::parse($date);
                        @endphp
                        @if ($carbonDate->dayOfWeek === \Illuminate\Support\Carbon::FRIDAY)
                            <div>Friday</div>
                        @endif
                        @if(in_array(\Carbon\Carbon::parse($date)->format('Y-m-d'),$holidayDates))
                            @php
                                $holiday = \App\Models\Holiday::whereJsonContains('dates',\Carbon\Carbon::parse($date)->format('Y-m-d'))->where('status',1)->first();
                            @endphp
                            @if($holiday)
                                <div class="">HOLIDAY - {{$holiday->name}}</div>
                            @endif
                        @endif
                        @if(in_array(\Carbon\Carbon::parse($date)->format('Y-m-d'),$leaveDates))
                            <div class=""> Leave </div>
                        @endif

                    </td>


                </tr>
            @endforeach
        </table>
    </div>
    <div class="floating-button">
        <form action="{{ route('admin.attendance.details.download') }}" method="get">
            @csrf
            <input type="hidden" name="month" value="{{ $month }}">
            <input type="hidden" name="year" value="{{ $year }}">
            <input type="hidden" name="user_id" value="{{ $user->id }}">
            <button class="btn btn-black" style="position: absolute; bottom: 0px; right: 0;">Download</button>
        </form>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</body>
</html>



