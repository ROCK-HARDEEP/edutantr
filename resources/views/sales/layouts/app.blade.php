<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no, shrink-to-fit=no" />
    <title>@yield('title', $app_setting['name'])</title>
    <link rel="shortcut icon" href="{{ $app_setting['favicon'] }}" type="image/x-icon">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/font-awesome.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/bootstrap-icons.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/datatables.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/newstyle.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/responsive.css') }}">
    @stack('styles')

    <style>
        .vertical-nav-menu li .menu
        {
            justify-content: start;
        }
    </style>
</head>
<body>
    <div class="app-container app-theme-white body-tabs-shadow fixed-sidebar fixed-header" id="appContent">
        @include('layouts.header')
        <div class="app-main">
            @include('sales.layouts.sidebar')
            @yield('content')
        </div>
        @include('layouts.footer')
    </div>

    <script src="{{ asset('assets/scripts/jquery-3.6.3.min.js') }}"></script>
    <script src="{{ asset('assets/scripts/main.js') }}"></script>
    <script src="{{ asset('assets/scripts/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/scripts/datatables.min.js') }}"></script>
    <script src="{{ asset('assets/scripts/scripts.js') }}"></script>
    @stack('scripts')
</body>
</html>
