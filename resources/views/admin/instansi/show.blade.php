@extends('layouts.panel.index')
@section('title','Detail Instansi')

@section('content')     
<style>
    .dropzone-wrapper_rincian {
    width: 100%;
    height: 240px;
    border: 2px dashed #ddd;
    background-color: #f9f9f9;
    position: relative;
    cursor: pointer; 
    }    
    #image_preview_ {
       display: flex;
       align-items: center;
       justify-content: center;
       width: 100%; 
       height: auto; 
       max-width: 200px; 
       max-height: 200px; 
       overflow: hidden;
       margin: 0 auto; 
   } 
</style>             
    <div class="container">
        <div class="row">
            <div class="mb-3">
                <label for="page" class="form-label">Page Id</label>
                <input type="text" class="form-control" name="page" id="page" value="{{ \App\Models\Page::find($instansi->page_id)->nama_page ?? 'Nama halaman tidak ditemukan '}}" disabled readonly>
            </div>
            <div class="col">
                    <div class="mb-3">
                        <label for="nama_instansi" class="form-label">Nama Instansi</label>
                        <input type="text" class="form-control" name="nama_instansi"
                            id="nama_instansi" value="{{ $instansi->nama_instansi }}" readonly disabled >
                    </div>
                    <div class="mb-3">
                        <label for="nomor_instansi" class="form-label">Nomor Instansi</label>
                        <input type="number" class="form-control" name="nomor_instansi"
                            id="nomor_instansi" value="{{ $instansi->nomor_instansi }}" readonly disabled>
                    </div>
                    <div class="mb-1">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="2" readonly disabled >{{ $instansi->alamat }} </textarea>
                    </div>
                    <div class="mb-3">
                        <label for="no" class="form-label">No. telp</label>
                        <input type="number" class="form-control" name="no_telp" id="no_telp" value="{{ $instansi->no_telp }}" readonly disabled >
                </div>                            
            </div>
            <div class="col">
                {{-- kiri --}}
                <div class="mb-3">
                    <label for="nama_kepala_instansi" class="form-label">Kepala Instansi</label>
                    <input type="text" class="form-control" name="nama_kepala_instansi" id="nama_kepala_instansi" value="{{ $instansi->nama_kepala_instansi }}" readonly disabled >
                </div>
                <div class="mb-3">
                    <label for="jabatan_kepala" class="form-label">Jabatan</label>
                    <input type="text" class="form-control" name="jabatan_kepala" id="jabatan_kepala" value="{{ $instansi->jabatan_kepala }}" readonly disabled >
                </div>
                <div class="mb-5">
                    <label for="alamat_kota" class="form-label">Kota</label>
                    <input type="text" class="form-control" name="alamat_kota" id="alamat_kota" value="{{ $instansi->alamat_kota }}" readonly disabled>                                 
                </div>
                <div class="mb-3 mt-4">
                    <label for="email" class="form-label">Email</label>
                    <input type="email" class="form-control" name="email" id="email" value="{{ $instansi->email }}" readonly disabled >
                </div>
            </div>
            {{-- foto gambar --}}
            <div class="col-md-12 mb-2">    
                <label class="control-label mb-2">Foto Pengguji</label>
                <div class="dropzone-wrapper_rincian">
                    <div id="image_preview_" class="mt-3 d-flex justify-content-center">                    
                            <img src="{{ asset($instansi->path_logo) }}" alt="Image preview" class="img-fluid" style="max-width: auto; max-height: auto; object-fit: contain;">                               
                    </div>
                </div>                                                              
            </div>     
            <div class=" text-end">
                <a href="{{ route('instansi.index') }}" class="btn btn-secondary rounded">Kembali</a>
            </div>                                           
        </div>
    </div>                          
@endsection