@extends('layouts.panel.index')
@section('title','Detail Tandatangan')

@section('content')  
<style>
    .dropzone-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
    width: 100%;
    height: 200px;
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
                <input type="text" class="form-control" name="page" id="page" value="{{ \App\Models\Page::find($ttd->page_id)->nama_page ?? 'Nama halaman tidak ditemukan '}}" disabled readonly>
            </div>
            <div class="col">
                    <div class="mb-3">
                    <label for="nama_ttd" class="form-label">Nama TTD</label>
                    <input type="text" class="form-control" name="nama_ttd" id="nama_ttd" disabled readonly required value="{{ $ttd->nama_ttd }}">
                </div>
                <div class="mb-3">
                    <label for="nomor_induk" class="form-label">NIK</label>
                    <input type="text" class="form-control" name="nomor_induk" id="nomor_induk" disabled readonly value="{{ $ttd->nomor_induk }}">
                </div>
                </div>
                <div class="col">
                <div class="mb-3">
                    <label for="jabatan" class="form-label">Jabatan</label>
                    <input type="text" class="form-control" name="jabatan" id="jabatan" disabled readonly value="{{ $ttd->jabatan }}">
                </div>                                 
                <div class="mb-3">
                    <label for="instansi" class="form-label">Instansi</label>                                        
                    <input type="text" class="form-control"  name="instansi" id="instansi_{{ $ttd->id_user }}" value="{{ $institutions[$ttd->instansi_id] ?? ''}}" disabled readonly>
                </div>
            </div>                            
            <div class="form-group mb-2">
                <label class="control-label mb-2">Upload Foto Tandatangan  <span class="text-danger">*</span></label>
                <div class="dropzone-wrapper">                                            
                    <div id="image_preview_" class="mt-3 d-flex justify-content-center" disabled readonly>                                       
                            <img  src="{{ asset($ttd->path_ttd) }}" alt="Image preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">                                       
                    </div>                                            
                </div>                                   
            </div>
            <div class=" text-end mx-1">
                <a href="{{ route('tandatangan.index') }}" class="btn btn-secondary rounded">Kembali</a>
            </div>
        </div>
    </div>  
@endsection