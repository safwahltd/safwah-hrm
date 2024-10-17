@extends('employee.layout.app')
@section('title','My Attendance')
@section('body')
    <div class="row align-items-center">
        <div class="border-0 mb-4">
            <div class="card-header py-3 no-bg bg-transparent d-flex align-items-center px-0 justify-content-between border-bottom flex-wrap">
                <h3 class="fw-bold mb-0 text-white">Attendance Report</h3>
            </div>
        </div>
    </div>
    <!-- Row end  -->

    <div class="row clearfix g-3">
        <div class="col-sm-12 p-2" style="background-color: #ffffff">
            <div class="mb-3">
                <div id='calendar' class="text-black"></div>
                {{--<div class="table-responsive">
                    <table id="myProjectTable" class="table table-hover table-striped align-middle mb-0" style="width:100%">
                        @foreach($datess as $date)
                            <tr>
                                    <th>{{ $date }}</th>
                                    @php
                                        $attendances = \App\Models\Attendance::where('clock_in_date',\Illuminate\Support\Carbon::parse($date)->format('Y-m-d'))->where('user_id', auth()->user()->id)->get();
                                    @endphp
                                    <td>
                                        @if($attendances)
                                            @foreach($attendances as $attendance)
                                                <span class="text-success"><i class="fa mx-2 {{ $attendance->clock_in ? 'fa-check': 'fa-xmark' }} "></i> Clock In : {{ $attendance->clock_in ? \Illuminate\Support\Carbon::parse($attendance->clock_in)->format('H:i:s A'): 'fa-xmark' }}</span>
                                                <br>
                                                <span class="text-danger"><i class="fa mx-2 {{ $attendance->clock_out ? 'fa-check': 'fa-xmark' }} "></i> Clock Out : {{ $attendance->clock_out ? \Illuminate\Support\Carbon::parse($attendance->clock_out)->format('H:i:s A'): '' }}</span>
                                                <br>
                                            @endforeach
                                        @else
                                            <span class="text-success mx-2"><i class="fa fa-xmark"></i></span>
                                            <span class="text-danger"><i class="fa fa-xmark"></i></span>
                                        @endif
                                    </td>
                                </tr>
                        @endforeach
                    </table>
                    <div class="text-white my-3 d-grid justify-content-center">
--}}{{--                        {{$attendances->links()}}--}}{{--
                    </div>
                </div>--}}
            </div>
        </div>
    </div>
    <!-- Row End -->
@endsection
@push('js')
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
@endpush
