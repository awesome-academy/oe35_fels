<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title') - {{ config('app.name', 'FELS') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app_back-end.css') }}" rel="stylesheet">

    <!-- OPTIONAL CSS -->
    @stack('css')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Navbar -->
        @include('back-end.layouts.partials.nav')
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        @include('back-end.layouts.partials.sidebar')

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    @yield('content-header')
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    <div class="row">
                        @yield('content')
                    </div>
                    <!-- /.row -->
                </div>
                <!-- /.container-fluid -->
            </div>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
            <!-- Can ignore this -->
            @yield('control-sidebar')
        </aside>
        <!-- /.control-sidebar -->

        <!-- Main Footer -->
        @include('back-end.layouts.partials.footer')
    </div>
    <!-- ./wrapper -->

</body>
    <!-- REQUIRED SCRIPTS -->
    <script src="{{ asset('js/app_back-end.js') }}"></script>

    <!-- OPTIONAL JS -->
    @stack('js')
</html>
