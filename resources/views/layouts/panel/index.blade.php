<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Beranda')</title>
    <meta name="title" content="@yield('title', 'Beranda')">
    <meta name="description" content="@yield('meta.description', config('variable.DESCRIPTION'))">
    <meta name="author" content="@yield('meta.author', config('variable.AUTHOR'))">
    <meta name="keywords" content="@yield('meta.keywords', config('variable.KEYWORDS'))">
    <meta name="robots" content="index, follow">

    <link rel="icon" href="{{ asset('assets/img/icon.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('assets/img/icon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Work+Sans:wght@300;400;500;600;700;800&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('vendor/fontawesome/css/all.min.css') }}">
    <link href="{{ asset('') }}vendor/DataTables/datatables.css" rel="stylesheet">
    {{-- <link href="{{ asset('') }}vendor/select2/dist/css/select2.min.css" rel="stylesheet" /> --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="{{ asset('vendor/simditor/styles/simditor.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/panel.css?v=1.1') }}">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css" rel="stylesheet">
    @stack('style')

    {{-- @include('layouts.env') --}}
</head>

<body>

    <div id="app">
        @include('layouts.panel.sidebar')
        @include('layouts.panel.navbar')
        <div class="content-wrapper" id="panel-content">
            <div class="container mt-4">
                <div class="d-flex justify-content-between  align-items-center  mb-3 ">
                    <div id="breadcrumb " style="--bs-breadcrumb-divider: ''">
                        <ol class="breadcrumb d-inline">
                            <li class="breadcrumb-item text-body-emphasis text-capitalize h3 fw-semibold d-inline ms-3">
                                {{ Request::segment(2) }}</li>
                            <span class="h4 fw-normal text-body-emphasis">{{ count(Request::segments()) > 2 ? '>' : '' }}</span>
                            <li class="breadcrumb-item text-capitalize h4 d-inline">
                                {{ Str::replace('-', ' ', Request::segment(3)) }}</li>
                                <span class="h5">{{ count(Request::segments()) > 3 ? '-' : '' }}</span>
                            <li class="breadcrumb-item h5 d-inline">
                                {{ Str::replace('-', ' ', Request::segment(4)) }}</li>
                        </ol>
                    </div>
                    <div>
                        @php
                            $menu = request()->segment(count(request()->segments()));
                        @endphp
                        @if (in_array($menu, ['dashboard', 'skema', 'penilaian', 'create', 'user', 'edit', 'profile']))
                            <button class="btn btn-primary rounded" id="add">+ Tambah</button>

                        @else
                            <button class="btn btn-primary rounded" data-bs-toggle="modal" data-bs-target="#add">+
                                Tambah</button>
                        @endif

                    </div>
                </div>
                @yield('content')
            </div>

        </div>
    </div>


    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/dist/bootstrap-switch-button.min.js"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/39.0.1/classic/ckeditor.js"></script>
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
                preview.removeAttribute("hidden");
            }
            // console.log(file);
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
