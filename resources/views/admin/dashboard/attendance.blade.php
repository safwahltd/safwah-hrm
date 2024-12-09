<div class="col-6 my-1 text-center">
    <a href="{{route('admin.attendance.index')}}">
        <div class="card" style="background-color: #990055; width: 100%;">
            <div class="card-body">
                <i class="icofont-checked fs-3 text-white"></i>
                <h6 class="mt-3 mb-2 text-white fw-bold small-14"> Attendance</h6>
                <span class="text-white fs-4 fw-bold">{{ $totalAttend }}</span>
            </div>
        </div>
    </a>
</div>
<div class="col-6 my-1 text-center">
    <a href="{{route('admin.attendance.index')}}">
        <div class="card" style="background-color: #2c0b0e; width: 100%;">
            <div class="card-body ">
                <i class="icofont-stopwatch fs-3 text-white"></i>
                <h6 class="mt-3 mb-2 fw-bold small-14 text-white">Late Attendance</h6>
                <span class="text-white fs-4 fw-bold">{{ $totalLate }}</span>
            </div>
        </div>
    </a>
</div>
<div class="col-6 my-1 text-center">
    <a href="{{route('admin.attendance.index')}}">
        <div class="card" style="background-color: #000000; width: 100%;">
            <div class="card-body ">
                <i class="icofont-ban fs-3 text-white text-left"></i>
                <h6 class="mt-3 mb-2 fw-bold small-14 text-white">Absent</h6>
                <span class="text-white fs-4 fw-bold">{{ $totalAbsent }}</span>
            </div>
        </div>
    </a>
</div>
<div class="col-6 my-1 text-center">
    <a href="{{route('admin.leave.requests')}}">
        <div class="card" style="background-color: #ff253a; width: 100%;">
            <div class="card-body ">
                <i class="icofont-beach-bed fs-3 text-white"></i>
                <h6 class="mt-3 mb-2 fw-bold small-14 text-white">Leave Apply</h6>
                <span class="text-white fs-4 fw-bold">{{ $leaveApply }}</span>
            </div>
        </div>
    </a>
</div>
