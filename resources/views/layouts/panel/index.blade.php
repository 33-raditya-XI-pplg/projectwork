<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <title>@yield('title', 'Beranda')</title>

    <!-- CSRF-Token -- Ajax Request -- Post -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

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
    <link rel="stylesheet" href="{{ asset('assets/css/select2.css') }}" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.css" />
    <link rel="stylesheet" href="{{ asset('vendor/simditor/styles/simditor.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/panel.css?v=1.1') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/chosen.css') }}">
    <link href="https://cdn.jsdelivr.net/gh/gitbrent/bootstrap-switch-button@1.1.0/css/bootstrap-switch-button.min.css"
        rel="stylesheet">
        {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js">
        <link  rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"> --}}
        <link rel="stylesheet" href="{{asset('assets/css/custom.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/testimoni.css')}}">
        <link rel="stylesheet" href="{{asset('assets/css/partner.css')}}">
        <link href="https://cdn.jsdelivr.net/npm/remixicon@4.3.0/fonts/remixicon.css" rel="stylesheet"/>
        <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />
        <style>
                input[type="text"],
                input[type="number"],
                input[type="email"],
                input[type="date"],
                textarea,
                select,
                .form-control,
                .input-group-text{
                        border-width: 0.1px;
                        border-color:black !important;
            }
            .select2-container .select2-selection--single{
                border-width:0.2px !important;
                border-color:black !important;  
             
            }
            .select2-container .select2-selection__clear{
                position: absolute;
                left: 26px;
                top: 50%;
                transform: translateY(-5%);
                z-index: 1;
            }
            .select2-close-mask{
            z-index: 2099 !important;
            }
            .select2-dropdown{
                z-index: 3051 !important;
            }
        </style>
    @stack('style')

    {{-- @include('layouts.env') --}}
</head>

<body style="align-items: flex-start">

    <div id="app">
        <div class="content-wrapper" id="panel-content">
            @include('layouts.panel.sidebar')
            @include('layouts.panel.navbar')
            <div class="container mt-4">
                <div class="d-flex justify-content-between  align-items-center  mb-3 ">
                    <div id="breadcrumb " style="--bs-breadcrumb-divider: ''">
                        <ol class="breadcrumb d-inline">
                            <!-- Tampilkan Title -->
                            <li class="breadcrumb-item text-body-emphasis text-capitalize h3 fw-semibold d-inline ms-3">
                                {{ $Title }}
                            </li>
                        
                            @if (!empty($subtitle) && count(Request::segments()) >= 3)
                            <span class="h4 fw-normal text-body-emphasis"> > </span>
                            <li class="breadcrumb-item text-capitalize h4 d-inline">
                                {{ $subtitle }}  <!-- Diambil dari controller -->
                            </li>
                            @endif
                            
                            @if (!empty($subTitle) && count(Request::segments()) >= 4)
                            <span class="h5"> - </span>
                            <li class="breadcrumb-item h5 d-inline">
                                {{ $subTitle }}  <!-- Diambil dari controller -->
                            </li>
                        @endif
                        </ol>
                        
                    </div>
                    <div>
                        @php
                            $menu = request()->segment(count(request()->segments()));
                        @endphp

                        @if($menu === 'skema')
                            <button class="btn btn-primary rounded" id="add">+ Tambah</button>
                        @elseif (in_array($menu,
                                    [
                                        'dashboard', 'skema', 'penilaian', 'create', 'user', 'edit', 'profile', 'sertifikat',
                                        'event-user', 'sertifikat-user', 'nilai', 'rincian-sertifikat','rincian','profile-user','uploadPembayaran-user','uploadPembayaran','laporanperkembangan','add-student','detail','rincian'
                                    ]
                                )
                            )                            
                        @else
                            <button class="btn btn-primary rounded" id="tambahBtn" data-bs-toggle="modal" data-bs-target="#add">+
                                Tambah</button>
                        @endif

                    </div>
                </div>
                @yield('content')
            </div>
        </div>
    </div>


        {{-- <li class="sub-menu-item {{ Request::segment(3) == 'user' ? 'blogkategori' : '' }}">
        <a href="{{ route('blogkategori.index') }}" class="sub-menu-link"><i class="fas fa-blog"></i>
            <span> Blog Kategori</span></a>
    </li> --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/dropzone/5.9.3/min/dropzone.min.js"></script>
    <script src="{{ asset('assets/js/jquery.min.js') }}"></script>
    <script src="{{ asset('vendor/bootstrap/dist/js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('assets/js/select2.js') }}"></script>
    <script src="{{ asset('assets/js/sweetalert.js') }}"></script>
    <script src="{{ asset('assets/js/swithbutton.js') }}">
    </script>
    <script src="{{ asset('assets/js/ckeditor.js') }}"></script>
    <script src="{{ asset('') }}vendor/DataTables/datatables.js"></script>
    <script src="{{ asset('') }}vendor/simditor/site/assets/scripts/module.js"></script>
    <script src="{{ asset('') }}vendor/simditor/site/assets/scripts/hotkeys.js"></script>
    <script src="{{ asset('') }}vendor/simditor/site/assets/scripts/uploader.js"></script>
    <script src="{{ asset('') }}vendor/simditor/lib/simditor.js"></script>
    {{-- <script src="{{ asset('assets/js/main.js') }}"></script> --}}
    <script src="{{ asset('assets/js/chosen.jquery.js') }}"></script>
    <script src="{{ asset('assets/js/panel.js') }}"></script>
    <script src="{{asset('assets/js/custom.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.5/jquery.validate.min.js"></script>
    <script></script>
    
    {{-- inisialisasi js --}}
    <script>
        $(document).ready(function() {
              $('.js-example-basic-single').each(function() {
                  var placeholder = $(this).data('placeholder'); 
                  
                  $(this).select2({
                      placeholder: placeholder, 
                      allowClear: true,
                      minimumResultsForSearch: Infinity 
                  });
              });
          });
          </script>
    {{-- <script>
        var button = document.getElementById('add')
        button.style.display = 'none';
    </script> --}}
    <script>
        function previewFile() {
            const file = $("#formFileSm").files[0];
            const preview = $("#preview");

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
    <script>
        $(document).ready(function() {
            const ckeditorElements = document.querySelectorAll('.ck-editor');
            const tables = document.querySelectorAll('#example');

            // Destroy the existing DataTable instance
            $('#example').DataTable().destroy();
            // create new DataTable instance
            tables.forEach(function(table) {
                new DataTable(table, {
                    // scrollX: true,
                    // deferRender: true
                });
            });
            ckeditorElements.forEach(function(element) {
                ClassicEditor
                    .create(element)
                    .catch(error => {
                        console.error(error);
                    });
            });
        });

        $("#image_upload_form").validate({
    rules: {
      nama: {
        required: true,
        maxlength: 255
      }
    },

    kategori: {
        nama: {
          required: true,
          minlength: 255
        },
        image:{
            required:true,
            extensions: "png|jpep|jpg|bmp"
        }
      },



    messages: {
      nama: {
        required: "Please enter an Image Caption",
        maxlength:("max. 255 charackter")
      },
      kategori: {
        required: "Please select category",

      },
      image: {
        required: "Please upload image",
        extensions:"only jpeg,p"

      },

    }
  });
    </script>
    @stack('script')
    @include('sweetalert::alert')
</body>
</html>
