<!doctype html>
<html class="no-js" lang="en" dir="ltr">


<head>
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
</head>

<body  class="image-box overflow-x-hidden"  data-mytask="theme-indigo"  style="">
<div id="mytask-layout">

    <!-- sidebar -->
    @include('employee.layout.sidebar')
    <!-- main body area -->
    <div class="main px-lg-4 px-md-4">
        <!-- Body: Header -->
        @include('employee.layout.header')
        <!-- Body: Body -->
        <div class="body d-flex py-3">
            <div class="container-xxl">

                @yield('body')


            </div>
        </div>
    </div>
</div>
    @include('employee.layout.script')
</body>

</html>
