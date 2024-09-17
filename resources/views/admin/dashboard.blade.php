@extends('layouts.panel.index')
@section('title', 'Dashboard')
@push('styles')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" />
    <style>
        .accordion-button {
            display: flex;
            justify-content: space-between;
        }

        .accordion-button strong {
            margin-right: auto;
        }
        .accordion-button span {
            text-align: right;
        }
        .colored-toast {
        border-radius: 20px; 
        box-shadow: 0 0 15px rgba(0, 0, 0, 0.2);
        padding: 20px; 
        max-width: 400px; 
    }

    .alert-title {
        font-size: 1.5rem; 
        font-weight: bold; 
    }

    .alert-text {
        font-size: 1rem; 
    }

    .btn-confirm {
        background-color: #3085d6; 
        color: #fff; 
    }

    .btn-cancel {
        background-color: #6c757d; 
        color: #fff; 
    }
    </style>
@endpush
@section('content')    
    <div class="container">
        <div class="card bg-primary-gradient text-white rounded-3 shadow-lg" style="height: 7rem;">
            <div class="card-body d-flex align-items-center justify-content-between mx-3">
                <div>
                    <h5 class="card-title">Hi, <strong>{{ Auth::user()->nama_lengkap }}</strong></h5>
                    <p class="card-text">Selamat datang dan selamat bekerja!</p>
                </div>
                <div>

                </div>
            </div>
        </div>
      
        <div class="row">
            <div class="col-md-3">
                <div class="card mt-4 bg-primary-gradient text-white rounded-3 shadow-sm">
                    <div class="card-body">
                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                            <i class="fa-solid fa-users fs-1"></i>
                        </div>
                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                            <i class="fa-solid fa-users fs-1"></i>
                        </div>
                        <h1 class="card-title fw-bold">{{ $banyak_pengguna }}</h1>
                        <p class="card-text fw-bold">Banyak Pengguna</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mt-4 bg-primary-gradient text-white rounded-3 shadow-sm">
                    <div class="card-body">
                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                            <i class="fa-solid fa-users fs-1"></i>
                        </div>
                        <h1 class="card-title fw-bold">{{ $banyak_penguji }}</h1>
                        <p class="card-text fw-bold">Banyak Penguji</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mt-4 bg-primary-gradient text-white rounded-3 shadow-sm">
                    <div class="card-body">
                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                            <i class="fa-solid fa-users fs-1"></i>
                        </div>
                        <h1 class="card-title fw-bold">{{ $banyak_event }}</h1>
                        <p class="card-text fw-bold">Banyak Event</p>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card mt-4 bg-primary-gradient text-white rounded-3 shadow-sm">
                    <div class="card-body">
                        <div class="position-absolute top-0 end-0 mt-2 me-2">
                            <i class="fa-solid fa-users fs-1"></i>
                        </div>
                        <h1 class="card-title fw-bold">{{ $banyak_skema }}</h1>
                        <p class="card-text fw-bold">Banyak Skema</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="mt-4">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <label><b> Event yang Sedang Berlangsung</b></label>
                </div>

                <div class="card-body">
                    <div class="accordion" id="accordionExample">
                        @php $num=1; @endphp
                        @foreach ($data_event as $row)
                            <div class="accordion-item">
                                <h2 class="accordion-header" id="heading{{ $row->id_event }}">
                                    <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapse{{ $row->id_event }}" aria-expanded="true" aria-controls="collapse{{ $row->id_event }}">
                                        <div class="row w-100">
                                            <div class="col-md-6">
                                                <strong>{{ $num++ }}. {{ $row->nama_event }}</strong>
                                            </div>
                                            <div class="col-md-6 text-end">
                                                <span>{{ \Carbon\Carbon::parse($row->tgl_mulai)->format('d, F Y') }} - {{ \Carbon\Carbon::parse($row->tgl_berakhir)->format('d, F Y') }}</span>
                                            </div>
                                        </div>
                                    </button>
                                </h2>

                                <div id="collapse{{ $row->id_event }}" class="accordion-collapse collapse" aria-labelledby="heading{{ $row->id_event }}" data-bs-parent="#accordionExample">
                                    <div class="accordion-body">
                                        <p>{!! strip_tags($row->deskripsi) !!}</p>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                    </div>
                </div>

            </div>
        </div>
 @if($usersToVerify->count() > 0)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        Swal.fire({
            title: 'Perhatian!',
            text: 'Ada {{ $usersToVerify->count() }} pengguna yang belum diverifikasi. Silakan verifikasi pengguna tersebut.',
            icon: 'info',
            toast:true,
            position:'top-end',
            showCancelButton: true,
            confirmButtonText: 'Verifikasi Sekarang',
            cancelButtonText: 'Nanti Saja',
            customClass:{
                popup:'colored-toast',
                title:'alert-title',
                text:'alert-text',
                confirmButton:'btn-confirm',
                cancelButton:'btn-cancel',
            },
            background:'#f1f1f1',          
            didOpen:()=>{
                const popup = Swal.getPopup();
                popup.style.borderRadius = '20px';
                popup.style.fontSize = '1rem';
                popup.style.position = 'fixed';                 
                popup.style.top = '20px';   
                popup.style.right = '200px';   
                popup.style.maxWidth = '408px'; 
                Swal.getTitle().style.fontSize = '1.5rem';
                Swal.getContent().style.fontSize = '1rem';
                Swal.getConfirmButton().style.backgroundColor = '#3085d6';
                Swal.getCancelButton().style.backgroundColor = '#6c757d';
                Swal.getConfirmButton().style.color = '#fff';
                Swal.getCancelButton().style.color = '#fff';     
                
            }
        }).then((result) => {
            if (result.isConfirmed) {                
                window.location.href = '{{ route("user.index") }}';
            }
        });
    });
</script>
@endif
@endsection


