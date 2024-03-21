@extends('layouts.panel.index')
@section('title', 'Pengguna')
@section('content')

<div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
    <div class="container">
        <div class="row">
          <div class="col">
            <h5 class="text-center text-primary mb-4 rounded fw-bold">- Data Diri -</h5>
            <div class="mb-3">
                <label for="username" class="form-label">Nama Lengkap</label>
                <input type="text" class="form-control" name="username" id="username"
                    required>
            </div>
            <div class="mb-3">
                <label for="email" class="form-label">Tempat Lahir</label>
                <input type="text" class="form-control" name="email" id="email"
                    required>
            </div>
            <div class="mb-3">
                <label for="tanggal_lahir" class="form-label">Tanggal Lahir</label>
                <input type="date" class="form-control" name="tanggal_lahir"
                    id="tanggal_lahir" placeholder="DD/MM/YYYY" required>
            </div>
            <div class="mb-3">
                <label for="gender" class="form-label">Jenis Kelamin</label>
                <select class="form-select mb-3" aria-label="form-select example">
                    <option selected>Laki-laki</option>
                    <option value="1">Perempuan</option>
                  </select>
            </div>
            <div class="mb-3">
                <label for="nik" class="form-label">Nomor KTP</label>
                <input type="text" class="form-control" name="nik" id="nik"
                    required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Alamat</label>
                <input type="text" class="form-control" name="username" id="username"
                    required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Email</label>
                <input type="text" class="form-control" name="username" id="username"
                    required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">No. HP</label>
                <input type="text" class="form-control" name="username" id="username"
                    required>
            </div>
          </div>
          <div class="col">
            <h5 class="text-center text-primary mb-4 fw-bold rounded">- Data Pendidikan Terakhir -</h5>
            <div class="mb-3">
                <label for="username" class="form-label">Nama Sekolah/Universitas</label>
                <input type="text" class="form-control" name="username" id="username"
                    required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Jurusan</label>
                <input type="text" class="form-control" name="username" id="username"
                    required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Jenjang</label>
                <input type="text" class="form-control" name="username" id="username"
                    required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Tahun Lulus</label>
                <input type="text" class="form-control" name="username" id="username"
                    required>
            </div>
            <h5 class="text-center text-primary mt-4 fw-bold rounded">- Data Pekerjaan Sekarang -</h5>
            <div class="mb-3">
                <label for="username" class="form-label">Nama Perusahaan</label>
                <input type="text" class="form-control" name="username" id="username"
                    required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Alamat</label>
                <input type="text" class="form-control" name="username" id="username"
                    required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Jabatan</label>
                <input type="text" class="form-control" name="username" id="username"
                    required>
            </div>
            <div class="mb-3">
                <label for="username" class="form-label">Telepon</label>
                <input type="text" class="form-control" name="username" id="username"
                    required>
            </div>
          </div>
          <div class="d-grid">
            <button class="btn btn-primary rounded">Simpan</button>
          </div>
        </div>
      </div>
</div>

@endsection

@push('script')
    <script>
        var button = document.getElementById('add')

        button.style.display = 'none';
    </script>
@endpush

