<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title','Beranda')</title>
    <meta name="title" content="@yield('title','Beranda')">
    <meta name="description" content="@yield('meta.description',config('variable.DESCRIPTION'))">
    <meta name="author" content="@yield('meta.author',config('variable.AUTHOR'))">
    <meta name="keywords" content="@yield('meta.keywords',config('variable.KEYWORDS'))">
    <meta name="robots" content="index, follow">
    
    <link rel="icon" href="{{ asset('assets/img/icon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
    @stack('style')
    <link rel="stylesheet" href="{{ asset('assets/css/style.css?v1') }}">
    {{-- @include('layouts.env') --}}
</head>
<body>

    <div id="app">

        @include('layouts.home.navbar')

        <div class="content-wrapper">

            @yield('content')

        </div>

        @include('layouts.home.footer')

        <div id="language_translator_globe"></div>
    </div>
    
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
@stack('script')
</body>
</html>