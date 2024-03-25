@extends('layouts.panel.index')
@section('title', 'Edit Pengguna')
@section('content')

<div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
    <form action="{{ route('user.update', $user->id_user) }}" method="POST" enctype="multipart/form-data">
        @csrf        
        @method('PUT')
        <div class="container">
            <div class="row">
                <div class="col">
                    <input type="hidden" name="updated_by" value="{{ Auth::user()->id_user }}">
                    <h5 class="text-center text-primary mb-4 rounded fw-bold">- Data Diri -</h5>

                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap"
                            required value="{{ $user->nama_lengkap }}">
                    </div>
                    <div class="mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir"
                            required value="{{ $user->tempat_lahir }}">
                    </div>
                    <div class="mb-3">
                        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tgl_lahir"
                            id="tgl_lahir" required value="{{ $user->tgl_lahir }}">
                    </div>

                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                            <option value="">Pilih...</option>
                            <option value="laki-laki" {{ (old('jenis_kelamin', $user->jenis_kelamin) == 'laki-laki') ? 'selected' : '' }}>Laki-Laki</option>
                            <option value="perempuan" {{ (old('jenis_kelamin', $user->jenis_kelamin) == 'perempuan') ? 'selected' : '' }}>Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_induk" class="form-label">NIK</label>
                        <input type="text" class="form-control" name="nomor_induk" id="nomor_induk"
                            required value="{{ $user->nomor_induk }}">
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" name="alamat" id="alamat"
                            required value="{{ $user->alamat }}">
                    </div>
                    <div class="mb-3">
                        <label for="alamat_kota" class="form-label">Kota</label>
                        <input type="text" class="form-control" name="alamat_kota" id="alamat_kota"
                            required value="{{ $user->alamat_kota }}">
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" id="email"
                            required value="{{ $user->email }}">
                    </div>
                    <div class="mb-3">
                        <label for="no_telp" class="form-label">No. HP</label>
                        <input type="text" class="form-control" name="no_telp" id="no_telp"
                            required value="{{ $user->no_telp }}">
                    </div>
                    <div class="mb-3">
                        <input class="form-control" name="foto" type="file" id="formFile" accept=".png">
                    </div>
                    <div class="form-check form-switch mb-3">
                        <label for="status" class="me-3">Status</label>
                        <input class="form-check-input" type="checkbox" role="switch" id="status"
                            name="status" value="Aktif" {{ $user->status == 'Aktif' ? 'checked' : '' }}>
                    </div>
                </div>

                <div class="col">
                    <h5 class="text-center text-primary mb-4 fw-bold rounded">- Data Pendidikan Terakhir -</h5>
                    
                    <div class="mb-3">
                        <label for="nama_sekolah" class="form-label">Nama Sekolah/Universitas</label>
                        <input type="text" class="form-control" name="nama_sekolah" id="nama_sekolah"
                            required value="{{ $user->nama_sekolah }}">
                    </div>
                    <div class="mb-3">
                        <label for="jurusan" class="form-label">Jurusan</label>
                        <input type="text" class="form-control" name="jurusan" id="jurusan"
                            required value="{{ $user->jurusan }}">
                    </div>
                    <div class="mb-3">
                        <label for="jenjang" class="form-label">Jenjang</label>
                        <input type="text" class="form-control" name="jenjang" id="jenjang"
                            required value="{{ $user->jenjang }}">
                    </div>
                    <div class="mb-3">
                        <label for="tahun_lulus" class="form-label">Tahun Lulus</label>
                        <input type="text" class="form-control" name="tahun_lulus" id="tahun_lulus"
                            required value="{{ $user->tahun_lulus }}">
                    </div>
                    
                    <h5 class="text-center text-primary mt-4 fw-bold rounded">- Data Pekerjaan Sekarang -</h5>
                    
                    <div class="mb-3">
                        <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                        <input type="text" class="form-control" name="nama_perusahaan" id="nama_perusahaan"
                            required value="{{ $user->nama_perusahaan }}">
                    </div>
                    <div class="mb-3">
                        <label for="alamat_perusahaan" class="form-label">Alamat</label>
                        <input type="text" class="form-control" name="alamat_perusahaan" id="alamat_perusahaan"
                            required value="{{ $user->alamat_perusahaan }}">
                    </div>
                    <div class="mb-3">
                        <label for="alamat_kota_perusahaan" class="form-label">Kota</label>
                        <input type="text" class="form-control" name="alamat_kota_perusahaan" id="alamat_kota_perusahaan"
                            required value="{{ $user->alamat_kota_perusahaan }}">
                    </div>
                    <div class="mb-3">
                        <label for="jabatan_pekerjaan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan_pekerjaan" id="jabatan_pekerjaan"
                            required value="{{ $user->jabatan_pekerjaan }}">
                    </div>
                    <div class="mb-3">
                        <label for="no_telp_perusahaan" class="form-label">Telepon</label>
                        <input type="text" class="form-control" name="no_telp_perusahaan" id="no_telp_perusahaan"
                            required value="{{ $user->no_telp_perusahaan }}">
                    </div>
                </div>
                <div class="d-grid">
                    <button type="submit" class="btn btn-primary rounded">Simpan</button>
                </div>
            </div>
        </div>
    </form>
</div>

@endsection

@push('script')
    <script>
        document.querySelector('button[data-bs-toggle="modal"][data-bs-target="#add"]').style.display = 'none';
    </script>
@endpush

