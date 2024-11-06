@extends('admin.layout.app')
@section('title','Attendance Report')
@section('body')
    <style>
        label {
            display: inline-block;
            padding-bottom: 10px;
        }
    </style>
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Attendance Report</h3>
            </div>
        </div>
    </div>
    <!-- Row end  -->

    <div class="row clearfix g-3">
        <div class="col-sm-12">
            <div class="mb-3">
                <div class="text-end my-2">
                    <form method="GET" action="{{ route('admin.attendance.report.export') }}">
                        <input type="hidden" name="year" value="{{$year}}">
                        <input type="hidden" name="month" value="{{$month}}">
                        <input type="hidden" name="day" value="{{$day}}">
                        <button class="form-control-sm my-2 bg-primary text-white" type="submit"><i class="fa fa-download"></i> Download Report</button>
                    </form>
                    <form method="get" action="{{route('admin.attendance.report')}}">
                        <select class="form-control-sm" name="year" id="year">
                            @for($y = 2020; $y <= now()->year; $y++)
                                <option value="{{ $y }}" {{ $y == $year ? 'selected' : '' }}>{{ $y }}</option>
                            @endfor
                        </select>
                        <select class="form-control-sm"  name="month" id="month">
                            @for($m = 1; $m <= 12; $m++)
                                <option value="{{ $m }}" {{ $m == $month ? 'selected' : '' }}>
                                    {{ \Carbon\Carbon::createFromDate(null, $m)->format('F') }}
                                </option>
                            @endfor
                        </select>
                        <select class="form-control-sm"  name="day" id="day">
                            <option value="">All Days</option>
                            @for($d = 1; $d <= 31; $d++)
                                <option value="{{ $d }}" {{ $d == $day ? 'selected' : '' }}>{{ $d }}</option>
                            @endfor
                        </select>
                        <button class="form-control-sm text-white bg-success px-3"  type="submit">Filter</button>
                    </form>
                </div>

                <!-- Filter Form -->
                <div class="card-body table-responsive p-2 bg-dark-subtle">
                    <table id="basic-datatable" class="table table-bordered text-nowrap table-secondary key-buttons border-bottom w-100">
                        <thead>
                            <tr>
                                <th class="bg-success text-white">User</th>
                                @foreach($dates as $date)
                                    <th class="text-white bg-success" style="width: 200px">{{ $date }}</th>
                                @endforeach
                            </tr>
                        </thead>
                        <tbody>
                        @foreach($users as $user)
                            <tr>
                                <td class="bg-primary text-white"><a class="text-white" href="{{route('employee.profile',$user->id)}}">{{ $user->name }} <sub>({{ $user->userInfo->employee_id }})</sub></a></td>
                                @foreach($dates as $date)
                                    <td class="text-center">
                                        @php
                                            $attendance = $user->attendances->firstWhere('clock_in_date',$date);
                                        @endphp
                                        @if($attendance)
                                            <i class="fa fa-check text-success"></i> {{ Carbon\Carbon::parse($attendance->clock_in)->format('H:i') }} <br>
                                            @if($attendance->clock_out != '')
                                                <i class="fa fa-person-walking-arrow-right text-danger"></i>  {{ Carbon\Carbon::parse($attendance->clock_out)->format('H:i') }}
                                            @endif
                                        @else
                                            -
                                        @endif
                                    </td>
                                @endforeach
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <!-- Row End -->
@endsection
{{--@push('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var calendarEl = document.getElementById('calendar');

            var calendar = new FullCalendar.Calendar(calendarEl, {
                initialView: 'dayGridMonth',
                events: {
                    url: '{{ route('employee.attendance.report.event') }}',
                    method: 'GET',
                    failure: function() {
                        alert('There was an error fetching the events.');
                    }
                },
                eventContent: function(arg) {
                    // Customize event content
                    return {
                        html: `<div>${arg.event.title.replace(/, /g, '<br>')}</div>`
                    };
                },
                eventTimeFormat: {
                    hour: '2-digit',
                    minute: '2-digit',
                    meridiem: false
                },
                eventDisplay: 'auto',
                eventColor: '#378006',
                eventTextColor: 'white',
            });

            calendar.render();
        });
    </script>
@endpush--}}
