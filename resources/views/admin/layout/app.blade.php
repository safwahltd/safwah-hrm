<!doctype html>
<html class="no-js" lang="en" dir="ltr">


<head>
    @if(auth()->user()->role =='admin')
    @include('admin.layout.meta')
    <!-- Favicon-->
    <!-- project css file  -->
    @include('admin.layout.style')
        <style>
            .image-box {

                background: linear-gradient(rgba(105, 92, 92, 0.5), rgba(6, 0, 0, 0.5)) , url({{asset('/hrms-banner.jpg')}});
                background-size: cover;
                background-repeat: no-repeat;
            }
        </style>
    @endif
    @if(auth()->user()->role =='employee')
            @include('employee.layout.meta')
        <!-- Favicon-->
            <!-- project css file  -->
            @include('employee.layout.style')
            <style>
                .image-box {

                    background: linear-gradient(rgba(105, 92, 92, 0.5), rgba(6, 0, 0, 0.5)) , url({{asset('/hrms-banner.jpg')}});
                    background-size: cover;
                    background-repeat: no-repeat;
                }
            </style>
    @endif
</head>

<body class="image-box overflow-x-hidden"  data-mytask="theme-indigo"  style="">
<div id="mytask-layout">

    <!-- sidebar -->
    @include('admin.layout.sidebar')

    <!-- main body area -->
    <div class="main px-lg-4 px-md-4">
        <!-- Body: Header -->
    @if(auth()->user()->role =='admin')
        @if(\Illuminate\Support\Facades\Request::route()->getName() != 'admin.chat.index')
            @include('admin.layout.header')
        @endif
    @endif
    @if(auth()->user()->role =='employee')
        @if(\Illuminate\Support\Facades\Request::route()->getName() != 'admin.chat.index')
            @include('employee.layout.header')
        @endif
    @endif
        <!-- Body: Body -->
        <div class="body d-flex py-3">
            <div class="container-xxl">
                @yield('body')
            </div>
        </div>
    </div>
</div>
@include('admin.layout.script')
</body>

</html>
