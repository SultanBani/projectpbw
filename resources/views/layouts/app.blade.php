<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') | BPS Provinsi Papua</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @vite(['resources/sass/app.scss', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/bps.css') }}">
</head>
<body class="halaman-aplikasi">
    @include('partials.header')
    @yield('content')
    @include('partials.footer')
    <script src="{{ asset('assets/logout-confirmation.js') }}"></script>
    @stack('scripts')
</body>
</html>
