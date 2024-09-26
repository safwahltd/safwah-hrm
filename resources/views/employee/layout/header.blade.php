<div class="header">
    <nav class="navbar py-4">
        <div class="container-xxl">

            <!-- header rightbar icon -->
            <div class="h-right d-flex align-items-center mr-5 mr-lg-0 order-1">
                <div class="dropdown user-profile ml-2 ml-sm-3 d-flex align-items-center">
                    <div class="u-info me-2">
                        <p class="mb-0 text-end line-height-sm "><span class="font-weight-bold">{{auth()->user()->name ?? 'N/A'}}</span></p>
                        <small>{{ucwords(auth()->user()->role)}} Profile</small>
                    </div>
                    <a class="nav-link dropdown-toggle pulse p-0" href="#" role="button" data-bs-toggle="dropdown" data-bs-display="static">
                        @if(file_exists(auth()->user()->userInfo->image))
                            <img src="{{asset(auth()->user()->userInfo->image)}}" alt="profile" class="avatar lg rounded-circle img-thumbnail">
                        @else
                            <img class="avatar lg rounded-circle img-thumbnail" src="{{asset('/')}}admin/assets/images/lg/avatar3.jpg" alt="profile">
                        @endif

                    </a>
                    <div class="dropdown-menu rounded-lg shadow border-0 dropdown-animation dropdown-menu-end p-0 m-0">
                        <div class="card border-0 w280">
                            <div class="card-body pb-0">
                                <div class="d-flex py-1">
                                    @if(file_exists(auth()->user()->userInfo->image))
                                        <img src="{{asset(auth()->user()->userInfo->image)}}" alt="" class="avatar rounded-circle">
                                    @else
                                        <img src="{{asset('/')}}admin/assets/images/lg/avatar3.jpg" alt="" class="avatar rounded-circle">
                                    @endif

                                    <div class="flex-fill ms-3">
                                        <p class="mb-0"><span class="font-weight-bold">{{auth()->user()->name ?? 'N/A'}}</span></p>
                                        <small class="">{{auth()->user()->email ?? 'N/A'}}</small>
                                    </div>
                                </div>

                                <div><hr class="dropdown-divider border-dark"></div>
                            </div>
                            <div class="list-group m-2 ">
                                <a href="{{route('employee.profile.details')}}" class="list-group-item list-group-item-action border-0 "><i class="fa fa-user fs-5 me-3"></i>Profile</a>
                                <a href="{{route('employee.attendance.list')}}" class="list-group-item list-group-item-action border-0 "><i class="fa fa-solid fa-list-check fs-6 me-3"></i>Attendance</a>
                                <a href="#" class="list-group-item list-group-item-action border-0" onclick="return confirm('are you sure to logout ?') ? document.getElementById('logout-form').submit():''">
                                    <i class="icofont-logout fs-6 me-3"></i> Logout
                                </a>
                                <form class="list-group-item list-group-item-action border-0" id="logout-form" action="{{ route('logout') }}" method="post">
                                    @csrf
                                    @method('POST')
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="px-md-1">
                    <a href="#offcanvas_setting" data-bs-toggle="offcanvas" aria-expanded="false" title="template setting">
                        <svg class="svg-stroke" xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 24 24" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                            <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                            <path d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"></path>
                            <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                        </svg>
                    </a>
                </div>
            </div>

            <!-- menu toggler -->
            <button class="navbar-toggler p-0 border-0 menu-toggle order-3" type="button" data-bs-toggle="collapse" data-bs-target="#mainHeader">
                <span class="fa fa-bars"></span>
            </button>

            <!-- main menu Search-->
            <div class="order-0 col-lg-4 col-md-4 col-sm-12 col-12 mb-3 mb-md-0 ">
                <div class="input-group flex-nowrap input-group-lg">
                    <button hidden="hidden" type="button" class="input-group-text" id="addon-wrapping"><i class="fa fa-search"></i></button>
                    <input type="hidden" class="form-control" placeholder="Search" aria-label="search" aria-describedby="addon-wrapping">
                    <button hidden="hidden" type="button" class="input-group-text add-member-top" id="addon-wrappingone" data-bs-toggle="modal" data-bs-target="#addUser"><i class="fa fa-plus"></i></button>
                </div>
            </div>

        </div>
    </nav>
</div>
