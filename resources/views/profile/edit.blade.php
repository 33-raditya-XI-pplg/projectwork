@extends('layouts.panel.index')
@section('title', 'Edit Profile')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h4>Edit Profile</h4>
    </div>
    <div class="card-body">
        <form action="" method="post">
            <div class="mb-3 row">
                <label for="username" class="col-sm-2 col-form-label">Username</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="username" name="username">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="email" value="email@example.com">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="password" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="password" name="password">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="password" class="col-sm-2 col-form-label">Confirm Password</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="password" name="password">
                </div>
            </div>
            <hr>
            <h4>Detail Akun</h4>
            <br>
            <div class="mb-3 row">
                <label for="nama" class="col-sm-2 col-form-label">Nama Lengkap</label>
                <div class="col-sm-10">
                    <input type="password" class="form-control" id="nama" name="nama">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="instansi" class="col-sm-2 col-form-label">Asal Instansi</label>
                <div class="col-sm-10">
                    <select class="form-select" aria-label="Default select example" id="instansi" name="instansi">
                        <option selected>Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="tgl_lahir" class="col-sm-2 col-form-label">Tanggal</label>
                <div class="col-sm-10">
                    <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="tempat_lahir" class="col-sm-2 col-form-label">Tempat Lahir</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="nomor_induk" class="col-sm-2 col-form-label">Nomor Induk</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nomor_induk" name="nomor_induk">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="pekerjaan" class="col-sm-2 col-form-label">Pekerjaan</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="pekerjaan" name="pekerjaan">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="alamat" name="alamat">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="alamat_kota" class="col-sm-2 col-form-label">Pilih Kota</label>
                <div class="col-sm-10">
                    <select class="form-select" aria-label="Default select example" id="alamat_kota" name="alamat_kota">
                        <option selected>Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-10">
                    <select class="form-select" aria-label="Default select example" id="jenis_kelamin" name="jenis_kelamin">
                        <option selected>Open this select menu</option>
                        <option value="L">Laki-Laki</option>
                        <option value="P">Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="no_telp" class="col-sm-2 col-form-label">Nomor Telpon</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="no_telp" name="no_telp">
                </div>
            </div>
            <hr>
            <h4>Pendidikan Terakhir</h4>
            <br>
            <div class="mb-3 row">
                <label for="nama_sekolah" class="col-sm-2 col-form-label">Nama Sekolah/ Universitas</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="jurusan" class="col-sm-2 col-form-label">Jurusan</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="jurusan" name="jurusan">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="jenjang" class="col-sm-2 col-form-label">Jenjang</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="jenjang" name="jenjang">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="tahun_lulus" class="col-sm-2 col-form-label">Tahun Lulus</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="tahun_lulus" name="tahun_lulus">
                </div>
            </div>
            <hr>
            <h4>Pekerjaan (Opsional)</h4>
            <br>
            <div class="mb-3 row">
                <label for="nama_perusahaan" class="col-sm-2 col-form-label">Nama Perusahaan</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="alamat_perusahaan" class="col-sm-2 col-form-label">Alamat Perusahaan</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="alamat_perusahaan" name="alamat_perusahaan">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="alamat_kota_perusahaan" class="col-sm-2 col-form-label">Pilih Kota</label>
                <div class="col-sm-10">
                    <select class="form-select" aria-label="Default select example" id="alamat_kota_perusahaan" name="alamat_kota_perusahaan">
                        <option selected>Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="jabatan_pekerjaan" class="col-sm-2 col-form-label">Jabatan Pekerjaan</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="jabatan_pekerjaan" name="jabatan_pekerjaan">
                </div>
            </div>
            <hr>
            <h4>Data Penguji</h4>
            <br>
            <div class="mb-3 row">
                <label for="jabatan_penguji" class="col-sm-2 col-form-label">Jabatan Penguji</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="jabatan_penguji" name="jabatan_penguji">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="type_penguji" class="col-sm-2 col-form-label">Tipe Penguji</label>
                <div class="col-sm-10">
                    <select class="form-select" aria-label="Default select example" id="type_penguji" name="type_penguji">
                        <option selected>Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection

@push('script')
    <script>
        var button = document.getElementById('add')

        button.style.display = 'none';
    </script>
@endpush
