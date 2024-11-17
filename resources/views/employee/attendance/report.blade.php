@extends('admin.layout.app')
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
                eventTextColor: 'black',
            });

            calendar.render();
        });
    </script>

@endpush
