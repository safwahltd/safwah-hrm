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
                <a class="m-link" href="{{route('admin.dashboard')}}">
                    <i class="icofont-home fs-5"></i> <span> Dashboard </span>
                </a>
            </li>
            <li  class="collapsed">
                <a class="m-link
                        {{ Request::route()->getName() == 'holidays.index' ? 'active':''}}
                        {{ Request::route()->getName() == 'departments.index' ? 'active':''}}
                        {{ Request::route()->getName() == 'designations.index' ? 'active':''}}
                    "  data-bs-toggle="collapse" data-bs-target="#project-Components" href="#">
                    <i class="icofont-briefcase"></i><span>Employees</span> <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span></a>
                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse {{ Request::route()->getName() == 'holidays.index' ? 'show':''}}
                {{ Request::route()->getName() == 'departments.index' ? 'show':''}}
                {{ Request::route()->getName() == 'designations.index' ? 'show':''}}
                {{ Request::route()->getName() == 'employees.index' ? 'show':'' }}
                {{ Request::route()->getName() == 'admin.attendance.report' ? 'show':'' }}
                {{ Request::route()->getName() == 'admin.attendance.list' ? 'show':'' }}
                {{ Request::route()->getName() == 'admin.leave.type' ? 'show':'' }}
                    " id="project-Components">
                    <li><a class="ms-link {{ Request::route()->getName() == 'employees.index' ? 'active':'' }}" href="{{route('employees.index')}}"><span>Members</span></a></li>
                    <li><a class="ms-link {{ Request::route()->getName() == 'holidays.index' ? 'active':'' }}" href="{{route('holidays.index')}}"><span>Holidays</span></a></li>
                    <li><a class="ms-link {{ Request::route()->getName() == 'admin.attendance.list' ? 'active':'' }}" href="{{route('admin.attendance.list')}}"><span>Attendance</span></a></li>
                    <li><a class="ms-link {{ Request::route()->getName() == 'admin.attendance.report' ? 'active':'' }}" href="{{route('admin.attendance.report')}}"><span>Attendance Report</span></a></li>
                    <li class="collapsed">
                        <a class="ms-link {{ Request::route()->getName() == 'assets.index' ? 'active':'' }}" data-bs-toggle="collapse" data-bs-target="#leave" href="#">
                            <span>Leave</span> <span class="arrow icofont-dotted-down ms-auto text-end"></span>
                        </a>
                        <!-- Menu: Sub menu ul -->
                        <ul class="sub-menu collapse  {{ Request::route()->getName() == 'assets.index' ? 'show':''}} {{ Request::route()->getName() == 'employees.index' ? 'show':'' }}" id="leave">
                            <li><a class="ms-link {{ Request::route()->getName() == 'assets.index' ? 'active':'' }}" href="{{route('assets.index')}}"> <span>Leave Request</span></a></li>
                            <li><a class="ms-link {{ Request::route()->getName() == 'admin.leave.type' ? 'active':'' }}" href="{{route('admin.leave.type')}}"> <span>Leave Type</span></a></li>
                        </ul>
                    </li>
                    <li class=""><a class="ms-link {{ Request::route()->getName() == 'departments.index' ? 'active':'' }}" href="{{route('departments.index')}}"><span>Departments</span></a></li>
                    <li><a class="ms-link {{ Request::route()->getName() == 'designations.index' ? 'active':'' }}" href="{{route('designations.index')}}"><span>Designation</span></a></li>
                    <li><a class="ms-link" href="#"><span>Termination</span></a></li>
                </ul>
            </li>

            <li class="collapsed">
                <a class="m-link" data-bs-toggle="collapse" data-bs-target="#tikit-Components" href="#"><i
                        class="icofont-ticket"></i> <span>HR</span> <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span>
                </a>
                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse" id="tikit-Components">
                    <li class="collapsed">
                        <a class="ms-link" data-bs-toggle="collapse" data-bs-target="#employee" href="#">
                            <i class="icofont-ticket"></i> <span>Accounts</span> <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span>
                        </a>
                        <ul class="sub-menu collapse" id="employee">
                            <li><a class="ms-link" href="tickets.html"><span> Employee salary</span></a></li>
                            <li><a class="ms-link" href="tickets.html"><span> Sales Invoice </span></a></li>
                            <li><a class="ms-link" href="tickets.html"><span> Expenses </span></a></li>
                        </ul>
                    </li>
                    <li class="collapsed">
                    <a class="ms-link" data-bs-toggle="collapse" data-bs-target="#reports" href="#">
                        <i class="icofont-ticket"></i> <span>Reports</span> <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span>
                        </a>
                        <ul class="sub-menu collapse" id="reports">
                            <li><a class="ms-link" href="tickets.html"><span> Expenses Report </span></a></li>
                            <li><a class="ms-link" href="tickets.html"><span> Payments Report </span></a></li>
                            <li><a class="ms-link" href="tickets.html"><span> User Report </span></a></li>
                            <li><a class="ms-link" href="tickets.html"><span> Payslip Report </span></a></li>
                            <li><a class="ms-link" href="tickets.html"><span> Attendance Report </span></a></li>
                            <li><a class="ms-link" href="tickets.html"><span> Leave Report </span></a></li>
                            <li><a class="ms-link" href="tickets.html"><span> Daily Report </span></a></li>
                        </ul>
                    </li>
                    <li><a class="ms-link" href="ticket-detail.html"><i class="icofont-police"></i> <span>Policies</span></a></li>
                    <li><a class="ms-link" href="ticket-detail.html"><i class="icofont-notification"></i> <span>Announce</span></a></li>
                </ul>
            </li>
            <li class="collapsed">
                <a class="m-link {{ Request::route()->getName() == 'assets.index' ? 'active':'' }}" data-bs-toggle="collapse" data-bs-target="#client-Components" href="#"><i
                        class="icofont-user-male"></i> <span>Administration</span> <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span></a>
                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse  {{ Request::route()->getName() == 'assets.index' ? 'show':''}} {{ Request::route()->getName() == 'employees.index' ? 'show':'' }}" id="client-Components">
                    <li><a class="ms-link {{ Request::route()->getName() == 'assets.index' ? 'active':'' }}" href="{{route('assets.index')}}"> <span>Assets</span></a></li>
                    {{--<li><a class="ms-link " href=""> <span> Users </span></a></li>--}}
                    <li class="collapsed">
                        <a class="ms-link" data-bs-toggle="collapse" data-bs-target="#settings" href="#">
                            <i class="icofont-ticket"></i> <span>Settings</span> <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span>
                        </a>
                        <ul class="sub-menu collapse" id="settings">
                            <li><a class="ms-link" href="tickets.html"><span> Company Settings </span></a></li>
                            <li><a class="ms-link" href="tickets.html"><span> Theme Settings </span></a></li>
                            <li><a class="ms-link" href="tickets.html"><span> Roles And Permissions </span></a></li>
                            <li><a class="ms-link" href="tickets.html"><span> Email Settings </span></a></li>
                            <li><a class="ms-link" href="tickets.html"><span> Invoice Settings  </span></a></li>
                            <li><a class="ms-link" href="tickets.html"><span> Notification Settings </span></a></li>
                            <li><a class="ms-link" href="tickets.html"><span> Change Password </span></a></li>
                            <li><a class="ms-link" href="tickets.html"><span> Leave Type </span></a></li>
                        </ul>
                    </li>
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