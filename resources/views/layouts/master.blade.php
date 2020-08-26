<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'FELS') - {{ config('app.name', 'FELS') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">

    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">

    <!-- OPTIONAL CSS -->
    @stack('css')
</head>

<body>
    <div class="super_container">
        <!-- Header -->
        @include('layouts.partials.header')

        <!-- Menu -->
        @include('layouts.partials.menu')

        <!-- Homepage Cover -->
        @if (\Request::is('/'))
            @include('layouts.partials.cover')
        @endif

        <!-- Message notification -->
        <div class="language">
            @include('layouts.partials.message')
        </div>

        <!-- Main Container -->
        <main>
            @yield('content')
        </main>

        <!-- Main Footer -->
        @include('layouts.partials.footer')
    </div>
</body>
    <!-- REQUIRED SCRIPTS -->
    <script src="{{ asset('js/app.js') }}"></script>

    <!-- OPTIONAL JS -->
    @stack('js')
</html>
