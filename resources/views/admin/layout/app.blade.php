<!doctype html>
<html class="no-js" lang="en" dir="ltr">


<head>
    @include('admin.layout.meta')
    <!-- Favicon-->
    <!-- project css file  -->
    @include('admin.layout.style')
</head>

<body  data-mytask="theme-indigo"  style="background-color: #d0c6c6">
<div id="mytask-layout">

    <!-- sidebar -->
    @include('admin.layout.sidebar')

    <!-- main body area -->
    <div class="main px-lg-4 px-md-4">

        <!-- Body: Header -->
        @include('admin.layout.header')

        <!-- Body: Body -->
        <div class="body d-flex py-3">
            <div class="container-xxl">

                @yield('body')


            </div>
        </div>

        <!-- Modal Members-->
        <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title  fw-bold" id="addUserLabel">Employee Invitation</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="inviteby_email">
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" placeholder="Email address" id="exampleInputEmail1" aria-describedby="exampleInputEmail1">
                                <button class="btn btn-dark" type="button" id="button-addon2">Sent</button>
                            </div>
                        </div>
                        <div class="members_list">
                            <h6 class="fw-bold ">Employee </h6>
                            <ul class="list-unstyled list-group list-group-custom list-group-flush mb-0">
                                <li class="list-group-item py-3 text-center text-md-start">
                                    <div class="d-flex align-items-center flex-column flex-sm-column flex-md-column flex-lg-row">
                                        <div class="no-thumbnail mb-2 mb-md-0">
                                            <img class="avatar lg rounded-circle" src="{{asset('/')}}admin/assets/images/xs/avatar2.jpg" alt="">
                                        </div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <h6 class="mb-0  fw-bold">Rachel Carr(you)</h6>
                                            <span class="text-muted">rachel.carr@gmail.com</span>
                                        </div>
                                        <div class="members-action">
                                            <span class="members-role ">Admin</span>
                                            <div class="btn-group">
                                                <button type="button" class="btn bg-transparent dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="icofont-ui-settings  fs-6"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#"><i class="icofont-ui-password fs-6 me-2"></i>ResetPassword</a></li>
                                                    <li><a class="dropdown-item" href="#"><i class="icofont-chart-line fs-6 me-2"></i>ActivityReport</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item py-3 text-center text-md-start">
                                    <div class="d-flex align-items-center flex-column flex-sm-column flex-md-column flex-lg-row">
                                        <div class="no-thumbnail mb-2 mb-md-0">
                                            <img class="avatar lg rounded-circle" src="{{asset('/')}}admin/assets/images/xs/avatar3.jpg" alt="">
                                        </div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <h6 class="mb-0  fw-bold">Lucas Baker<a href="#" class="link-secondary ms-2">(Resend invitation)</a></h6>
                                            <span class="text-muted">lucas.baker@gmail.com</span>
                                        </div>
                                        <div class="members-action">
                                            <div class="btn-group">
                                                <button type="button" class="btn bg-transparent dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Members
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="icofont-check-circled"></i>

                                                            <span>All operations permission</span>
                                                        </a>

                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fs-6 p-2 me-1"></i>
                                                            <span>Only Invite & manage team</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="btn-group">
                                                <button type="button" class="btn bg-transparent dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="icofont-ui-settings  fs-6"></i>
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li><a class="dropdown-item" href="#"><i class="icofont-delete-alt fs-6 me-2"></i>Delete Member</a></li>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="list-group-item py-3 text-center text-md-start">
                                    <div class="d-flex align-items-center flex-column flex-sm-column flex-md-column flex-lg-row">
                                        <div class="no-thumbnail mb-2 mb-md-0">
                                            <img class="avatar lg rounded-circle" src="{{asset('/')}}admin/assets/images/xs/avatar8.jpg" alt="">
                                        </div>
                                        <div class="flex-fill ms-3 text-truncate">
                                            <h6 class="mb-0  fw-bold">Una Coleman</h6>
                                            <span class="text-muted">una.coleman@gmail.com</span>
                                        </div>
                                        <div class="members-action">
                                            <div class="btn-group">
                                                <button type="button" class="btn bg-transparent dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                    Members
                                                </button>
                                                <ul class="dropdown-menu dropdown-menu-end">
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="icofont-check-circled"></i>

                                                            <span>All operations permission</span>
                                                        </a>
                                                    </li>
                                                    <li>
                                                        <a class="dropdown-item" href="#">
                                                            <i class="fs-6 p-2 me-1"></i>
                                                            <span>Only Invite & manage team</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                            <div class="btn-group">
                                                <div class="btn-group">
                                                    <button type="button" class="btn bg-transparent dropdown-toggle" data-bs-toggle="dropdown" aria-expanded="false">
                                                        <i class="icofont-ui-settings  fs-6"></i>
                                                    </button>
                                                    <ul class="dropdown-menu dropdown-menu-end">
                                                        <li><a class="dropdown-item" href="#"><i class="icofont-ui-password fs-6 me-2"></i>ResetPassword</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="icofont-chart-line fs-6 me-2"></i>ActivityReport</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="icofont-delete-alt fs-6 me-2"></i>Suspend member</a></li>
                                                        <li><a class="dropdown-item" href="#"><i class="icofont-not-allowed fs-6 me-2"></i>Delete Member</a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- start: template setting, and more. -->
    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvas_setting" aria-labelledby="offcanvas_setting">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title">Template Setting</h5>
            <button type="button" class="btn-close" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body d-flex flex-column">
            <div class="mb-4">
                <h6>Set Theme Color</h6>
                <ul class="choose-skin list-unstyled mb-0">
                    <li data-theme="ValenciaRed"><div style="--mytask-theme-color: #D63B38;"></div></li>
                    <li data-theme="SunOrange"><div style="--mytask-theme-color: #F7A614;"></div></li>
                    <li data-theme="AppleGreen"><div style="--mytask-theme-color: #5BC43A;"></div></li>
                    <li data-theme="CeruleanBlue"><div style="--mytask-theme-color: #00B8D6;"></div></li>
                    <li data-theme="Mariner"><div style="--mytask-theme-color: #0066FE;"></div></li>
                    <li data-theme="PurpleHeart" class="active"><div style="--mytask-theme-color: #6238B3;"></div></li>
                    <li data-theme="FrenchRose"><div style="--mytask-theme-color: #EB5393;"></div></li>
                </ul>
            </div>
            <div class="mb-4 flex-grow-1">
                <h6>Set Theme Light/Dark/RTL</h6>
                <!-- Theme: Switch Theme -->
                <ul class="list-unstyled mb-0">
                    <li>
                        <div class="form-check form-switch theme-switch">
                            <input class="form-check-input fs-6" type="checkbox" role="switch" id="theme-switch">
                            <label class="form-check-label mx-2" for="theme-switch">Enable Dark Mode!</label>
                        </div>
                    </li>
                    <li>
                        <div class="form-check form-switch theme-rtl">
                            <input class="form-check-input fs-6" type="checkbox" role="switch" id="theme-rtl">
                            <label class="form-check-label mx-2" for="theme-rtl">Enable RTL Mode!</label>
                        </div>
                    </li>
                    <li>
                        <div class="form-check form-switch monochrome-toggle">
                            <input class="form-check-input fs-6" type="checkbox" role="switch" id="monochrome">
                            <label class="form-check-label mx-2" for="monochrome">Monochrome Mode</label>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </div>

</div>
    @include('admin.layout.script')
</body>

</html>
