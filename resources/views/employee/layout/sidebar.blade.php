<div class="sidebar px-4 py-4 py-md-5 me-0" style="background-color: #1a1d20">
    <div class="d-flex flex-column h-100">
        <a href="{{route('admin.dashboard')}}" class="mb-0 text-center">
            <span class="logo-icon">
                <h5 class="text-white fw-bold">SAFWAH LIMITED</h5>
            </span>
        </a>
        <!-- Menu: main ul -->
        <ul class="menu-list flex-grow-1 mt-3">
            <li class="collapsed">
                <a class="m-link {{ Request::route()->getName() == 'employee.dashboard' ? 'active':''}}" href="{{route('employee.dashboard')}}">
                    <i class="icofont-home fs-5"></i> <span> Dashboard </span>
                </a>
            </li>
            <li class="collapsed">
                <a class="m-link {{ Request::route()->getName() == 'employee.attendance.list' ? 'active':''}}" href="{{route('employee.attendance.list')}}">
                    <i class="icofont-clip-board fs-5 "></i> <span> Attendance </span>
                </a>
            </li>
            <li class="collapsed">
                <a class="m-link {{ Request::route()->getName() == 'employee.attendance.report' ? 'active':''}}" href="{{route('employee.attendance.report')}}">
                    <i class="icofont-clip-board fs-5 "></i> <span> Attendance Report</span>
                </a>
            </li>
            <li class="collapsed">
                <a class="m-link {{--{{ Request::route()->getName() == 'employee.dashboard' ? 'active':''}}--}}" href="{{--{{route('employee.dashboard')}}--}}">
                    <i class="icofont-money fs-5 "></i> <span> Salary </span>
                </a>
            </li>
            <li class="collapsed">
                <a class="m-link {{ Request::route()->getName() == 'employee.holiday.index' ? 'active':''}}" href="{{route('employee.holiday.index')}}">
                    <i class="icofont-calendar fs-5 "></i> <span> Holidays </span>
                </a>
            </li>
            <li class="collapsed">
                <a class="m-link {{ Request::route()->getName() == 'employee.leave' ? 'active':''}}" href="{{route('employee.leave')}}">
                    <i class="icofont-ui-calendar fs-5 "></i> <span> Leave </span>
                </a>
            </li>

            <li class="collapsed">
                <a class="m-link {{--{{ Request::route()->getName() == 'employee.profile.details' ? 'active':''}}--}}" data-bs-toggle="collapse" data-bs-target="#client-Components" href="#"><i class="icofont-address-book fs-5 "></i> <span>Account Details</span> <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span></a>
                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse {{ Request::route()->getName() == 'employee.profile.details' ? 'show':''}}" id="client-Components">
                    <li><a class="ms-link {{ Request::route()->getName() == 'employee.profile.details' ? 'active':''}}" href="{{route('employee.profile.details')}}"> <span>Profile</span></a></li>
                </ul>
            </li>
            {{--<li class="collapsed">
                <a class="m-link" href="#">
                    <i class="icofont-chat fs-5"></i> <span> Chat </span>
                </a>
            </li>--}}
            <li class="collapsed">
                <a class="m-link btn" onclick="return confirm('are you sure to logout ?') ? document.getElementById('logoutSideBar').submit():''">
                    <i class="icofont-logout fs-5"></i> <span> Logout </span>
                </a>
                <form class="" id="logoutSideBar" action="{{ route('logout') }}" method="post">
                    @csrf
                    @method('POST')
                </form>
            </li>
        </ul>
        <!-- Menu: menu collepce btn -->
        <button type="button" class="btn btn-link sidebar-mini-btn text-light">
            <span class="ms-2"><i class="icofont-bubble-right"></i></span>
        </button>
    </div>
</div>
