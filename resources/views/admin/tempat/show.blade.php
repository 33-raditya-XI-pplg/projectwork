@extends('layouts.panel.index')
@section('title','Detail Tempat')

@section('content')    
<div class="container">
    <div class="row">
        <div class="mb-3">
            <label for="page" class="form-label">Page Id</label>
            <input type="text" class="form-control" name="page" id="page" value="{{ \App\Models\Page::find($tempat->page_id)->nama_page ?? 'Nama halaman tidak ditemukan '}}" disabled readonly>
        </div>
        <div class="col">
            {{-- kanan --}}             
                <div class="mb-3">
                    <label for="nama_tempat" class="form-label">Nama tempat</label>
                    <input type="text" class="form-control" name="nama_tempat" id="nama_tempat" value="{{ $tempat->nama_tempat }}" readonly disabled>
                </div>
                <div class="mb-3">
                    <label for="alamat" class="form-label">Alamat</label>
                    <textarea class="form-control" id="alamat" name="alamat" rows="2" readonly disabled>{{ $tempat->alamat }}</textarea>
                </div>
        </div>
        <div class="col">
            {{-- kiri --}}
            <div class="mb-3">
                    <label for="no_telp" class="form-label">No. telp</label>
                    <input type="number" class="form-control" name="no_telp" id="no_telp" value="{{ $tempat->no_telp }}" readonly disabled>
                </div>
                <div class="mb-3">
                    <label for="alamat_kota" class="form-label">Kota</label>
                    <input type="text" class="form-control" name="alamat_kota" id="alamat_kota" value="{{ $tempat->alamat_kota }}" readonly disabled>                                 
                </div>
        </div>
        <div class="form-group mb-3">
            <label for="link_maps">Link Maps</label>
            <textarea class="form-control mt-2" id="link_maps" name="link_maps" rows="3" readonly disabled>{{ $tempat->link_maps }}</textarea>
        </div>
        <div class=" text-end">
            <a href="{{ route('tempat.index') }}" class="btn btn-secondary rounded">Kembali</a>
        </div>
    </div>
</div>
@endsection