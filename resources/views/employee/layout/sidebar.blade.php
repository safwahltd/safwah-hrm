<div class="sidebar px-4 py-4 py-md-5 me-0">
    <div class="d-flex flex-column h-100">
        <a href="{{route('admin.dashboard')}}" class="mb-0 text-center">
            <span class="logo-icon">
                <img width="200" src="{{asset('/')}}admin/assets/logo.png" alt="" class="img-responsive">
            </span>
        </a>
        <!-- Menu: main ul -->

        <ul class="menu-list flex-grow-1 mt-3">
            <li class="collapsed">
                <a class="m-link" href="{{route('employee.dashboard')}}">
                    <i class="icofont-home fs-5"></i> <span> Dashboard </span>
                </a>
            </li>
            <li class="collapsed">
                <a class="m-link" href="{{route('employee.attendance.list')}}">
                    <i class="fa-solid fa-clipboard-user fs-5 me-3"></i> <span> Attendance </span>
                </a>
            </li>
            <li class="collapsed">
                <a class="m-link" href="{{route('employee.attendance.report')}}">
                    <i class="fa-solid fa-clipboard-user fs-5 me-3"></i> <span> Attendance Report</span>
                </a>
            </li>
            <li class="collapsed">
                <a class="m-link" href="{{route('employee.dashboard')}}">
                    <i class="fa-solid fa-hand-holding-dollar fs-5 me-3"></i> <span> Salary </span>
                </a>
            </li>
            <li class="collapsed">
                <a class="m-link" href="{{route('employee.holiday.index')}}">
                    <i class="fa-solid fa-h fs-5 me-3"></i> <span> Holidays </span>
                </a>
            </li>
            <li class="collapsed">
                <a class="m-link" href="{{route('employee.dashboard')}}">
                    <i class="fa-solid fa-person-walking-arrow-right fs-5 me-3"></i> <span> Leave </span>
                </a>
            </li>

            <li class="collapsed">
                <a class="m-link" data-bs-toggle="collapse" data-bs-target="#client-Components" href="#"><i class="fa-solid fa-clipboard-user fs-5 me-3"></i> <span>Account Details</span> <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span></a>
                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse" id="client-Components">
                    <li><a class="ms-link" href="{{route('employee.profile.details')}}"> <span>Profile</span></a></li>
                    <li><a class="ms-link " href="#"> <span> Password Change</span></a></li>
                    {{--<li><a class="ms-link " href=""> <span> Personal Info </span></a></li>
                    <li><a class="ms-link " href=""> <span> Bank Info </span></a></li>
                    <li><a class="ms-link " href=""> <span> Family Info </span></a></li>
                    <li><a class="ms-link " href=""> <span> Experience</span></a></li>--}}
                </ul>
            </li>
            <li class="collapsed">
                <a class="m-link" href="#">
                    <i class="icofont-home fs-5"></i> <span> Chat </span>
                </a>
            </li>
            <li class="collapsed">
                <a class="m-link" onclick="return confirm('are you sure to logout ?') ? document.getElementById('logoutSideBar').submit():''">
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
