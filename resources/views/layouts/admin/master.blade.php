<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimal-ui">
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    <title> {{ ((auth()->user()->is_super_admin == 1) ? 'Super Admin' : ((auth()->user()->is_admin == 1) ? 'Admin' : 'Manager' ))}} @yield('title')</title>
    <meta content="Admin Dashboard" name="description" />
    <meta content="Themesbrand" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="csrf_token" content="{{ csrf_token() }}" />

    @include('layouts.admin.css')
    @yield('pageCss')

</head>

<body class="fixed-left">
    <!-- Loader -->
    <div id="preloader">
        <div id="status">
            <div class="spinner"></div>
        </div>
    </div>
    <!-- Begin page -->
    <div id="wrapper">
        @include('layouts.admin.left_sidebar')
        <!-- Start right Content here -->
        <div class="content-page">
            

            <!-- Start content -->
            <div class="content">
                @include('layouts.admin.top_bar')

                @yield('content')

            </div> <!-- content -->
            @include('layouts.admin.footer')
        </div>
        <!-- End Right content here -->
    </div>
    <!-- END wrapper -->

    @include('layouts.admin.notification_modal')
    @include('layouts.admin.scripts')
    @yield('pageScripts')
</body>

</html>
