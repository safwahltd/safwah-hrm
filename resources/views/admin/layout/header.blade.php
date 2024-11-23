<div class="header">
    <nav class="navbar py-4">
        <div class="container-xxl">

            <!-- header rightbar icon -->
            <div class="h-right d-flex align-items-center mr-5 mr-lg-0 order-1">
                <div class="dropdown notifications">
                    <a class="nav-link dropdown-toggle pulse" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="icofont-alarm  text-white fs-5"></i><sup class="text-white m-0 fw-bold bg-success rounded-circle p-1">{{ $noticeCount ?? '0' }}</sup>
                        <span class="pulse-ring text-white"></span>
                    </a>
                    <div id="NotificationsDiv" class="dropdown-menu rounded-lg shadow border-0 dropdown-animation dropdown-menu-sm-end p-0 m-0">
                        <div class="card border-0 w380">
                            <div class="card-header border-0 p-3">
                                <h5 class="mb-0 font-weight-light d-flex justify-content-between">
                                    <span>Notices</span>
                                </h5>
                            </div>
                            <div class="tab-content card-body">
                                <div class="tab-pane fade show active">
                                    <ul class="list-unstyled list mb-0">
                                        @if($notices->count())
                                            @foreach($notices as $key => $notice)
                                                <li class="py-2 mb-1 border-bottom">
                                                    <a href="{{route('employee.notice.list')}}#notice{{$key}}" class="d-flex">
                                                        <img class="avatar rounded-circle" src="{{asset('/')}}admin/assets/images/xs/avatar1.jpg" alt="">
                                                        <div class="flex-fill ms-2">
                                                            <strong></strong>
                                                            <p class="d-flex justify-content-between mb-0 ">
                                                                <span class="font-weight-bold">{{ $notice->title }}</span> <small>{{ $notice->created_at->diffForHumans() }}</small>
                                                            <p>{{ \Illuminate\Support\Str::limit($notice->content, 70) }}</p>
                                                            </p>
                                                        </div>
                                                    </a>
                                                </li>
                                            @endforeach
                                        @else
                                            <a class="dropdown-item" href="#">No new notices</a>
                                        @endif
                                    </ul>
                                </div>
                            </div>
                            <a class="card-footer text-center border-top-0" href="{{route('employee.notice.list')}}"> View All Notices</a>
                        </div>
                    </div>
                </div>
                <div class="dropdown user-profile ml-2 ml-sm-3 d-flex align-items-center">
                    <div class="u-info me-2">
                        <p class="mb-0 text-end line-height-sm "><span class="font-weight-bold text-white">{{auth()->user()->name}}</span></p>
                        <small class="text-white">{{ ucwords(auth()->user()->role)}} </small>
                    </div>
                    <a class="nav-link dropdown-toggle pulse p-0" href="#" role="button" data-bs-toggle="dropdown" data-bs-display="static">
                        <img class="avatar lg rounded-circle img-thumbnail" src="{{asset('/')}}admin/assets/images/profile_av.png" alt="profile">
                    </a>
                    <div class="dropdown-menu rounded-lg shadow border-0 dropdown-animation dropdown-menu-end p-0 m-0">
                        <div class="card border-0">
                            <div class="card-body pb-0">
                                <div class="d-flex py-1">
                                    <img class="avatar rounded-circle" src="{{asset('/')}}admin/assets/images/profile_av.png" alt="profile">
                                    <div class="flex-fill ms-3">
                                        <p class="mb-0"><span class="font-weight-bold">{{auth()->user()->name}}</span></p>
                                        <small class="">{{auth()->user()->email}}</small>
                                    </div>
                                </div>

                                <div><hr class="dropdown-divider border-dark"></div>
                            </div>
                            <div class="list-group m-2 ">
                                <a href="{{route('employees.index')}}" class="list-group-item list-group-item-action border-0 "><i class="icofont-ui-user-group fs-6 me-3"></i>members</a>
                                <a href="{{route('employees.index')}}" class="list-group-item list-group-item-action border-0 "><i class="icofont-ui-user-group fs-6 me-3"></i>Settings</a>
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
            </div>

            <!-- menu toggler -->
            <button class="navbar-toggler p-0 border-0 menu-toggle order-3 me-4" type="button" data-bs-toggle="collapse" data-bs-target="#mainHeader">
                <span class="fa fa-bars text-white"></span>
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
