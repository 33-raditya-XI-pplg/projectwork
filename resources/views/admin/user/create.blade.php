@extends('layouts.panel.index')
@section('title', 'Pengguna')
@section('content')

<div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
    <form action="{{ route('user.store') }}" method="POST" enctype="multipart/form-data">
        @csrf        
        <div class="container">
            <div class="row">
                <div class="col">
                    <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">
                    <input type="hidden" name="password" value="Pengguna">
                    <input type="hidden" name="level" value="Pengguna">

                    <h5 class="text-center text-primary mb-4 rounded fw-bold">- Data Diri -</h5>

                    <div class="mb-3">
                        <label for="nama_lengkap" class="form-label">Nama Lengkap</label>
                        <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tgl_lahir"
                            id="tgl_lahir" placeholder="DD/MM/YYYY" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                            <option selected disabled>Pilih...</option>
                            <option value="laki-laki">Laki-Laki</option>
                            <option value="perempuan">Perempuan</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_induk" class="form-label">NIK</label>
                        <input type="text" class="form-control" name="nomor_induk" id="nomor_induk"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" class="form-control" name="alamat" id="alamat"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat_kota" class="form-label">Kota</label>
                        <input type="text" class="form-control" name="alamat_kota" id="alamat_kota"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" id="email"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="no_telp" class="form-label">No. HP</label>
                        <input type="text" class="form-control" name="no_telp" id="no_telp"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="foto_pengguna">Foto Pengguna</label>
                        <input class="form-control" name="foto" type="file" id="formFile" accept=".png" required>
                    </div>
                    <div class="form-check form-switch mb-3">
                        <label for="status" class="me-3">Status</label>
                        <input class="form-check-input" type="checkbox" role="switch" id="status"
                            name="status" value="Aktif">
                    </div>
                </div>

                <div class="col">
                    <h5 class="text-center text-primary mb-4 fw-bold rounded">- Data Pendidikan Terakhir -</h5>
                    
                    <div class="mb-3">
                        <label for="nama_sekolah" class="form-label">Nama Sekolah/Universitas</label>
                        <input type="text" class="form-control" name="nama_sekolah" id="nama_sekolah"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="jurusan" class="form-label">Jurusan</label>
                        <input type="text" class="form-control" name="jurusan" id="jurusan"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="jenjang" class="form-label">Jenjang</label>
                        <input type="text" class="form-control" name="jenjang" id="jenjang"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="tahun_lulus" class="form-label">Tahun Lulus</label>
                        <input type="text" class="form-control" name="tahun_lulus" id="tahun_lulus"
                            required>
                    </div>
                    
                    <h5 class="text-center text-primary mt-4 fw-bold rounded">- Data Pekerjaan Sekarang -</h5>
                    
                    <div class="mb-3">
                        <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                        <input type="text" class="form-control" name="nama_perusahaan" id="nama_perusahaan"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat_perusahaan" class="form-label">Alamat</label>
                        <input type="text" class="form-control" name="alamat_perusahaan" id="alamat_perusahaan"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat_kota_perusahaan" class="form-label">Kota</label>
                        <input type="text" class="form-control" name="alamat_kota_perusahaan" id="alamat_kota_perusahaan"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="jabatan_pekerjaan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan_pekerjaan" id="jabatan_pekerjaan"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="no_telp_perusahaan" class="form-label">Telepon</label>
                        <input type="text" class="form-control" name="no_telp_perusahaan" id="no_telp_perusahaan"
                            required>
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
        var button = document.getElementById('add')

        button.style.display = 'none';
    </script>
@endpush

