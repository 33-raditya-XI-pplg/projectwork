@extends('layouts.panel.index')
@section('title', 'Penguji')
@section('content')
<style>
    .select2-close-mask{
        z-index: 2099 !important;
    }
    .select2-dropdown{
        z-index: 3051 !important;
    }

.btn-kembali{
    background-color: #3498db;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius:5px;
    cursor: pointer;
    font-size: 16px;
    transition: background-color 0.3s ease,transform 0.3s ease;
}
.btn-kembali:hover{
    background-color: #2980b9;
    transform: scale(1.05);
}
.btn-kembali:active{
    transform: scale(0.95);
    background-color: #1f5e83;
}

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
   #preview_image_create, #preview_image_edit_ {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain; 
    display: block; 
}
   </style>

        <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
            <table id="example" class="table">
                <thead class="fw-normal">
                    <th>No</th>
                    <th>Page Id</th>
                    <th scope="col">Nama Mentor</th>
                    <th scope="col">Instansi</th>
                    <th scope="col">NIK</th>
                    <th scope="col">Jabatan</th>
                    <th scope="col">Status</th>
                    <th scope="col">Aksi</th>
                </thead>
                <tbody class="" style="vertical-align: middle">
                    @foreach ($penguji as $row)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>{{ \App\Models\Page::find($row->page_id)->nama_page ?? '- '}}</td>
                            <td>{{ $row->nama_lengkap }}</td>
                            <td>{{ $row->userInstansi->nama_instansi }}</td>
                            <td>{{ $row->nomor_induk }}</td>
                            <td>{{ $row->jabatan_penguji }}</td>
                            <td>
                                @php
                                $statusClass = 'bg-danger';   
                                $statusLabel = 'Belum Verified';

                                if($row->status == 'Verified'){
                                    $statusClass = 'bg-success';
                                    $statusLabel = 'Verified';
                                }elseif(!$row->isProfileComplete){
                                    $statusClass = 'bg-warning';
                                    $statusLabel = 'Profile Belum Lengkap';
                                }
                            @endphp
                            <button type="button"
                                class="badge rounded-3 {{ $statusClass }}"
                                onclick="toggleStatus({{ $row->id_user }},this)">
                                {{ $statusLabel}}                                
                            </button>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-bars"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item text-dark" href="#" data-bs-toggle="modal"
                                            data-bs-target="#rincian{{ $row->id_user }}"><i class="fa-solid fa-code pe-none"></i>
                                            Rincian</a>
                                        </li>
                                        <li><a class="dropdown-item text-info" href="#" data-bs-toggle="modal"
                                                data-bs-target="#edit{{ $row->id_user }}"><i
                                                    class="fa-regular fa-pen-to-square"></i> Edit</a>
                                        </li>
                                        <li><a href="{{ route('penguji.destroy', $row->id_user) }}" class="dropdown-item text-danger"
                                                data-confirm-delete="true"><i class="fa-regular fa-trash-can pe-none"></i>
                                                Delete</a>
                                        </li>                                      
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>



    <!-- insert -->
    <div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="add" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary-gradient text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Tambah Mentor</h5>
                    <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('penguji.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">
                        <input type="hidden" name="password" value="Penguji">
                        <input type="hidden" name="level" value="Penguji">

                    {{-- form --}}
                    <div class="container">
                        <div class="row">
                            <div class="mb-3">
                                <label for="page_id" class="form-label">Page Id</label>
                                <select class="form-select js-example-basic-single" name="page_id" aria-label="Default select example" data-placeholder="Pilih Page"
                                        required>
                                        <option disabled selected></option>
                                        @foreach ($page as $row)
                                        <option value="{{ $row->id_page }}" >{{ $row->nama_page }}</option>
                                        @endforeach
                                </select>
                            </div>
                            <div class="col">
                                {{-- kanan --}}                        
                                    <div class="mb-3">
                                        <label for="nama_lengkap" class="form-label">Nama Mentor</label>
                                        <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap"
                                        value="{{old('nama_lengkap', isset($pengguji) ? $pengguji->nama_lengkap : '') }}" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="instansi_id" class="form-label">Instansi</label>
                                        <select class="form-select js-example-basic-single" name="instansi_id" id="instansi_id" data-placeholder="Pilih Instansi" required>
                                            <option value="" disabled selected></option> 
                                            @foreach ($institutions as $id_instansi => $name)
                                                <option value="{{ $id_instansi }}" {{ old('instansi_id') == $id_instansi ? 'selected' : '' }}>{{ $name }}</option>                         
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="alamat" name="alamat" rows="2" required>{{ old('alamat',isset($pengguji) ? $pengguji->alamat : '') }}</textarea>
                                    </div>
                                    <div class="mb-3">
                                        <label for="no_telp" class="form-label">No. telp</label>
                                        <input type="number" class="form-control" name="no_telp" id="no_telp"
                                        value="{{old('no_telp', isset($pengguji) ? $pengguji->no_telp : '') }}"  required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label class="control-label mb-2">Upload Foto Mentor <span class="text-danger">*</span></label>
                                        <div class="dropzone-wrapper">
                                            <div class="dropzone-desc">
                                                <i class="glyphicon glyphicon-download-alt"></i>
                                                <p>Pilih gambar atau seret ke sini .</p>
                                            </div>
                                            <input type="file" name="path_foto" class="dropzone" accept="image/*" required>
                                            <div id="image_preview_" class="mt-3">
                                                <img id="preview_image_create" src="" alt="Image preview" style="display: none;">
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <small style="color: red;">Format harus berupa: .jpg, .jpeg, .png, .bmp dan ukuran maksimal 2mb</small>
                                        </div>
                                        @error('foto')
                                        <div class="text-danger">{{ $message }}</div>
                                       @enderror
                                    </div>

                            </div>
                            <div class="col">
                                {{-- kiri --}}
                                <div class="mb-3">
                                    <label for="nomor_induk" class="form-label">NIK</label>
                                    <input type="number" class="form-control" name="nomor_induk"
                                        id="nomor_induk" value="{{old('nomor_induk', isset($pengguji) ? $pengguji->nomor_induk : '') }}"  required>
                                </div>
                                <div class="mb-2">
                                    <label for="jabatan_penguji" class="form-label">Jabatan</label>
                                    <input type="text" class="form-control" name="jabatan_penguji" id="jabatan_penguji" 
                                    value="{{old('jabatan_penguji', isset($pengguji) ? $pengguji->jabatan_penguji : '') }}" required>
                                </div>
                                <div class="mb-5">
                                    <label for="alamat_kota" class="form-label">Kota</label>
                                    <select class="form-select js-example-basic-single" name="alamat_kota" id="alamat_kota" data-placeholder="Pilih Kota" required>                                   
                                        <option value="" disabled selected></option> 
                                        @foreach ($regencies as $id => $name)
                                        <option value="{{ $name }}" {{ old('alamat_kota', $row->alamat_kota) == $name ? 'selected' : '' }}>{{ $name }}</option>
                                        @endforeach
                                    </select>
                                    @error('alamat_kota')
                                        <div class="text-danger">{{ $message }}</div>
                                    @enderror
                                </div>
                                <div class="mb-4 mt-5">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" name="email" id="email" 
                                    value="{{old('email', isset($pengguji) ? $pengguji->email : '') }}"  required>
                                    @error('email')
                                    <div class="text-danger">{{ $message }}</div>
                                   @enderror
                                </div>   
                                <div class="mb-3 mt-5">
                                    <label for="keahlian" class="form-label">Keahlian</label>
                                    <textarea name="keahlian" id="keahlian" class="form-control"  rows="2">{{ old('keahlian',isset($pengguji) ? $pengguji->keahlian : '') }}</textarea>
                                </div>                            
                                <div class="mb-3 ">
                                    <label for="pengalaman" class="form-label">Pengalaman Berapa Tahun</label>
                                    <textarea name="pengalaman" id="pengalaman" class="form-control"  rows="2">{{ old('pengalaman',isset($pengguji) ? $pengguji->pengalaman : '') }}</textarea>
                                </div>                            
                            </div>
                        </div>
                    </div>
                    {{-- end form --}}

                </div>
                <div class="modal-footer justify-content-between mx-3">
                    <div class="form-check form-switch mb-3">
                        {{-- <label for="status" class="me-3">Status</label>
                        <input class="form-check-input" type="checkbox" role="switch" id="status"
                            name="status" value="Aktif"> --}}
                    </div>
                    <div>
                        <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success rounded-3 text-white">Simpan</button>
                    </div>
                </div>
                </form>
            </div>
        </div>
    </div>

    @foreach ($penguji as $row)
            {{-- {{ dd($penguji) }} --}}
        <!-- edit -->
        <div class="modal modal-lg fade" id="edit{{ $row->id_user }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary-gradient text-white">
                        <h5 class="modal-title" id="exampleModalLabel">Edit Mentor</h5>
                        <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                <form action="{{ route('penguji.update', $row->id_user) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="updated_by" value="{{ Auth::user()->id_user }}">   

                    <div class="modal-body">
                        {{-- {{ dd($row) }} --}}
                        {{-- form --}}
                        <div class="container">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="page_id" class="form-label">Page Id</label>
                                    <select class="form-select js-example-basic-single" name="page_id" aria-label="Default select example" data-placeholder="Pilih Page id"
                                            required>
                                            @foreach ($page as $set)
                                            <option value="{{ $set->id_page }}" {{ $set->id_page == $row->page_id ? 'selected' : '' }}>{{ $set->nama_page }}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="col">
                                    {{-- kanan --}}                                                                    
                                        <div class="mb-3">
                                            <label for="nama_lengkap" class="form-label">Nama Mentor</label>
                                            <input type="text" class="form-control" name="nama_lengkap"
                                                id="nama_lengkap" value="{{ $row->nama_lengkap }}" required>
                                        </div>
                                        <div class="mb-4">
                                            <label for="instansi_id_{{ $row->id_user }}" class="form-label">Instansi</label>
                                            <select class="form-select js-example-basic-single" name="instansi_id" id="instansi_id_{{ $row->id_user }}" data-placeholder="Pilih Instansi" required>
                                                <option value="" disabled selected></option> 
                                                @foreach ($institutions as $id_instansi => $name)
                                                    <option value="{{ $id_instansi }}" {{ old('instansi_id', $row->instansi_id) == $id_instansi ? 'selected' : '' }}>{{ $name }}</option>                        
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control" id="alamat" name="alamat" rows="2" required>{{ $row->alamat }}</textarea>
                                        </div>
                                        <div class="mb-4">
                                            <label for="no" class="form-label">No. telp</label>
                                            <input type="number" class="form-control" name="no_telp" id="no_telp" value="{{ $row->no_telp }}" required>
                                        </div>
                                        <div class="form-group mb-3">
                                            <label class="control-label mb-2">Upload Foto Mentor <span class="text-danger">*</span></label>
                                            <div class="dropzone-wrapper">
                                                <div class="dropzone-desc">
                                                    <i class="glyphicon glyphicon-download-alt"></i>
                                                    <p>Pilih gambar atau seret ke sini .</p>
                                                </div>
                                                <input type="file" name="path_foto" class="dropzone" id="path_foto_{{ $row->id_user }}" accept="image/*">
                                                <div id="image_preview_" class="mt-3 d-flex justify-content-center">
                                                    @if($row->path_foto)
                                                        <img id="preview_image_edit_{{ $row->id_user }}" src="{{ asset($row->path_foto) }}" alt="Image preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                    @else
                                                        <img id="preview_image_edit_{{ $row->id_user }}" src="" alt="No image uploaded" style="max-width: 100%; max-height: 100%; object-fit: contain;">
                                                    @endif
                                                </div>
                                            </div>
                                            <div class="mt-2">
                                                <small style="color: red;">Format harus berupa: .jpg, .jpeg, .png, .bmp dan ukuran maksimal 2mb</small>
                                            </div>
                                            @error('path_foto')
                                            <div class="text-danger">{{ $message }}</div>
                                           @enderror
                                        </div>

                                            </div>
                                            <div class="col">
                                                {{-- kiri --}}
                                                <div class="mb-3">
                                                    <label for="nomor_induk" class="form-label">NIK</label>
                                                    <input type="number" class="form-control" name="nomor_induk"
                                                        id="nomor_induk" value="{{ $row->nomor_induk }}" required>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="jabatan_penguji" class="form-label">Jabatan</label>
                                                    <input type="text" class="form-control" name="jabatan_penguji"
                                                        id="jabatan_penguji" value="{{ $row->jabatan_penguji }}" required>
                                                </div>
                                                <div class="mb-2">
                                                    <label for="alamat_kota_{{ $row->id_user }}" class="form-label">Kota</label>
                                                    <select class="form-select js-example-basic-single" name="alamat_kota" id="alamat_kota_{{ $row->id_user }}" data-placeholder="Pilih Kota" required>
                                                        <option value="" disabled selected></option> 
                                                        @foreach ($regencies as $id => $name)
                                                            <option value="{{ $name }}" {{ old('alamat_kota', $row->alamat_kota) == $name ? 'selected' : '' }}>{{ $name }}</option>
                                                        @endforeach
                                                    </select>
                                                    @error('alamat_kota')
                                                        <div class="text-danger">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                                <div class="mb-3 mt-5">
                                                    <label for="email" class="form-label">Email</label>
                                                    <input type="email" class="form-control" name="email" id="email" value="{{ $row->email }}" required>
                                                </div>  
                                                <div class="mb-3 mt-5">
                                                    <label for="keahlian" class="form-label">Keahlian</label>
                                                    <textarea name="keahlian" id="keahlian" class="form-control"  rows="2">{{ $row->keahlian }}</textarea>
                                                </div>                            
                                                <div class="mb-3 ">
                                                    <label for="pengalaman" class="form-label">Pengalaman Berapa Tahun</label>
                                                    <textarea name="pengalaman" id="pengalaman" class="form-control"  rows="2">{{ $row->pengalaman }}</textarea>
                                                </div>                            

                                            </div>
                                        </div>
                                    </div>
                        {{-- end form --}}

                    </div>

                    <div class="modal-footer justify-content-between mx-3">
                        <div class="form-check form-switch">
                            {{-- <label for="status" class="me-3">Status</label>
                            <input class="form-check-input" type="checkbox" role="switch" id="status"
                                name="status" value="Aktif" {{ $row->status == 'Aktif' ? 'checked' : '' }}> --}}
                        </div>
                        <div>
                            <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success rounded-3 text-white">Simpan</button>
                        </div>
                    </div>
                </form>
                </div>
            </div>
        </div>
    @endforeach

    {{-- Rincian --}}
    @foreach ($penguji as $row)
        <div class="modal modal-lg fade" id="rincian{{ $row->id_user }}">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary-gradient text-white">
                        <h5 class="modal-title" id="exampleModalLabel">Rincian Mentor</h5>
                        <button type="button" class="btn-kembali rounded-3" data-bs-dismiss="modal">Kembali</button> 
                    </div>
                     <div class="modal-body">                
                        <div class="container">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="page" class="form-label">Page Id</label>
                                    <input type="text" class="form-control" name="page" id="page" value="{{ \App\Models\Page::find($row->page_id)->nama_page ?? 'Nama halaman tidak ditemukan '}}" disabled readonly>
                                </div>
                                <div class="col">
                                        <div class="mb-3">
                                            <label for="nama_lengkap" class="form-label">Nama Mentor</label>
                                            <input type="text" class="form-control" name="nama_lengkap"
                                                id="nama_lengkap" value="{{ $row->nama_lengkap }}" disabled readonly >
                                        </div>
                                        <div class="mb-3">
                                            <label for="instansi_id_{{ $row->id_user }}" class="form-label">Instansi</label>
                                            <input type="text" class="form-control" name="instansi" id="instansi_{{ $row->id_user }}" value="{{ $institutions[$row->instansi_id] ?? ''}}" disabled readonly>                                         
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control" id="alamat" name="alamat" rows="2"  disabled readonly >{{ $row->alamat }}</textarea>
                                        </div>
                                        <div class="mb-2">
                                            <label for="no" class="form-label">No. telp</label>
                                            <input type="text" class="form-control" name="no_telp" id="no_telp" value="{{ $row->no_telp }}"disabled readonly >
                                        </div>    
                                        <div class="mb-3">
                                            <label for="keahlian" class="form-label">Keahlian</label>
                                            <textarea name="keahlian" id="keahlian" class="form-control"  rows="2" disabled readonly>{{ $row->keahlian }}</textarea>
                                        </div>                                   
                                </div>
                                <div class="col">
                                    {{-- kiri --}}
                                    <div class="mb-3">
                                        <label for="nomor_induk" class="form-label">NIK</label>
                                        <input type="text" class="form-control" name="nomor_induk"
                                            id="nomor_induk" value="{{ $row->nomor_induk }}" disabled readonly >
                                    </div>
                                    <div class="mb-3">
                                        <label for="jabatan_penguji" class="form-label">Jabatan</label>
                                        <input type="text" class="form-control" name="jabatan_penguji"
                                            id="jabatan_penguji" value="{{ $row->jabatan_penguji }}" disabled readonly >
                                    </div>
                                    <div class="mb-3">
                                        <label for="alamat_kota_{{ $row->id_user }}" class="form-label">Kota Perusahaan</label>                                      
                                        <input type="text" class="form-control" name="alamat_kota" id="alamat_kota" value="{{ $row->alamat_kota }}" disabled readonly>                               
                                    </div>
                                    <div class="mb- mt-5">
                                        <label for="email" class="form-label">Email</label>
                                        <input type="email" class="form-control" name="email" id="email" value="{{ $row->email }}" disabled readonly>
                                    </div>                                                                                        
                                    <div class="mb-3 mt-3 ">
                                        <label for="pengalaman" class="form-label">Pengalaman Berapa Tahun</label>
                                        <textarea name="pengalaman" id="pengalaman" class="form-control"  rows="2" disabled readonly>{{ $row->pengalaman }}</textarea>
                                    </div>   
                                </div>
                                <div class="form-group mb-3">
                                    <label class="control-label mb-2"> Foto Mentor <span class="text-danger">*</span></label>
                                    <div class="dropzone-wrapper">                                       
                                        <div id="image_preview_" class="mt-3 d-flex justify-content-center" disabled readonly>                                                  
                                                <img  src="{{ asset($row->path_foto) }}" alt="Image preview" style="max-width: 100%; max-height: 100%; object-fit: contain;">                                             
                                        </div>
                                    </div>                                       
                                </div>
                            </div>
                        </div>                  
                     </div>                                                         
                    </div>                
                </div>
            </div>
        </div>
    @endforeach

<!-- Include JS Select2 -->
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script> --}}
{{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script> --}}
    {{-- <script>
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
    </script> --}}
    <script>    
    function toggleStatus(userId, button) {
    if (!button) {
            console.error('Elemen button tidak terdefinisi');
            return;
        }

        let currentStatus = button.innerText.trim();

        // Jika statusnya adalah "Profile Belum Lengkap", tidak perlu melanjutkan eksekusi
        if (currentStatus === 'Profile Belum Lengkap') {
            Swal.fire({
                icon: 'error',
                title: 'Gagal Verifikasi',
                text: 'Pengguna belum melengkapi profile. Tidak dapat memverifikasi.',
                timer:2000,
            });
            return;
        }

        let newStatus = (currentStatus === 'Verified') ? 'Belum Verified' : 'Verified';

        console.log('UserID:', userId, 'Current Status:', currentStatus, 'New Status:', newStatus);

        $.ajax({
            url: '{{ route('penguji.updateStatus', ':id') }}'.replace(':id', userId),
            type: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                status: newStatus
            },
            success: function(response) {
                console.log('Respon server:', response.message);

                // Update status tombol jika berhasil
                if (newStatus === 'Verified') {
                    button.classList.remove('bg-danger', 'bg-warning');
                    button.classList.add('bg-success');
                    button.innerText = 'Verified';
                } else {
                    button.classList.remove('bg-success', 'bg-warning');
                    button.classList.add('bg-danger');
                    button.innerText = 'Belum Verified';
                }
            },
            error: function(xhr, status, error) {
                if (xhr.status === 400) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan',
                        text: xhr.responseJSON.message,
                        position: 'top',
                        width: '450px',
                        showConfirmButton: false,
                        timer: 5000,
                        toast: true,
                    });
                } else {
                    console.error('Gagal memperbarui status:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Kesalahan',
                        text: 'Terjadi kesalahan saat memperbarui status',
                    });
                }
            }
            });
        }

       document.addEventListener('DOMContentLoaded', function() {
        // Inisialisasi preview image
        const inputFile = document.querySelector('input[name="path_foto"]');
        const preview = document.getElementById('preview_image_create');


        if (preview) {
        preview.style.display = 'none';

        inputFile.addEventListener('change', function(event) {
            const file = event.target.files[0];
            const reader = new FileReader();

            reader.onload = function(e) {
                if (preview) { // Cek apakah preview tidak null
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                } else {
                    console.error('Preview element not found');
                }
            }

                if (file) {
                    reader.readAsDataURL(file);
                } else {
                    if (preview) {
                        preview.src = '';
                        preview.style.display = 'none';
                    }
                }
            });
        } else {
            console.error('Preview image element not found');
        }
    

        // Inisialisasi Dropzone
        Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone(".dropzone-wrapper", {
            url: "/penguji", // URL server untuk unggahan
            maxFilesize: 2, 
            acceptedFiles: "image/*",
            init: function() {
                this.on("success", function(file, response) {                    
                    // Tangani response sukses
                    console.log("Upload successful");
                });
                this.on("error", function(file, response) {
                    const errorElement = document.getElementById('image_error');
                    if (errorElement) {
                        errorElement.innerHTML = response.message || 'Upload failed';
                    }
                });
            }
        });
    }); 
</script> 
<script>
  document.querySelectorAll('[id^="path_foto"]').forEach(input => {
    input.addEventListener('change', function(event) {
        const id = this.id.split('_')[2]; // Mengambil ID dari input
        const preview = document.getElementById(`preview_image_edit_${id}`); // Mengambil elemen preview yang sesuai
        const file = event.target.files[0];
        const reader = new FileReader();

        reader.onload = function(e) {
            preview.src = e.target.result;
            preview.style.display = 'block'; // Tampilkan preview gambar
        }

        if (file) {
            reader.readAsDataURL(file);
        } else {
            preview.src = '';
            preview.style.display = 'none'; // Sembunyikan gambar jika tidak ada file
        }
    });
  });
</script>
@endsection
