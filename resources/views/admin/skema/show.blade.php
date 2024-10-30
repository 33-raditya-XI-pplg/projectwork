@extends('layouts.panel.index')
@section('title','Detail Skema')

@section('content')
<style>
    .dropzone-wrapper {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%;
        height: 130px; 
        border: 2px dashed #ddd;
        background-color: #f9f9f9;
        position: relative;
        cursor: pointer;
    }
    #image_preview {
        display: flex;
        align-items: center;
        justify-content: center;
        width: 100%; 
        height: auto; 
        max-width: 100px; 
        max-height: 100px; 
        overflow: hidden;
        margin: 0 auto; 
    }
    .sub-skema-input {
        display: flex;
        align-items: center;
        margin-bottom: 10px; /* Beri jarak antar input */
    }

    .sub-skema-input .form-control {
        border-width: 1px; /* Atur agar border konsisten */
        border-color: #ccc; /* Warna border */
        border-radius: 5px; /* Membulatkan sudut */
        box-sizing: border-box; /* Memastikan padding tidak mempengaruhi lebar */
        padding-left: 10px; /* Atur padding kiri agar terlihat rapi */
        padding-right: 10px; /* Atur padding kanan agar terlihat rapi */
    }

    .sub-skema-wrapper {
        margin-bottom: 20px; /* Beri jarak pada sub skema */
    }
    
</style>
    <div class="container">
        <div class="row">
            <div class="mb-3">
                <label for="page" class="form-label">Page Id</label>
                <input type="text" class="form-control" name="page" id="page" value="{{ \App\Models\Page::find($skema->page_id)->nama_page ?? 'Nama halaman tidak ditemukan '}}" disabled readonly>
            </div>
            {{-- @dd($skema) --}}
            <div class="row mb-3">
                <div class="col">
                    <label for="nama_skema" class="form-label">Nama Skema</label>
                    <input type="text" class="form-control" id="nama_skema" name="nama_skema" value="{{ $skema->nama_skema }}" readonly disabled>
                </div>
                <div class="col">
                    <label for="icon" class="mb-2"> Icon Skema</label>
                    <div class="dropzone-wrapper">                                         
                                <img id="preview_image" src="{{ asset($skema->path_icon) }}" alt="Image preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">                           
                    </div>
                </div>						
            </div>
            <div class="form-group sub-skema-wrapper mb-5">
                <div class="d-flex justify-content-between">
                    <label class="form-label">Sub Skema</label>
                </div>
                @if(!$skema->has_sub_skema)
                    <div id="empty-input-message" class="alert alert-info" role="alert" style="display: show;">
                        <h6 class="mx-3 mt-2">Tidak Memiliki Sub-Skema</h6>
                    </div>
                @else
                    @foreach ($sub_skema as $row)
                    <div class="input-group mb-3 sub-skema-input">
                        <input type="hidden" name="sub_skema_ids[]" value="{{ $row->id_sub_skema }}">
                        <input type="text" class="form-control sub-skema-input-field" name="sub_skema[{{ $row->id_sub_skema }}]" value="{{ $row->judul_sub }}">                   
                    </div>
                    @endforeach
                @endif
            </div>  
            <div class=" text-end">
                <a href="{{ route('skema.index') }}" class="btn btn-secondary rounded">Kembali</a>
            </div>
        </div> 
    </div>  
@endsection