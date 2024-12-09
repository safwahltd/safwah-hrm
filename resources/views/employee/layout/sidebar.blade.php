@if(auth()->user()->hasPermission('employee attendance list'))
<li class="collapsed">
    <a class="m-link {{ Request::route()->getName() == 'employee.attendance.list' ? 'active':''}}" href="{{route('employee.attendance.list')}}">
        <i class="icofont-clip-board "></i> <span> Attendance </span>
    </a>
</li>
@endif
@if(auth()->user()->hasPermission('employee salary index'))
<li class="collapsed">
    <a class="m-link {{ Request::route()->getName() == 'employee.salary.index' ? 'active':''}}" href="{{route('employee.salary.index')}}">
        <i class="icofont-money "></i> <span> Salary </span>
    </a>
</li>
@endif
@if(auth()->user()->hasPermission('employee advance money index'))
<li class="collapsed">
    <a class="m-link {{ Request::route()->getName() == 'employee.advance.money.index' ? 'active':''}}" href="{{route('employee.advance.money.index')}}">
        <i class="icofont-money "></i> <span> Money Receipts</span>
    </a>
</li>
@endif
@if(auth()->user()->hasPermission('employee holiday index'))
<li class="collapsed">
    <a class="m-link {{ Request::route()->getName() == 'employee.holiday.index' ? 'active':''}}" href="{{route('employee.holiday.index')}}">
        <i class="icofont-calendar "></i> <span> Holidays </span>
    </a>
</li>
@endif
@if(auth()->user()->hasPermission('employee leave'))
<li class="collapsed">
    <a class="m-link {{ Request::route()->getName() == 'employee.leave' ? 'active':''}}" href="{{route('employee.leave')}}">
        <i class="icofont-ui-calendar "></i> <span> Leave </span>
    </a>
</li>
@endif
@if(auth()->user()->hasPermission('employee profile details') )
<li class="collapsed">
    <a class="m-link {{--{{ Request::route()->getName() == 'employee.profile.details' ? 'active':''}}--}}" data-bs-toggle="collapse" data-bs-target="#client-Components" href="#"><i class="icofont-address-book fs-5 "></i> <span>Account Details</span> <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span></a>
    <!-- Menu: Sub menu ul -->
    <ul class="sub-menu collapse {{ Request::route()->getName() == 'employee.profile.details' ? 'show':''}}" id="client-Components">
        <li><a class="ms-link {{ Request::route()->getName() == 'employee.profile.details' ? 'active':''}}" href="{{route('employee.profile.details')}}"> <span>Profile</span></a></li>
    </ul>
</li>
@endif
