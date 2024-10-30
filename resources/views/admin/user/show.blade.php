@extends('layouts.panel.index')
@section('title','Detail User')

@section('content')      
<style>
    .dropzone-wrapper {
    display: flex;
    align-items: center;
    justify-content: center;
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
            <div class="col">
                <h5 class="text-center mt-4">--Data Diri--</h5>
                    <div class="mb-3 ">
                        <label for="nama_lengkap" class="form-label">Nama Pengguna</label>
                        <input type="text" class="form-control" name="nama_lengkap"
                            id="nama_lengkap" value="{{ $pengguna->nama_lengkap ?? '   -   ' }}" disabled readonly >
                    </div>
                    <div class="mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" value="{{$pengguna->tempat_lahir ?? '   -   ' }}" disabled readonly>                                         
                    </div>
                    <div class="mb-3">
                        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="text" class="form-control" name="tgl_lahir" id="tgl_lahir" value="{{ $pengguna->tgl_lahir ?? '   -   ' }}" disabled readonly>
                    </div>                                                                
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis-Kelamin</label>    
                        <input type="text" class="form-control" name="jenis_kelamin" id="jenis_kelamin" value="{{ $pengguna->jenis_kelamin ?? '   -   ' }}" disabled readonly>
                    </div>  
                    <div class="mb-3">
                        <label for="nomor_induk" class="form-label">NIK</label>
                        <input type="number" class="form-control" name="nomor_induk" id="nomor_induk" value="{{ $pengguna->nomor_induk  ?? '   -   ' }}" disabled readonly >
                    </div>  
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="2"  disabled readonly >{{ $pengguna->alamat ?? '   -   ' }}</textarea>
                    </div>   
                    <div class="mb-3">
                        <label for="alamat_kota" class="form-label">Kota</label>    
                        <input type="text" class="form-control" name="alamat_kota" id="alamat_kota" value="{{ $pengguna->alamat_kota ?? '   -   ' }}" disabled readonly>
                    </div>                           
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>    
                        <input type="text" class="form-control" name="email" id="email" value="{{ $pengguna->email ?? '   -   ' }}" disabled readonly>
                    </div>
                    <div class="mb-3">
                        <label for="no" class="form-label">No. telp</label>
                        <input type="text" class="form-control" name="no_telp" id="no_telp" value="{{ $pengguna->no_telp ?? '   -   ' }}"disabled readonly >
                    </div>                             
            </div>
            <div class="col">
                <h5 class="text-center mt-4">--Data Pendidikan Terakhir--</h5>                                
                <div class="mb-3 ">
                    <label for="nama_sekolah" class="form-label">Nama Sekolah/Instansi</label>
                    <input type="text" class="form-control" name="nama_sekolah" id="nama_sekolah" value="{{ $pengguna->nama_sekolah ?? '   -   ' }}" disabled readonly >
                </div>
                <div class="mb-3">
                    <label for="jurusan" class="form-label">Jurusan</label>
                    <input type="text" class="form-control" name="jurusan" id="jurusan" value="{{ $pengguna->jurusan ?? '   -   ' }}" disabled readonly >
                </div>
                <div class="mb-3">
                    <label for="jenjang" class="form-label">Jenjang</label>
                    <input type="text" class="form-control" name="jenjang" id="jenjang" value="{{ $pengguna->jenjang ?? '   -   ' }}" disabled readonly>                               
                </div>
                <div class="mb-4">
                    <label for="tahun_lulus" class="form-label">Tahun Lulus</label>
                    <input type="email" class="form-control" name="tahun_lulus" id="tahun_lulus" value="{{ $pengguna->tahun_lulus ?? '   -   ' }}" disabled readonly>
                </div>
                @if(!empty($pengguna->nama_perusahaan)|| !empty($pengguna->alamat_perusahaan) || !empty($pengguna->alamat_kota_perusahaan) || !empty($pengguna->jabatan_pekerjaan) || !empty($pengguna->no_telp_perusahaan))
                <div class="data-pekerjaan">
                <h5 class="text-center">--Data Pekerjaan Sekarang--</h5>
                <div class="mb-3 mt-2 ">
                    <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                    <input type="text" class="form-control" name="nama_perusahaan" id="nama_perusahaan" value="{{ $pengguna->nama_perusahaan ?? '   -   ' }}" disabled readonly>
                </div>                       
                <div class="mb-3 ">
                    <label for="alamat_perusahaan" class="form-label">Alamat</label>
                    <input type="text" class="form-control" name="alamat_perusahaan" id="alamat_perusahaan" value="{{ $pengguna->alamat_perusahaan ?? '   -   ' }}" disabled readonly>
                </div>                        
                <div class="mb-3">
                    <label for="alamat_kota_perusahaan" class="form-label">Kota</label>
                    <input type="text" class="form-control" name="alamat_kota_perusahaan" id="alamat_kota_perusahaan" value="{{ $pengguna->alamat_kota_perusahaan ?? '   -   ' }}" disabled readonly>
                </div>                            
                <div class="mb-3">
                    <label for="jabatan_pekerjaan" class="form-label">Jabatan</label>
                    <input type="text" class="form-control" name="jabatan_pekerjaan" id="jabatan_pekerjaan" value="{{ $pengguna->jabatan_pekerjaan ?? '   -   ' }} " disabled readonly>
                </div>                            
                <div class="mb-3">
                    <label for="no_telp_perusahaan" class="form-label">Telepon Perusahaan</label>                                    
                    <input type="text" class="form-control" name="no_telp_perusahaan" id="no_telp_perusahaan" value="{{ $pengguna->no_telp_perusahaan ?? '   -   ' }}" disabled readonly>
                </div>   
                </div>                     
                @endif
            </div>
            <div class="form-group mb-3">
                <label class="control-label mb-2"> Foto Pengguna</label>
                <div class="dropzone-wrapper">                                       
                    <div id="image_preview_" class="mt-3 d-flex justify-content-center" disabled readonly>                                                  
                            <img  src="{{ asset($pengguna->path_foto) }}" alt="Image preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">                                             
                    </div>
                </div>                                       
            </div>
            <div class=" text-end">
                <a href="{{ route('user.index') }}" class="btn btn-secondary rounded">Kembali</a>
            </div>
        </div>
    </div>                                                                                               
@endsection