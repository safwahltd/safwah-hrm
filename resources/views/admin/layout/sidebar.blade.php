<div class="sidebar px-4 py-4 py-md-5 me-0" style="background-color: #1a1d20">
    <div class="d-flex flex-column h-100" >
        <a href="{{route('admin.dashboard')}}" class="mb-0 text-center">
            <span class="logo-icon">
                <h5 class="text-white fw-bold text-uppercase">{{$setting->company_name}}</h5>
            </span>
        </a>
        <!-- Menu: main ul -->

        <ul class="menu-list flex-grow-1 mt-3">
            <li class="collapsed">
                <a class="m-link {{ Request::route()->getName() == 'admin.dashboard' ? 'active':''}}" id="dashboard" href="{{route('admin.dashboard')}}">
                    <i class="icofont-home"></i> <span> Dashboard </span>
                </a>
            </li>
            @if(auth()->user()->role != 'admin')
                @if(auth()->user()->hasPermission('hr dashboard'))
                <li class="collapsed">
                    <a class="m-link {{ Request::route()->getName() == 'hr.dashboard' ? 'active':'' }}" id="hrDashboard" href="{{route('hr.dashboard')}}">
                        <i class="icofont-group"></i> <span>HR Dashboard </span>
                    </a>
                </li>
                @endif
            @endif

            @if(auth()->user()->role =='employee')
                @include('employee.layout.sidebar')
            @endif
            @if(auth()->user()->hasPermission('admin holiday index')
                || auth()->user()->hasPermission('admin department index')
                || auth()->user()->hasPermission('admin designation index')
                || auth()->user()->hasPermission('admin employees index')
                || auth()->user()->hasPermission('admin attendance list')
                || auth()->user()->hasPermission('admin leave requests')
                || auth()->user()->hasPermission('admin termination index')
                || auth()->user()->hasPermission('admin attendance index'))
                <li  class="collapsed">
                <a class="m-link"  data-bs-toggle="collapse" data-bs-target="#employees" href="#">
                    <i class="icofont-briefcase"></i><span>Employees</span> <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span></a>
                <!-- Menu: Sub menu ul -->
                <ul class="sub-menu collapse
                {{ Request::route()->getName() == 'admin.holiday.index' ? 'show':''}}
                {{ Request::route()->getName() == 'admin.attendance.index' ? 'show':''}}
                {{ Request::route()->getName() == 'admin.department.index' ? 'show':''}}
                {{ Request::route()->getName() == 'admin.designation.index' ? 'show':''}}
                {{ Request::route()->getName() == 'admin.employees.index' ? 'show':'' }}
                {{ Request::route()->getName() == 'admin.attendance.list' ? 'show':'' }}
                {{ Request::route()->getName() == 'admin.leave.requests' ? 'show':'' }}
                {{ Request::route()->getName() == 'admin.termination.index' ? 'show':'' }}
                    " id="employees">
                    @if(auth()->user()->hasPermission('admin employees index'))
                     <li><a class="ms-link {{ Request::route()->getName() == 'admin.employees.index' ? 'active':'' }}" href="{{route('admin.employees.index')}}"><span>Members</span></a></li>
                    @endif
                    @if(auth()->user()->hasPermission('admin attendance index'))
                     <li><a class="ms-link {{ Request::route()->getName() == 'admin.attendance.index' ? 'active':'' }}" href="{{route('admin.attendance.index')}}">Attendance</a></li>
                    @endif
                    @if(auth()->user()->hasPermission('admin holiday index'))
                     <li><a class="ms-link {{ Request::route()->getName() == 'admin.holiday.index' ? 'active':'' }}" href="{{route('admin.holiday.index')}}"><span>Holidays</span></a></li>
                    @endif
                    @if(auth()->user()->hasPermission('admin leave requests'))
                     <li><a class="ms-link {{ Request::route()->getName() == 'admin.leave.requests' ? 'active':'' }}" href="{{route('admin.leave.requests')}}"><span>Leave Request</span></a></li>
                    @endif
                    @if(auth()->user()->hasPermission('admin department index'))
                     <li class=""><a class="ms-link {{ Request::route()->getName() == 'admin.department.index' ? 'active':'' }}" href="{{route('admin.department.index')}}"><span>Departments</span></a></li>
                     @endif
                    @if(auth()->user()->hasPermission('admin designation index'))
                        <li><a class="ms-link {{ Request::route()->getName() == 'admin.designation.index' ? 'active':'' }}" href="{{route('admin.designation.index')}}"><span>Designation</span></a></li>
                    @endif
                    @if(auth()->user()->hasPermission('admin termination index'))
                        <li><a class="ms-link {{ Request::route()->getName() == 'admin.termination.index' ? 'active':'' }}"  href="{{route('admin.termination.index')}}"><span>Termination</span></a></li>
                    @endif
                </ul>
            </li>
            @endif
            @if(auth()->user()->hasPermission('admin salary index') || auth()->user()->hasPermission('admin salary payment index') || auth()->user()->hasPermission('admin expense index') || auth()->user()->hasPermission('admin office expenses index'))
                <li class="collapsed">
                    <a class="m-link"  data-bs-toggle="collapse" data-bs-target="#accounts" href="#">
                        <i class="icofont-bank"></i><span>Accounts</span> <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span></a>
                    <!-- Menu: Sub menu ul -->
                    <ul class="sub-menu collapse
                {{ Request::route()->getName() == 'admin.salary.index' ? 'show':''}}
                    {{ Request::route()->getName() == 'admin.salary.payment.index' ? 'show':''}}
                    {{ Request::route()->getName() == 'admin.expense.index' ? 'show':''}}
                    {{ Request::route()->getName() == 'admin.office.expenses.index' ? 'show':''}}
                        " id="accounts">
                        @if(auth()->user()->hasPermission('admin salary index'))
                        <li><a class="ms-link {{ Request::route()->getName() == 'admin.salary.index' ? 'active':'' }}" href="{{route('admin.salary.index')}}"><span> Employee salary</span></a></li>
                        @endif

                        @if(auth()->user()->hasPermission('admin salary payment index'))
                        <li><a class="ms-link {{ Request::route()->getName() == 'admin.salary.payment.index' ? 'active':''}}" href="{{route('admin.salary.payment.index')}}"><span> Salary Payment</span></a></li>
                        @endif
                        @if(auth()->user()->hasPermission('admin expense index'))
                           <li><a class="ms-link {{ Request::route()->getName() == 'admin.expense.index' ? 'active':''}}" href="{{route('admin.expense.index')}}"><span> Money Receipts </span></a></li>
                        @endif
                        @if(auth()->user()->hasPermission('admin office expenses index'))
                           <li><a class="ms-link {{ Request::route()->getName() == 'admin.office.expenses.index' ? 'active':''}}" href="{{route('admin.office.expenses.index')}}"><span> Office Expenses </span></a></li>
                        @endif
                    </ul>
                </li>
            @endif
            @if(auth()->user()->hasPermission('admin notice index') || auth()->user()->hasPermission('asset index') || auth()->user()->hasPermission('admin daily report') || auth()->user()->hasPermission('admin leave report')
                    || auth()->user()->hasPermission('admin attendance report') || auth()->user()->hasPermission('admin salary report') || auth()->user()->hasPermission('admin expense report') || auth()->user()->hasPermission('admin asset report')
                    || auth()->user()->hasPermission('admin leave management') || auth()->user()->hasPermission('admin policy index') || auth()->user()->hasPermission('admin form index')
                    || auth()->user()->hasPermission('admin salary setting index'))
                <li class="collapsed">
                    <a class="m-link" data-bs-toggle="collapse" data-bs-target="#tikit-Components" href="#"><i
                            class="icofont-hand-power"></i> <span>HR</span> <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span>
                    </a>
                    <!-- Menu: Sub menu ul -->
                    <ul class="sub-menu collapse
                    {{ Request::route()->getName() == 'admin.notice.index' ? 'show':'' }}
                    {{ Request::route()->getName() == 'admin.asset.index' ? 'show':'' }}
                    {{ Request::route()->getName() == 'admin.leave.management' ? 'show':'' }}
                    {{ Request::route()->getName() == 'admin.policy.index' ? 'show':'' }}
                    {{ Request::route()->getName() == 'admin.form.index' ? 'show':'' }}
                    {{ Request::route()->getName() == 'admin.salary.setting.index' ? 'show':'' }}
                        " id="tikit-Components">
                        @if(auth()->user()->hasPermission('admin form index'))
                        <li><a class="ms-link {{ Request::route()->getName() == 'admin.form.index' ? 'active':'' }}" href="{{route('admin.form.index')}}"><i class="icofont-hand-power"></i> <span>Forms Management</span></a></li>
                        @endif
                        @if(auth()->user()->hasPermission('admin policy index'))
                        <li><a class="ms-link {{ Request::route()->getName() == 'admin.policy.index' ? 'active':'' }}" href="{{route('admin.policy.index')}}"><i class="icofont-hand-power"></i> <span>Policies</span></a></li>
                        @endif
                        @if(auth()->user()->hasPermission('admin notice index'))
                        <li><a class="ms-link {{ Request::route()->getName() == 'admin.notice.index' ? 'active':'' }}" href="{{route('admin.notice.index')}}"><i class="icofont-notification"></i> <span>Notices</span></a></li>
                        @endif
                        @if(auth()->user()->hasPermission('admin asset index'))
                        <li><a class="ms-link {{ Request::route()->getName() == 'admin.asset.index' ? 'active':'' }}" href="{{route('admin.asset.index')}}"> <i class="icofont-contrast"></i> <span>Assets</span></a></li>
                        @endif
                        @if(auth()->user()->hasPermission('admin leave management'))
                        <li><a class="ms-link {{ Request::route()->getName() == 'admin.leave.management' ? 'active':'' }}" href="{{route('admin.leave.management')}}"> <i class="icofont-leaf"></i> <span>Leave Management</span></a></li>
                        @endif
                        @if(auth()->user()->hasPermission('admin salary setting index'))
                        <li><a class="ms-link {{ Request::route()->getName() == 'admin.salary.setting.index' ? 'active':'' }}" href="{{route('admin.salary.setting.index')}}"> <i class="icofont-money-bag"></i> <span>Salary Settings</span></a></li>
                        @endif
                    </ul>
                </li>
            @endif
            @if(auth()->user()->hasPermission('admin daily report') || auth()->user()->hasPermission('admin leave report') || auth()->user()->hasPermission('admin asset report')
                            || auth()->user()->hasPermission('admin attendance report') || auth()->user()->hasPermission('admin salary report') || auth()->user()->hasPermission('admin expense report'))
                <li class="collapsed">
                    <a class="m-link" data-bs-toggle="collapse" data-bs-target="#reports-Components" href="#"><i class="icofont-search-document fs-5 "></i> <span>Reports</span> <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span></a>
                    <!-- Menu: Sub menu ul -->
                    <ul class="sub-menu collapse
                    {{ Request::route()->getName() == 'admin.daily.report' ? 'show':'' }}
                    {{ Request::route()->getName() == 'admin.leave.report' ? 'show':'' }}
                    {{ Request::route()->getName() == 'admin.attendance.report' ? 'show':'' }}
                    {{ Request::route()->getName() == 'admin.expense.report' ? 'show':'' }}
                    {{ Request::route()->getName() == 'admin.office.expense.report' ? 'show':'' }}
                    {{ Request::route()->getName() == 'admin.salary.report' ? 'show':'' }}
                    {{ Request::route()->getName() == 'admin.asset.report' ? 'show':'' }}" id="reports-Components">
                        @if(auth()->user()->hasPermission('admin salary report'))
                            <li><a class="ms-link {{ Request::route()->getName() == 'admin.salary.report' ? 'active':'' }}" href="{{route('admin.salary.report')}}"><span> Salary Report </span></a></li>
                        @endif
                        @if(auth()->user()->hasPermission('admin expense report'))
                            <li><a class="ms-link {{ Request::route()->getName() == 'admin.expense.report' ? 'active':'' }}" href="{{route('admin.expense.report')}}"><span> Money Receipt Report </span></a></li>
                        @endif
                        @if(auth()->user()->hasPermission('admin office expense report'))
                            <li><a class="ms-link {{ Request::route()->getName() == 'admin.office.expense.report' ? 'active':'' }}" href="{{route('admin.office.expense.report')}}"><span>Office Expense Report </span></a></li>
                        @endif
                        @if(auth()->user()->hasPermission('admin asset report'))
                            <li><a class="ms-link {{ Request::route()->getName() == 'admin.asset.report' ? 'active':'' }}" href="{{route('admin.asset.report')}}"><span> Assets Report </span></a></li>
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
            @endif
            @if(auth()->user()->hasPermission('admin settings index') || auth()->user()->hasPermission('admin role index')
                || auth()->user()->hasPermission('admin permission index')
                || auth()->user()->hasPermission('admin user role')
                )
                <li class="collapsed">
                    <a class="m-link" data-bs-toggle="collapse" data-bs-target="#administration" href="#"><i
                            class="icofont-ui-lock"></i> <span>Administration</span> <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span></a>
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
                                <i class="icofont-gear-alt"></i> <span>Settings</span> <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span>
                            </a>
                            <ul class="sub-menu collapse {{ Request::route()->getName() == 'admin.settings.index' ? 'show':''}}
                                {{ Request::route()->getName() == 'admin.password.index' ? 'show':''}}
                                {{ Request::route()->getName() == 'admin.user.password.index' ? 'show':''}}
                                " id="settings">
                                <li><a class="ms-link {{ Request::route()->getName() == 'admin.settings.index' ? 'active':''}}" href="{{route('admin.settings.index')}}"><span> Company Settings </span></a></li>
                                @if(auth()->user()->hasPermission('admin password index') || auth()->user()->hasPermission('admin email update'))
                                <li><a class="ms-link {{ Request::route()->getName() == 'admin.password.index' ? 'active':''}}" href="{{route('admin.password.index')}}"><span> Change Credential </span></a></li>
                                @endif
                                @if(auth()->user()->hasPermission('admin user password index') || auth()->user()->hasPermission('admin user email update'))
                                    <li><a href="{{route('admin.user.password.index')}}" class="ms-link {{ Request::route()->getName() == 'admin.user.password.index' ? 'active':''}}"> Employees Credentials</a></li>
                                @endif
                                {{--                            <li><a class="ms-link" href="#"><span> Leave Type </span></a></li>--}}
                            </ul>
                        </li>
                        @endif
                        @if(auth()->user()->hasPermission('admin role index') || auth()->user()->hasPermission('admin permission index') || auth()->user()->hasPermission('admin user role'))
                                <li class="collapsed">
                                    <a class="ms-link" data-bs-toggle="collapse" data-bs-target="#rolePermissions" href="#">
                                        <i class="icofont-unlock"></i> <span>Role Permission</span> <span class="arrow icofont-dotted-down ms-auto text-end fs-5"></span>
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
