@extends('layouts.panel.index')
@section('title', 'Pengguna')
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
#image_preview {
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
#preview_image {
    max-width: 100%;
    max-height: 100%;
    object-fit: contain; 
    display: block; 
}

</style>

<div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg mt-4">
    <form action="{{ isset($pengguna) ? route('user.update', $pengguna->id_user) : route('user.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        {!! isset($pengguna) ? method_field('PUT') : '' !!}     
        <div class="container">
            <div class="row">
                <div class="col mb-3">
                    @if (isset($pengguna))
                        <input type="hidden" name="updated_by" value="{{ Auth::user()->id_user }}">
                    @else
                        <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">
                        <input type="hidden" name="password" value="Pengguna">
                        <input type="hidden" name="level" value="Pengguna">
                    @endif

                    <h5 class="text-center text-primary mb-4 rounded fw-bold">- Data Diri -</h5>

                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" value="{{old('nama_lengkap', isset($pengguna) ? $pengguna->nama_lengkap : '') }}"
                            required>
                            @error('nama_lengkap')
                            <div class="text-danger">{{ $message }}</div>
                           @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" value="{{old('tempat_lahir', isset($pengguna) ? $pengguna->tempat_lahir : '') }}"
                            required>
                            @error('tempat_lahir')
                            <div class="text-danger">{{ $message }}</div>
                           @enderror
                    </div>
                    <div class="mb-3">
                        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tgl_lahir"
                            id="tgl_lahir" placeholder="DD/MM/YYYY" value="{{old('tgl_lahir', isset($pengguna) ? $pengguna->tgl_lahir : '') }}" required>
                            @error('tgl_lahir')
                            <div class="text-danger">{{ $message }}</div>
                           @enderror
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                            <option selected disabled>Pilih...</option>
                            @if (isset($pengguna))
                                <option value="laki-laki" {{ $pengguna->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>Laki-Laki</option>
                                <option value="perempuan" {{ $pengguna->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                            @elseif (!isset($pengguna))
                            <option value="laki-laki" {{ old('jenis_kelamin', isset($pengguna) ? $pengguna->jenis_kelamin : '') == 'laki-laki' ? 'selected' : '' }}>Laki-Laki</option>
                            <option value="perempuan" {{ old('jenis_kelamin', isset($pengguna) ? $pengguna->jenis_kelamin : '') == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                            @endif
                        </select>
                        @error('jenis_lengkap')
                        <div class="text-danger">{{ $message }}</div>
                       @enderror
                    </div>
                    <div class="mb-3">
                        <label for="nomor_induk" class="form-label">NIK</label>
                        <input type="number" class="form-control" name="nomor_induk" id="nomor_induk" value="{{old('nomor_induk', isset($pengguna) ? $pengguna->nomor_induk : '') }}"
                            required>
                            @error('nomor_induk')
                            <div class="text-danger">{{ $message }}</div>
                           @enderror
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="2" required>{{ old('alamat',isset($pengguna) ? $pengguna->alamat : '') }}</textarea>
                        @error('alamat')
                        <div class="text-danger">{{ $message }}</div>
                       @enderror
                    </div>
                    <div class="mb-3">
                        <label for="alamat_kota" class="form-label">Kota</label>
                        <select class="form-select js-example-basic-single" name="alamat_kota" id="alamat_kota" data-placeholder="Pilih Kota" required>
                            <option disabled selected></option> 
                            {{-- @foreach ($regencies as $id => $name)
                            <option value="{{ $name }}" {{ (old('alamat_kota', isset($pengguna) ? $pengguna->alamat_kota : '') == $name) ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach --}}
                        </select>
                        @error('alamat_kota')
                        <div class="text-danger">{{ $message }}</div>
                       @enderror
                        {{-- <textarea class="form-control" id="alamat_kota" name="alamat_kota" rows="2" required>{{ isset($pengguna) ? $pengguna->alamat_kota : '' }}</textarea> --}}
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" name="email" id="email" value="{{old('email',  isset($pengguna) ? $pengguna->email : '') }}"
                            required>
                            @error('email')
                            <div class="text-danger">{{ $message }}</div>
                           @enderror
                    </div>
                    <div class="mb-3">
                        <label for="no_telp" class="form-label">Telepon</label>
                        <input type="number" class="form-control" name="no_telp" id="no_telp" value="{{old('no_telp', isset($pengguna) ? $pengguna->no_telp : '') }}"
                            required>
                            @error('no_telp')
                            <div class="text-danger">{{ $message }}</div>
                           @enderror
                    </div>               
                </div>

                <div class="col">
                    <h5 class="text-center text-primary mb-4 fw-bold rounded">- Data Pendidikan Terakhir -</h5>                    
                    <div class="mt-3">
                        <label for="nama_sekolah" class="form-label">Nama Sekolah/Universitas</label>
                        <select class="form-select js-example-basic-single" name="instansi_id" id="instansi_id" data-placeholder="Pilih Instansi"   required>               
                            <option disabled selected></option> 
                            @foreach ($institutions as $id_instansi => $name)
                            <option value="{{ $id_instansi }}" {{old('instansi_id', (isset($pengguna) ? $pengguna->instansi_id : '') == $id_instansi) ? 'selected' : '' }}>{{ $name }}</option>                         
                            @endforeach
                        </select>
                        @error('nama_sekolah')
                        <div class="text-danger">{{ $message }}</div>
                       @enderror
                        {{-- <input type="text" class="form-control" name="nama_sekolah" id="nama_sekolah"
                            required value="{{ isset($pengguna) ? $pengguna->nama_sekolah : '' }}"> --}}
                    </div>
                    <div class="mt-3">
                        <label for="jurusan" class="form-label">Jurusan</label>
                        <input type="text" class="form-control" name="jurusan" id="jurusan"
                            required value="{{old('jurusan', isset($pengguna) ? $pengguna->jurusan : '') }}">
                            @error('jurusan')
                            <div class="text-danger">{{ $message }}</div>
                           @enderror
                    </div>
                    <div class="mt-3">
                        <label for="jenjang" class="form-label">Jenjang</label>
                        <input type="text" class="form-control" name="jenjang" id="jenjang"
                            required value="{{old('jenjang', isset($pengguna) ? $pengguna->jenjang : '') }}">
                            @error('jenjang')
                            <div class="text-danger">{{ $message }}</div>
                           @enderror
                    </div>
                    <div class="mt-3">
                        <label for="tahun_lulus" class="form-label">Tahun Lulus</label>
                        <input type="number" class="form-control" name="tahun_lulus" id="tahun_lulus"
                            required value="{{old('tahun_lulus', isset($pengguna) ? $pengguna->tahun_lulus : '') }}">
                            @error('tahun_lulus')
                            <div class="text-danger">{{ $message }}</div>
                           @enderror
                    </div>
                    <h5 class="text-center text-primary mt-2 fw-bold rounded" style="margin-bottom: 28px;">- Data Pekerjaan Sekarang -</h5>
                    
                    <div class="mt-1">
                        <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                        <input type="text" class="form-control" name="nama_perusahaan" id="nama_perusahaan"
                             value="{{old('nama_perusahaan', isset($pengguna) ? $pengguna->nama_perusahaan : '') }}">
                             @error('nama_perusahaan')
                             <div class="text-danger">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="mt-1">
                        <label for="alamat_perusahaan" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat_perusahaan" name="alamat_perusahaan" rows="2" >{{old('alamat_perusahaan', isset($pengguna) ? $pengguna->alamat_perusahaan : '') }}</textarea>
                        @error('alamat_perusahaan')
                        <div class="text-danger">{{ $message }}</div>
                       @enderror
                    </div>
                    <div class="mt-2">
                        <label for="alamat_kota_perusahaan" class="form-label">Kota</label>
                        <select class="form-select js-example-basic-single" name="alamat_kota_perusahaan" id="alamat_kota_perusahaan" data-placeholder="Pilih Kota Perusahaan" >
                            <option disabled selected></option> 
                            {{-- @foreach ($regencies as $id => $name)
                            <option value="{{ $name }}" {{old('alamat_kota_perusahaan', (isset($pengguna) ? $pengguna->alamat_kota_perusahaan : '') == $id) ? 'selected' : '' }}>{{ $name }}</option>
                            @endforeach --}}
                        </select>
                        @error('alamat_kota_perusahaan')
                        <div class="text-danger">{{ $message }}</div>
                       @enderror
                        {{-- <textarea class="form-control" id="alamat_kota_perusahaan" name="alamat_kota_perusahaan" rows="2" >{{ isset($pengguna) ? $pengguna->alamat_kota_perusahaan : '' }}</textarea> --}}
                    </div>
                    <div class="mt-2">
                        <label for="jabatan_pekerjaan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan_pekerjaan" id="jabatan_pekerjaan"
                             value="{{old('jabatan_pekerjaan', isset($pengguna) ? $pengguna->jabatan_pekerjaan : '') }}">
                             @error('jabatan_pekerjaan')
                             <div class="text-danger">{{ $message }}</div>
                            @enderror
                    </div>
                    <div class="mt-2">
                        <label for="no_telp_perusahaan" class="form-label">Telepon Perusahaan</label>
                        <input type="number" class="form-control" name="no_telp_perusahaan" id="no_telp_perusahaan"
                             value="{{old('no_telp_perusahaan', isset($pengguna) ? $pengguna->no_telp_perusahaan : '') }}">
                             @error('no_telp_perusahaan')
                             <div class="text-danger">{{ $message }}</div>
                            @enderror
                    </div>                             
                </div>
                    <div class="form-group ">
                        <label class="control-label mb-2">Upload Foto Pengguna <span class="text-danger">*</span></label>
                        <div class="dropzone-wrapper">
                            <div class="dropzone-desc">
                                <i class="glyphicon glyphicon-download-alt"></i>
                                <p>Pilih gambar atau seret ke sini .</p>
                            </div>
                            <input type="file" name="path_foto" class="dropzone" id="path_foto" accept="image/*"
                                {{ isset($pengguna) && $pengguna->path_foto ? '' : ' required' }}>
                            <div id="image_preview" class="mt-3">
                                <img id="preview_image" src="{{ isset($pengguna) ? asset($pengguna->path_foto) : '' }}" alt="Image preview"
                                    style="max-width: 100%; max-height: 100%; object-fit: contain; display: {{ isset($pengguna) ? 'block' : 'none' }};">
                            </div>
                        </div>
                        <div class="mt-4">
                            <small style="color: red;">Format harus berupa: .jpg, .jpeg, .png, .bmp dan ukuran maksimal 2mb</small>
                        </div>
                        @error('path_foto')
                        <div class="text-danger">{{ $message }}</div>
                    @enderror
                    </div>
                    <div class="modal-footer justify-content-left px-3 ">                 
                        <div class=" text-end mx-1">
                            <a href="{{ route('user.index') }}" class="btn btn-danger rounded">Batal</a>
                        </div>
                        <div class="mx-1">
                            <button type="submit" class="btn btn-success rounded text-white">Simpan</button>
                        </div>                    
                </div>
                <!-- <div class="d-grid mt-3 ">
                    <button type="submit" class="btn btn-primary rounded">Simpan</button>
                </div> -->
                
            </div>
        </div>
    </form>
</div>

@endsection
@push('script')
<script>
    $(document).ready(function() {
        // Inisialisasi Select2 untuk semua elemen dengan kelas .js-example-basic-single
        $('.js-example-basic-single').each(function() {
            var placeholder = $(this).data('placeholder');
            
            $(this).select2({
                placeholder: placeholder,
                allowClear: true,
                theme: "bootstrap-5"
                // Opsi dropdownParent tidak diperlukan karena ini bukan modal
            });
        });

        // Mengatur placeholder dinamis untuk KOTAK PENCARIAN
        $('.js-example-basic-single').on('select2:open', function(e) {
            var name = $(this).attr('name');
            var placeholderText = 'Cari...'; // Default

            if (name === 'instansi_id') {
                placeholderText = 'Cari Instansi...';
            } else if (name === 'alamat_kota' || name === 'alamat_kota_perusahaan') {
                placeholderText = 'Cari Kota...';
            }
            
            var searchField = document.querySelector('.select2-search__field');
            if (searchField) {
                searchField.placeholder = placeholderText;
            }
        });
    });
</script>
@endpush

@push('script')
    {{-- <script>
        var button = document.getElementById('add')
        button.style.display = 'none';
     
    </script> --}}

    <script>
       $(document).ready(function() {
    //     $('.js-example-basic-single').each(function() {
    //         var placeholder = $(this).data('placeholder'); 
            
    //         $(this).select2({
    //             placeholder: placeholder, 
    //             allowClear: true,
    //             minimumResultsForSearch: Infinity 
    //         });
    //     });
        // menampilkan gambar 
        document.getElementById('path_foto').addEventListener('change', function (event) {
            const file = event.target.files[0];
            const preview = document.getElementById('preview_image');
            
            if (file) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block'; // Show the image preview
                }
                reader.readAsDataURL(file);
            }
        });
    
           // Inisialisasi Dropzone
           Dropzone.autoDiscover = false;
        var myDropzone = new Dropzone(".dropzone-wrapper", {
            url: "/user", // URL server untuk unggahan
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
    
@endpush

