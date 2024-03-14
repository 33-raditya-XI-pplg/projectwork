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
    <link href="{{ asset('') }}vendor/DataTables/datatables.css" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/simditor/styles/simditor.css') }}">
    @stack('style')
    <link rel="stylesheet" href="{{ asset('assets/css/panel.css?v=1.1') }}">
    {{-- @include('layouts.env') --}}
</head>
<body>

    <div id="app">
        @include('layouts.panel.sidebar')
        @include('layouts.panel.navbar')
        <div class="content-wrapper" id="panel-content">
            @yield('content')
        </div>
    </div>

<script src="{{ asset('assets/js/jquery.min.js') }}"></script>
<script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('vendor/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('') }}vendor/DataTables/datatables.js"></script>
<script src="{{ asset('') }}vendor/simditor/site/assets/scripts/module.js"></script>
<script src="{{ asset('') }}vendor/simditor/site/assets/scripts/hotkeys.js"></script>
<script src="{{ asset('') }}vendor/simditor/site/assets/scripts/uploader.js"></script>
<script src="{{ asset('') }}vendor/simditor/lib/simditor.js"></script>
<script src="{{ asset('assets/js/main.js') }}"></script>
<script src="{{ asset('assets/js/panel.js') }}"></script>
<script>
    new DataTable('#example');
</script>
<script>
    function previewFile() {
        const file = document.querySelector('#formFileSm').files[0];
        const preview = document.querySelector('#preview');

        const reader = new FileReader();

        reader.onloadend = function() {
            preview.src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = "";
        }
    }
</script>
@stack('script')
@include('sweetalert::alert')

</body>
</html>
