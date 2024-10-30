@extends('layouts.panel.index')
@section('title','Rincian Testimoni-user')

@section('content')
<style>
    .profile-image {
            transition: transform 0.3s ease-in-out;
        }
        .profile-image:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
        }  
        .rating-input {
            position: relative; 
        }

        .rating-input .form-control {
            padding-right: 30px; 
        }

        .rating-stars {
            position: absolute; 
            top: 73%; 
            left: 10px; 
            transform: translateY(-50%); 
            pointer-events: none; 
        }
</style>  
<div class="container">
    <div class="row">
        <div class="col">
            <div class="mb-3">
                <label for="page" class="form-label"><h5>Page Id</h5></label>
                <input type="text" class="form-control" value="{{ \App\Models\Page::find($testimoni->page_id)->nama_page ?? 'Nama halaman tidak ditemukan '}}" disabled readonly>
            </div>
                <div class="mb-3">
                    <label for="nama_lengkap" class="form-label"><h5>Nama</h5></label>
                    <input type="text" class="form-control" value="{{ $testimoni->user->nama_lengkap }}" disabled readonly >
                </div>                                                                                                                                                               
        </div>
        <div class="col">
            {{-- kiri --}}                                                                                                                                                               
            <div class="mb-3">
                <label for="nama_lengkap" class="form-label"><h5>Email</h5></label>
                <input type="text" class="form-control" value="{{ $testimoni->email }}" disabled readonly >
            </div>  
            <div class="mb-3">
                <label for="no" class="form-label"><h5>Tanggal</h5></label>
                <input type="text" class="form-control" value="{{ $testimoni->tanggal }}"disabled readonly >
            </div>                           
        </div>
        <div class="mb-3">
            <div class="rating-input">
                <label for="no" class="form-label"><h5>Rating</h5></label>
                <input type="text" class="form-control" value="" disabled readonly>
                <div class="rating-stars">
                    @for ($i = 1; $i <= 5; $i++)
                        <i class="fa {{ $i <= $testimoni->rating ? 'fa-star filled' : 'fa-star' }}" style="color: {{ $i <= $testimoni->rating ? 'yellow' : 'gray' }};"></i>
                    @endfor    
                </div>
            </div> 
        </div> 
        <div class="mb-3 ">
            <label for="pengalaman" class="form-label"><h5>Isi Testimoni</h5></label>
            <textarea class="form-control"  rows="2" disabled readonly>{{ $testimoni->isi_testimoni }}</textarea>
        </div>   
        <div class="text-center">
            <div>
                <h2>Foto Testimoni</h2>
            </div>
            <div class="dropzone-wrapper" style="max-width:400px; margin:auto;">                                       
                <div class="mt-3 d-flex justify-content-center" disabled readonly>                                                  
                        {{-- <img  src="{{ asset($testimoni->photo) }}" alt="Image preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">                                              --}}
                    @if ($testimoni->photo)
                        <img src="{{ asset($testimoni->photo) }}"  class="profile-image img-fluid rounded-3 color: #343a40" style="width: 250px; height: auto;" alt="user" />
                    @endif
                </div>
            </div>                                       
        </div>
              {{-- back --}}
        <div class=" text-end">
            <a href="{{ route('testimoni-user.index') }}" class="btn btn-secondary">Kembali</a>
        </div>
    </div>
</div>              
@endsection