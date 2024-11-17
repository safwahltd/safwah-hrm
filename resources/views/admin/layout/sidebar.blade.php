<div class="sidebar px-4 py-4 py-md-5 me-0" style="background-color: #1a1d20">
    <div class="d-flex flex-column h-100" >
        <a href="{{route('admin.dashboard')}}" class="mb-0 text-center">
            <span class="logo-icon">
{{--                <img width="200" src="{{asset('/')}}admin/assets/logo.png" alt="" class="img-responsive">--}}
                <h5 class="text-white fw-bold">SAFWAH LIMITED</h5>
            </span>
        </a>
        <!-- Menu: main ul -->

        <ul class="menu-list flex-grow-1 mt-3">
            <li class="collapsed">
                <a class="m-link {{ Request::route()->getName() == 'admin.dashboard' ? 'active':''}}" id="dashboard" href="{{route('admin.dashboard')}}">
                    <i class="icofont-home"></i> <span> Dashboard </span>
                </a>
            </li>
            @if(auth()->user()->role =='employee')
                    <li class="collapsed">
                        <a class="m-link {{ Request::route()->getName() == 'employee.attendance.list' ? 'active':''}}" href="{{route('employee.attendance.list')}}">
                            <i class="icofont-clip-board "></i> <span> Attendance </span>
                        </a>
                    </li>
                    <li class="collapsed">
                        <a class="m-link {{ Request::route()->getName() == 'employee.attendance.report' ? 'active':''}}" href="{{route('employee.attendance.report')}}">
                            <i class="icofont-clip-board "></i> <span> Attendance Report</span>
                        </a>
                    </li>
                    <li class="collapsed">
                        <a class="m-link {{ Request::route()->getName() == 'employee.salary.index' ? 'active':''}}" href="{{route('employee.salary.index')}}">
                            <i class="icofont-money "></i> <span> Salary </span>
                        </a>
                    </li>
                    <li class="collapsed">
                        <a class="m-link {{ Request::route()->getName() == 'employee.holiday.index' ? 'active':''}}" href="{{route('employee.holiday.index')}}">
                            <i class="icofont-calendar "></i> <span> Holidays </span>
                        </a>
                    </li>
                    <li class="collapsed">
                        <a class="m-link {{ Request::route()->getName() == 'employee.leave' ? 'active':''}}" href="{{route('employee.leave')}}">
                            <i class="icofont-ui-calendar "></i> <span> Leave </span>
                        </a>
                    </li>
                    <li class="collapsed">
                        <a class="m-link {{--{{ Request::route()->getName() == 'employee.profile.details' ? 'active':''}}--}}" data-bs-toggle="collapse" data-bs-target="#client-Components" href="#"><i class="icofont-address-book fs-5 "></i> <span>Account Details</span> <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span></a>
                        <!-- Menu: Sub menu ul -->
                        <ul class="sub-menu collapse {{ Request::route()->getName() == 'employee.profile.details' ? 'show':''}}" id="client-Components">
                            <li><a class="ms-link {{ Request::route()->getName() == 'employee.profile.details' ? 'active':''}}" href="{{route('employee.profile.details')}}"> <span>Profile</span></a></li>
                        </ul>
                    </li>

            @endif
            @if(auth()->user()->hasPermission('holidays index')
                || auth()->user()->hasPermission('departments index')
                || auth()->user()->hasPermission('designations index')
                || auth()->user()->hasPermission('employees index')
                ||  auth()->user()->hasPermission('admin attendance report')
                || auth()->user()->hasPermission('admin attendance list')
                || auth()->user()->hasPermission('admin leave requests')
                || auth()->user()->hasPermission('admin termination index'))
                <li  class="collapsed">
                <a class="m-link"  data-bs-toggle="collapse" data-bs-target="#employees" href="#">
                    <i class="icofont-briefcase"></i><span>Employees</span> <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span></a>
                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse
                {{ Request::route()->getName() == 'holidays.index' ? 'show':''}}
                {{ Request::route()->getName() == 'departments.index' ? 'show':''}}
                {{ Request::route()->getName() == 'designations.index' ? 'show':''}}
                {{ Request::route()->getName() == 'employees.index' ? 'show':'' }}
                {{ Request::route()->getName() == 'admin.attendance.list' ? 'show':'' }}
                {{ Request::route()->getName() == 'admin.leave.requests' ? 'show':'' }}
                {{ Request::route()->getName() == 'admin.termination.index' ? 'show':'' }}
                    " id="employees">
                    @if(auth()->user()->hasPermission('employees index'))
                    <li><a class="ms-link {{ Request::route()->getName() == 'employees.index' ? 'active':'' }}" href="{{route('employees.index')}}"><span>Members</span></a></li>
                    @endif
                    @if(auth()->user()->hasPermission('holidays index'))
                            <li><a class="ms-link {{ Request::route()->getName() == 'holidays.index' ? 'active':'' }}" href="{{route('holidays.index')}}"><span>Holidays</span></a></li>
                    @endif
                    @if(auth()->user()->hasPermission('admin attendance list'))
                            <li><a class="ms-link {{ Request::route()->getName() == 'admin.attendance.list' ? 'active':'' }}" href="{{route('admin.attendance.list')}}"><span>Attendance</span></a></li>
                    @endif
                    @if(auth()->user()->hasPermission('admin attendance details'))
                            <li><a class="ms-link {{ Request::route()->getName() == 'admin.attendance.details' ? 'active':'' }}" href="{{route('admin.attendance.details')}}"><span>Attendance Details</span></a></li>
                    @endif

                    @if(auth()->user()->hasPermission('admin leave requests'))
                        <li><a class="ms-link {{ Request::route()->getName() == 'admin.leave.requests' ? 'active':'' }}" href="{{route('admin.leave.requests')}}"><span>Leave Request</span></a></li>
                    @endif
                    @if(auth()->user()->hasPermission('departments index'))
                        <li class=""><a class="ms-link {{ Request::route()->getName() == 'departments.index' ? 'active':'' }}" href="{{route('departments.index')}}"><span>Departments</span></a></li>
                     @endif
                    @if(auth()->user()->hasPermission('designations index'))
                        <li><a class="ms-link {{ Request::route()->getName() == 'designations.index' ? 'active':'' }}" href="{{route('designations.index')}}"><span>Designation</span></a></li>
                    @endif
                    @if(auth()->user()->hasPermission('admin termination index'))
                        <li><a class="ms-link {{ Request::route()->getName() == 'admin.termination.index' ? 'active':'' }}"  href="{{route('admin.termination.index')}}"><span>Termination</span></a></li>
                    @endif
                </ul>
            </li>
            @endif
            @if(auth()->user()->hasPermission('admin salary index')
                || auth()->user()->hasPermission('admin salary payment index'))
                <li class="collapsed">
                    <a class="m-link"  data-bs-toggle="collapse" data-bs-target="#accounts" href="#">
                        <i class="icofont-bank"></i><span>Accounts</span> <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span></a>
                    <!-- Menu: Sub menu ul -->
                    <ul class="sub-menu collapse
                {{ Request::route()->getName() == 'admin.salary.index' ? 'show':''}}
                    {{ Request::route()->getName() == 'admin.salary.payment.index' ? 'show':''}}
                        " id="accounts">
                        @if(auth()->user()->hasPermission('admin salary index'))
                        <li><a class="ms-link {{ Request::route()->getName() == 'admin.salary.index' ? 'active':'' }}" href="{{route('admin.salary.index')}}"><span> Employee salary</span></a></li>
                        @endif

                        @if(auth()->user()->hasPermission('admin salary payment index'))
                        <li><a class="ms-link {{ Request::route()->getName() == 'admin.salary.payment.index' ? 'active':''}}" href="{{route('admin.salary.payment.index')}}"><span> Salary Payment</span></a></li>
                        @endif
                        {{--<li><a class="ms-link" href="#"><span> Sales Invoice </span></a></li>

                        <li><a class="ms-link" href="#"><span> Billings </span></a></li>--}}
                            <li><a class="ms-link" href="#"><span> Expense </span></a></li>

                    </ul>
                </li>
            @endif
            @if(auth()->user()->hasPermission('admin notice index')
                || auth()->user()->hasPermission('asset index')
                || auth()->user()->hasPermission('admin daily report')
                || auth()->user()->hasPermission('admin leave report')
                || auth()->user()->hasPermission('admin attendance report')
                || auth()->user()->hasPermission('admin salary report')
                )
                <li class="collapsed">
                    <a class="m-link" data-bs-toggle="collapse" data-bs-target="#tikit-Components" href="#"><i
                            class="icofont-ticket"></i> <span>HR</span> <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span>
                    </a>
                    <!-- Menu: Sub menu ul -->
                    <ul class="sub-menu collapse
                {{ Request::route()->getName() == 'admin.notice.index' ? 'show':'' }}
                    {{ Request::route()->getName() == 'asset.index' ? 'show':'' }}
                    {{ Request::route()->getName() == 'admin.daily.report' ? 'show':'' }}
                    {{ Request::route()->getName() == 'admin.leave.report' ? 'show':'' }}
                    {{ Request::route()->getName() == 'admin.attendance.report' ? 'show':'' }}
                    {{ Request::route()->getName() == 'admin.asset.report' ? 'show':'' }}
                    {{ Request::route()->getName() == 'admin.salary.report' ? 'show':'' }}
                    {{ Request::route()->getName() == 'admin.leave.management' ? 'show':'' }}
                    {{ Request::route()->getName() == 'admin.workingDay.index' ? 'show':'' }}
                        " id="tikit-Components">
                        <li class="collapsed">
                            <a class="ms-link" data-bs-toggle="collapse" data-bs-target="#reports" href="#">
                                <i class="icofont-ticket"></i> <span>Reports</span> <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span>
                            </a>
                            <ul class="sub-menu collapse
                                {{ Request::route()->getName() == 'admin.daily.report' ? 'show':'' }}
                                {{ Request::route()->getName() == 'admin.leave.report' ? 'show':'' }}
                                {{ Request::route()->getName() == 'admin.asset.report' ? 'show':'' }}
                                {{ Request::route()->getName() == 'admin.attendance.report' ? 'show':'' }}
                                {{ Request::route()->getName() == 'admin.salary.report' ? 'show':'' }}
                                " id="reports">
                                <li><a class="ms-link" href="#"><span> Expenses Report </span></a></li>
                                @if(auth()->user()->hasPermission('admin salary report'))
                                <li><a class="ms-link {{ Request::route()->getName() == 'admin.salary.report' ? 'active':'' }}" href="{{route('admin.salary.report')}}"><span> Salary Report </span></a></li>
                                @endif
                                <li><a class="ms-link" href="#"><span> User Report </span></a></li>
                                @if(auth()->user()->hasPermission('admin asset report'))
                                <li><a class="ms-link {{ Request::route()->getName() == 'admin.asset.report' ? 'active':'' }}" href="{{route('admin.asset.report')}}"><span> Assets Report </span></a></li>
                                @endif
                                @if(auth()->user()->hasPermission('admin payslip report'))
                                <li><a class="ms-link" href="#"><span> Payslip Report </span></a></li>
                                @endif
                                @if(auth()->user()->hasPermission('admin attendance report'))
                                    <li><a class="ms-link {{ Request::route()->getName() == 'admin.attendance.report' ? 'active':'' }}" href="{{route('admin.attendance.report')}}"><span>Attendance Report</span></a></li>
                                @endif
                                @if(auth()->user()->hasPermission('admin leave report'))
                                    <li><a class="ms-link {{ Request::route()->getName() == 'admin.leave.report' ? 'active':'' }}" href="{{route('admin.leave.report')}}"><span>Leave Report</span></a></li>
                                @endif
                                @if(auth()->user()->hasPermission('admin daily report'))
                                <li><a class="ms-link {{ Request::route()->getName() == 'admin.daily.report' ? 'active':'' }}" href="{{ route('admin.daily.report') }}"><span> Daily Report </span></a></li>
                                @endif
                            </ul>
                        </li>
                        <li><a class="ms-link" href="#"><i class="icofont-police"></i> <span>Policies</span></a></li>
                        @if(auth()->user()->hasPermission('admin notice index'))
                        <li><a class="ms-link {{ Request::route()->getName() == 'admin.notice.index' ? 'active':'' }}" href="{{route('admin.notice.index')}}"><i class="icofont-notification"></i> <span>Announce</span></a></li>
                        @endif
                        @if(auth()->user()->hasPermission('asset index'))
                        <li><a class="ms-link {{ Request::route()->getName() == 'asset.index' ? 'active':'' }}" href="{{route('asset.index')}}"> <i class="icofont-address-book"></i> <span>Assets</span></a></li>
                        @endif
                        @if(auth()->user()->hasPermission('admin workingDay index'))
                        <li><a class="ms-link {{ Request::route()->getName() == 'admin.workingDay.index' ? 'active':'' }}" href="{{route('admin.workingDay.index')}}"> <i class="icofont-address-book"></i> <span>Working Day</span></a></li>
                        @endif
                        @if(auth()->user()->hasPermission('admin leave management'))
                        <li><a class="ms-link {{ Request::route()->getName() == 'admin.leave.management' ? 'active':'' }}" href="{{route('admin.leave.management')}}"> <i class="icofont-leaf"></i> <span>Leave Management</span></a></li>
                        @endif

                    </ul>
                </li>
            @endif
            @if(auth()->user()->hasPermission('admin settings index') || auth()->user()->hasPermission('admin role index')
                || auth()->user()->hasPermission('admin permission index')
                || auth()->user()->hasPermission('admin user role')
                )
                <li class="collapsed">
                    <a class="m-link" data-bs-toggle="collapse" data-bs-target="#administration" href="#"><i
                            class="icofont-user-male"></i> <span>Administration</span> <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span></a>
                    <!-- Menu: Sub menu ul -->
                    <ul class="sub-menu collapse
                        {{ Request::route()->getName() == 'admin.settings.index' ? 'show':''}}
                    {{ Request::route()->getName() == 'admin.role.index' ? 'show':''}}
                    {{ Request::route()->getName() == 'admin.permission.index' ? 'show':''}}
                    {{ Request::route()->getName() == 'admin.user.role' ? 'show':''}}
                    {{ Request::route()->getName() == 'admin.password.index' ? 'show':''}}
                    {{ Request::route()->getName() == 'admin.user.password.index' ? 'show':''}}
                        " id="administration">
                        @if(auth()->user()->hasPermission('admin settings index') || auth()->user()->hasPermission('admin password index'))
                        <li class="collapsed">
                            <a class="ms-link" data-bs-toggle="collapse" data-bs-target="#settings" href="#">
                                <i class="icofont-ticket"></i> <span>Settings</span> <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span>
                            </a>
                            <ul class="sub-menu collapse {{ Request::route()->getName() == 'admin.settings.index' ? 'show':''}}
                                {{ Request::route()->getName() == 'admin.password.index' ? 'show':''}}
                                {{ Request::route()->getName() == 'admin.user.password.index' ? 'show':''}}
                                " id="settings">
                                <li><a class="ms-link {{ Request::route()->getName() == 'admin.settings.index' ? 'active':''}}" href="{{route('admin.settings.index')}}"><span> Company Settings </span></a></li>
{{--                                <li><a class="ms-link" href="#"><span> Theme Settings </span></a></li>--}}
{{--                                <li><a class="ms-link" href="#"><span> Email Settings </span></a></li>--}}
                                @if(auth()->user()->hasPermission('admin password index'))
                                <li><a class="ms-link {{ Request::route()->getName() == 'admin.password.index' ? 'active':''}}" href="{{route('admin.password.index')}}"><span> Change Password </span></a></li>
                                @endif
                                @if(auth()->user()->hasPermission('admin user password index'))
                                    <li><a href="{{route('admin.user.password.index')}}" class="ms-link {{ Request::route()->getName() == 'admin.user.password.index' ? 'active':''}}">Change User Password</a></li>
                                @endif
                                {{--                            <li><a class="ms-link" href="#"><span> Leave Type </span></a></li>--}}
                            </ul>
                        </li>
                        @endif
                        @if(auth()->user()->hasPermission('admin role index') || auth()->user()->hasPermission('admin permission index') || auth()->user()->hasPermission('admin user role'))
                                <li class="collapsed">
                                    <a class="ms-link" data-bs-toggle="collapse" data-bs-target="#rolePermissions" href="#">
                                        <i class="icofont-ticket"></i> <span>Role Permission</span> <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span>
                                    </a>
                                    <ul class="sub-menu collapse
                                    {{ Request::route()->getName() == 'admin.role.index' ? 'show':''}}
                                    {{ Request::route()->getName() == 'admin.permission.index' ? 'show':''}}
                                    {{ Request::route()->getName() == 'admin.user.role' ? 'show':''}}
                                        " id="rolePermissions">
                                        @if(auth()->user()->hasPermission('admin role index'))
                                            <li><a class="ms-link {{ Request::route()->getName() == 'admin.role.index' ? 'active':''}}" href="{{route('admin.role.index')}}"><span> Roles </span></a></li>
                                        @endif
                                        @if(auth()->user()->hasPermission('admin permission index'))
                                            <li><a href="{{route('admin.permission.index')}}" class="ms-link {{ Request::route()->getName() == 'admin.permission.index' ? 'active':''}}">Permission</a></li>
                                        @endif
                                        @if(auth()->user()->hasPermission('admin user role'))
                                            <li><a href="{{route('admin.user.role')}}" class="ms-link {{ Request::route()->getName() == 'admin.user.role' ? 'active':''}}">User Roles</a></li>
                                        @endif


                                    </ul>
                                </li>
                        @endif
                    </ul>
                </li>
            @endif

            {{--<li class="collapsed">
                <a class="m-link {{ Request::route()->getName() == 'admin.chat.index' ? 'active':''}}" href="{{route('admin.chat.index')}}">
                    <i class="icofont-home fs-5"></i> <span> Chat </span>
                </a>
            </li>--}}
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
