<div class="header">
    <nav class="navbar py-4">
        <div class="container-xxl">

            <!-- header rightbar icon -->
            <div class="h-right d-flex align-items-center mr-5 mr-lg-0 order-1">
                <div class="dropdown notifications">
                    <a class="nav-link dropdown-toggle pulse" href="#" role="button" data-bs-toggle="dropdown">
                        <i class="icofont-alarm  text-white fs-5"></i><sup class="text-white m-0 fw-bold bg-success rounded-circle p-1">{{ \Illuminate\Support\Facades\Auth::user()->unreadNotifications->count() ?? '0' }}</sup>
                        <span class="pulse-ring text-white"></span>
                    </a>
                    <div id="NotificationsDiv" class="dropdown-menu rounded-lg shadow border-0 dropdown-animation dropdown-menu-sm-end p-0 m-0">
                        <div class="card border-0 w380">
                            <div class="card-header border-0 p-3">
                                <h5 class="mb-0 font-weight-light d-flex justify-content-between">
                                    <span>Notifications</span>
                                </h5>
                            </div>
                            <div class="tab-content card-body">
                                <div class="tab-pane fade show active">
                                    <ul class="list-unstyled list mb-0">
                                        @if(\Illuminate\Support\Facades\Auth::user()->unreadNotifications->count())
                                            @foreach (\Illuminate\Support\Facades\Auth::user()->unreadNotifications as $key => $notification)
                                                <li class="py-2 mb-1 border-bottom">
                                                    @if(isset($notification->data['data']['url']))
                                                        <a href="{{ $notification->data['data']['url'] }}" class="d-flex">
                                                    @else
                                                        <a href="{{route('employee.notice.list')}}#notice{{$key}}" class="d-flex">
                                                    @endif
                                                        <div class="flex-fill ms-2 {{ $notification->read_at == null ? '':'text-muted' }} ">

                                                            <p class="d-flex justify-content-between mb-0 ">
                                                                @if($notification->data['type'])
                                                                <span class="font-weight-bold">{{ ucwords(str_replace('_', ' ', $notification->data['type'])) }} </span>
                                                                @endif
                                                                <small>{{ $notification->created_at->diffForHumans() }}</small>
                                                            </p>

                                                            <p>{{ ucfirst(str_replace('_', ' ', $notification->data['message'])) }}</p>

                                                        </div>
                                                    </a>
                                                </li>
                                            @endforeach
                                        @else
                                            <a class="dropdown-item" href="#">No New Notification</a>
                                        @endif
                                    </ul>
                                </div>
                                <div class="row {{\Illuminate\Support\Facades\Auth::user()->unreadNotifications->count() ? '':'justify-content-center'}}">
                                    @if(\Illuminate\Support\Facades\Auth::user()->unreadNotifications->count())
                                        <div class="col-6 bg-primary ">
                                            <form action="{{ route('notifications.read') }}" method="POST">
                                                @csrf
                                                <button class="card-footer text-center text-white border-0" type="submit">Mark All As Read</button>
                                            </form>
                                        </div>
                                    @endif
                                    <div class="col-6 bg-primary ">
                                        <form action="{{route('employee.notice.list')}}" method="get">
                                            <button class="card-footer text-center text-white border-0" type="submit">View All</button>
                                        </form>
                                        {{--                                </div>--}}
                                        {{--                                    <a class="card-footer text-center border-top-0" href="{{route('employee.notice.list')}}"> View All Notifications</a>--}}
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="dropdown user-profile ml-2 ml-sm-3 d-flex align-items-center">
                    <div class="u-info me-2">
                        <p class="mb-0 text-end line-height-sm "><span class="font-weight-bold text-white">{{auth()->user()->name ?? 'N/A'}}</span></p>
                        <small class="text-white">{{ucwords(auth()->user()->role)}} </small>
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

            </div>

            <!-- menu toggler -->
            <button class="navbar-toggler p-0 border-0 menu-toggle order-3" type="button" data-bs-toggle="collapse" data-bs-target="#mainHeader">
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
