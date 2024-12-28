<div class="col-md-3 col-6 my-1" align="center">
    <div class="attendance-details bg-success p-2 rounded-2">
        <h5 class="fw-bold text-white">{{$totalWorkingDay ?? 0}}</h5>
        <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Working Days</p>
    </div>
</div>
<div class="col-md-3 col-6 my-1" align="center">
    <div class="attendance-details bg-primary p-2 rounded-2">
        <h5 class="fw-bold text-white">{{$totalAttend ?? 0}}</h5>
        <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Total Attend</p>
    </div>
</div>
<div class="col-md-3 col-6 my-1" align="center">
    <div class="attendance-details p-2 rounded-2" style="background-color: #98427e">
        <h5 class="fw-bold text-white">{{$totalLate ?? 0}}</h5>
        <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Total Late</p>
    </div>
</div>
<div class="col-md-3 col-6 my-1" align="center">
    <div class="attendance-details bg-primary-gradient p-2 rounded-2">
        <h5 class="fw-bold text-white">{{ $totalAbsent ?? 0 }}</h5>
        <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Total Absent</p>
    </div>
</div>
<div class="col-md-3 col-6 my-1" align="center">
    <div class="attendance-details bg-dark-defualt p-2 rounded-2">
        <h5 class="fw-bold text-white">{{ $totalHolidays  ?? 0 }}</h5>
        <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Holidays</p>
    </div>
</div>
<div class="col-md-3 col-6 my-1" align="center">
    <div class="attendance-details p-2 rounded-2" style="background-color: blue">
        <h5 class="fw-bold text-white">{{ (($leave->sick ?? 0) + ($leave->casual ?? 0)) }}</h5>
        <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Total Leave</p>
    </div>
</div>
<div class="col-md-3 col-6 my-1" align="center">
    <div class="attendance-details p-2 rounded-2" style="background-color: orangered">
        <h5 class="fw-bold text-white">{{ (($leave->sick_spent ?? 0) + ($leave->casual_spent ?? 0)) }}</h5>
        <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Leaves Taken</p>
    </div>
</div>
<div class="col-md-3 col-6 my-1" align="center">
    <div class="attendance-details p-2 rounded-2" style="background-color: #006b60">
        <h5 class="fw-bold text-white">{{ (($leave->sick_left ?? 0) + ($leave->casual_left ?? 0)) }}</h5>
        <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Leaves Left</p>
    </div>
</div>
<div class="col-md-3 col-6 my-1" align="center">
    <div class="attendance-details p-2 rounded-2" style="background-color: #990055">
        <h5 class="fw-bold text-white">{{ $leaveBalance->half_day_total ?? 0}}</h5>
        <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Half Day</p>
    </div>
</div>
<div class="col-md-3 col-6 my-1" align="center">
    <div class="attendance-details p-2 rounded-2" style="background-color: #D63B38">
        <h5 class="fw-bold text-white">{{ $leaveBalance->spent_total ?? 0}}</h5>
        <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Half Day Spent</p>
    </div>
</div>
<div class="col-md-3 col-6 my-1" align="center">
    <div class="attendance-details p-2 rounded-2" style="background-color: olivedrab">
        <h5 class="fw-bold text-white">{{$leaveBalance->left_total ?? 0}}</h5>
        <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Half Day Left</p>
    </div>
</div>
<div class="col-md-3 col-6 my-1" align="center">
    <div class="attendance-details p-2 rounded-2" style="background-color: #444444">
        <h5 class="fw-bold text-white">{{ $totalAssets->count() ?? 0}}</h5>
        <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Total Asset</p>
    </div>
</div>
<div class="col-md-3 col-6 my-1" align="center">
    <div class="attendance-details p-2 rounded-2" style="background-color: #3788d8">
        <h5 class="fw-bold text-white">{{ number_format($totalAssets->sum('value')) ??  0}}</h5>
        <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Asset Value</p>
    </div>
</div>
<div class="col-md-3 col-6 my-1" align="center">
    <div class="attendance-details p-2 rounded-2" style="background-color: #7b5e3e">
        <h5 class="fw-bold text-white">{{ number_format($totalAdvanceAmount) ??  0 }}</h5>
        <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Advance Money</p>
    </div>
</div>
<div class="col-md-3 col-6 my-1" align="center">
    <div class="attendance-details p-2 rounded-2" style="background-color: #021e16">
        <h5 class="fw-bold text-white">{{number_format($totalMoneyAmount) ??  0}}</h5>
        <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Money Receipt</p>
    </div>
</div>
<div class="col-md-3 col-6 my-1" align="center">
    <div class="attendance-details p-2 rounded-2" style="background-color: #6c757d">
        <h5 class="fw-bold text-white">{{number_format($totalPayment) ??  0}}</h5>
        <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Payment</p>
    </div>
</div>
<div class="col-md-3 col-6 my-1" align="center">
    <div class="attendance-details p-2 rounded-2" style="background-color: #523e02">
        <h5 class="fw-bold text-white">
            @if($totalMoneyAmount < ($totalAdvanceAmount + $totalPayment))
                {{ $TOTaldue = number_format(str_replace('-','', (($totalAdvanceAmount + $totalPayment) - $totalMoneyAmount))) }}
            @else
                {{ $TOTaldue = 0 }}
            @endif
        </h5>
        <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Due</p>
    </div>
</div>
<div class="col-md-3 col-6 my-1" align="center">
    <div class="attendance-details p-2 rounded-2" style="background-color: #033b3a">
        <h5 class="fw-bold text-white">
            @php
                if($totalMoneyAmount > ($totalAdvanceAmount + $totalPayment)){
                    $t = $totalMoneyAmount - ($totalAdvanceAmount + $totalPayment );
                    }
                    else{
                        $t = 0;
                    }
            @endphp
            {{ number_format(str_replace('-','', ($t))) }}
        </h5>
        <p class="fw-bold text-uppercase text-white" style="font-size: 13px">Receivable</p>
    </div>
</div>
