@extends('layouts.panel.index')
@section('title','Detail Penguji')

@section('content')
      {{-- Rincian --}}
                   <div class="modal-body">                
                      <div class="container">
                          <div class="row">
                              <div class="mb-3">
                                  <label for="page" class="form-label">Page Id</label>
                                  <input type="text" class="form-control" name="page" id="page" value="{{ \App\Models\Page::find($penguji->page_id)->nama_page ?? 'Nama halaman tidak ditemukan '}}" disabled readonly>
                              </div>
                              <div class="col">
                                      <div class="mb-3">
                                          <label for="nama_lengkap" class="form-label">Nama Mentor</label>
                                          <input type="text" class="form-control" name="nama_lengkap"
                                              id="nama_lengkap" value="{{ $penguji->nama_lengkap }}" disabled readonly >
                                      </div>
                                      <div class="mb-3">
                                          <label for="instansi_id_{{ $penguji->id_user }}" class="form-label">Instansi</label>
                                          <input type="text" class="form-control" name="instansi" id="instansi_{{ $penguji->id_user }}" value="{{ $institutions[$penguji->instansi_id] ?? ''}}" disabled readonly>                                         
                                      </div>
                                      <div class="mb-3">
                                          <label for="alamat" class="form-label">Alamat</label>
                                          <textarea class="form-control" id="alamat" name="alamat" rows="2"  disabled readonly >{{ $penguji->alamat }}</textarea>
                                      </div>
                                      <div class="mb-2">
                                          <label for="no" class="form-label">No. telp</label>
                                          <input type="text" class="form-control" name="no_telp" id="no_telp" value="{{ $penguji->no_telp }}"disabled readonly >
                                      </div>    
                                      <div class="mb-3">
                                          <label for="keahlian" class="form-label">Keahlian</label>
                                          <textarea name="keahlian" id="keahlian" class="form-control"  rows="2" disabled readonly>{{ $penguji->keahlian }}</textarea>
                                      </div>                                   
                              </div>
                              <div class="col">
                                  {{-- kiri --}}
                                  <div class="mb-3">
                                      <label for="nomor_induk" class="form-label">NIK</label>
                                      <input type="text" class="form-control" name="nomor_induk"
                                          id="nomor_induk" value="{{ $penguji->nomor_induk }}" disabled readonly >
                                  </div>
                                  <div class="mb-3">
                                      <label for="jabatan_penguji" class="form-label">Jabatan</label>
                                      <input type="text" class="form-control" name="jabatan_penguji"
                                          id="jabatan_penguji" value="{{ $penguji->jabatan_penguji }}" disabled readonly >
                                  </div>
                                  <div class="mb-3">
                                      <label for="alamat_kota_{{ $penguji->id_user }}" class="form-label">Kota Perusahaan</label>                                      
                                      <input type="text" class="form-control" name="alamat_kota" id="alamat_kota" value="{{ $penguji->alamat_kota }}" disabled readonly>                               
                                  </div>
                                  <div class="mb- mt-5">
                                      <label for="email" class="form-label">Email</label>
                                      <input type="email" class="form-control" name="email" id="email" value="{{ $penguji->email }}" disabled readonly>
                                  </div>                                                                                        
                                  <div class="mb-3 mt-3 ">
                                      <label for="pengalaman" class="form-label">Pengalaman Berapa Tahun</label>
                                      <textarea name="pengalaman" id="pengalaman" class="form-control"  rows="2" disabled readonly>{{ $penguji->pengalaman }}</textarea>
                                  </div>   
                              </div>
                              <div class="form-group mb-3">
                                  <label class="control-label mb-2"> Foto Mentor <span class="text-danger">*</span></label>
                                  <div class="dropzone-wrapper">                                       
                                      <div id="image_preview_" class="mt-3 d-flex justify-content-center" disabled readonly>                                                  
                                              <img  src="{{ asset($penguji->path_foto) }}" alt="Image preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">                                             
                                      </div>
                                  </div>                                       
                              </div>
                          </div>
                          <div class=" text-end">
                            <a href="{{ route('penguji.index') }}" class="btn btn-secondary rounded">Kembali</a>
                        </div>
                      </div>                  
                   </div>                                                                 
@endsection