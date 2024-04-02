@extends('layouts.panel.index')
@section('title', 'Edit Profile')

@section('content')
<div class="card">
    <div class="card-header bg-primary text-white">
        <h4 class="mt-2">Edit Profile</h4>
    </div>
    <div class="card-body">
        <form action="{{ route('profile.update', $user->id_user) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3 row">
                <label for="email" class="col-sm-2 col-form-label">Email</label>
                <div class="col-sm-10">
                    <input type="text" readonly class="form-control-plaintext" id="email" value="{{ $user->email }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="password" class="col-sm-2 col-form-label">Password</label>
                <div class="col-sm-10">
                    <button type="button" class="btn btn-sm btn-primary rounded" data-bs-toggle="modal" data-bs-target="#exampleModal">
                    Ubah Password
                    </button>
                </div>
            </div>
            <hr>

            <br><h4>Detail Akun</h4>
            <div class="mb-3 row">
                <label for="nama_lengkap" class="col-sm-2 col-form-label">Nama Lengkap</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nama_lengkap" name="nama_lengkap" value="{{ $user->nama_lengkap }}">
                </div>
            </div>
            @if (Auth::user()->isLevel('Penguji'))
                <div class="mb-3 row">
                    <label for="instansi" class="col-sm-2 col-form-label">Asal Instansi</label>
                    <div class="col-sm-10">
                        <select class="form-select" aria-label="Default select example" id="instansi" name="instansi">
                            <option selected disabled>Pilih...</option>
                                @foreach($instansi as $row)
                                <option value="{{ $row->id_instansi }}" {{ $user->instansi_id == $row->id_instansi ? 'selected' : '' }}>
                                    {{ $row->nama_instansi }}
                                    </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            @endif

            @if (Auth::user()->isLevel('Pengguna'))
                <div class="mb-3 row">
                    <label for="tgl_lahir" class="col-sm-2 col-form-label">Tanggal</label>
                    <div class="col-sm-10">
                        <input type="date" class="form-control" id="tgl_lahir" name="tgl_lahir" value="{{ $user->tgl_lahir }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="tempat_lahir" class="col-sm-2 col-form-label">Tempat Lahir</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="tempat_lahir" name="tempat_lahir" value="{{ $user->tempat_lahir }}">
                    </div>
                </div>
                <div class="mb-3 row">
                    <label for="pekerjaan" class="col-sm-2 col-form-label">Pekerjaan</label>
                    <div class="col-sm-10">
                        <input type="text" class="form-control" id="pekerjaan" name="pekerjaan" value="{{ $user->pekerjaan }}">
                    </div>
                </div>
            @endif
            
            <div class="mb-3 row">
                <label for="nomor_induk" class="col-sm-2 col-form-label">Nomor Induk</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nomor_induk" name="nomor_induk" value="{{ $user->nomor_induk }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="alamat" class="col-sm-2 col-form-label">Alamat</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $user->alamat }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="alamat_kota" class="col-sm-2 col-form-label">Pilih Kota</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $user->alamat_kota }}">
                </div>
                <!-- <div class="col-sm-10">
                    <select class="form-select" aria-label="Default select example" id="alamat_kota" name="alamat_kota">
                        <option selected>Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div> -->
            </div>
            <div class="mb-3 row">
                <label for="jenis_kelamin" class="col-sm-2 col-form-label">Jenis Kelamin</label>
                <div class="col-sm-10">
                    <select class="form-select" aria-label="Default select example" id="jenis_kelamin" name="jenis_kelamin">
                        <option selected disabled>Open this select menu</option>
                        <option value="laki-laki" {{ $user->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>Laki-Laki</option>
                        <option value="perempuan" {{ $user->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                    </select>
                </div>
            </div>
            <div class="mb-3 row">
                <label for="no_telp" class="col-sm-2 col-form-label">Nomor Telpon</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="no_telp" name="no_telp" value="{{ $user->no_telp }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="foto_pengguna" class="col-sm-2 col-form-label">Foto Pengguna</label>
                <div class="col-sm-10">
                    <input class="form-control" name="photo" type="file" id="formFile" accept=".png">
                </div>
            </div>
            <hr>
            
            @if (Auth::user()->isLevel('Pengguna'))
            <br><h4>Pendidikan Terakhir</h4>
            <div class="mb-3 row">
                <label for="nama_sekolah" class="col-sm-2 col-form-label">Nama Sekolah</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nama_sekolah" name="nama_sekolah" value="{{ $user->nama_sekolah }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="jurusan" class="col-sm-2 col-form-label">Jurusan</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="jurusan" name="jurusan" value="{{ $user->jurusan }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="jenjang" class="col-sm-2 col-form-label">Jenjang</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="jenjang" name="jenjang" value="{{ $user->jenjang }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="tahun_lulus" class="col-sm-2 col-form-label">Tahun Lulus</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="tahun_lulus" name="tahun_lulus" value="{{ $user->tahun_lulus }}">
                </div>
            </div>
            <hr>

            <br><h4>Pekerjaan (Opsional)</h4>
            <div class="mb-3 row">
                <label for="nama_perusahaan" class="col-sm-2 col-form-label">Nama Perusahaan</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="nama_perusahaan" name="nama_perusahaan" value="{{ $user->nama_perusahaan }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="alamat_perusahaan" class="col-sm-2 col-form-label">Alamat Perusahaan</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="alamat_perusahaan" name="alamat_perusahaan" value="{{ $user->alamat_perusahaan }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="alamat_kota_perusahaan" class="col-sm-2 col-form-label">Pilih Kota</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="alamat" name="alamat" value="{{ $user->alamat_kota_perusahaan }}">
                </div>
                <!-- <div class="col-sm-10">
                    <select class="form-select" aria-label="Default select example" id="alamat_kota_perusahaan" name="alamat_kota_perusahaan">
                        <option selected>Open this select menu</option>
                        <option value="1">One</option>
                        <option value="2">Two</option>
                        <option value="3">Three</option>
                    </select>
                </div> -->
            </div>
            <div class="mb-3 row">
                <label for="jabatan_pekerjaan" class="col-sm-2 col-form-label">Jabatan Pekerjaan</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="jabatan_pekerjaan" name="jabatan_pekerjaan" value="{{ $user->jabatan_pekerjaan }}">
                </div>
            </div>
            <hr>
            @endif

            @if(Auth::user()->isLevel('Penguji'))
            <br><h4>Data Penguji</h4>
            <div class="mb-3 row">
                <label for="jabatan_penguji" class="col-sm-2 col-form-label">Jabatan Penguji</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="jabatan_penguji" name="jabatan_penguji" value="{{ $user->jabatan_penguji }}">
                </div>
            </div>
            <div class="mb-3 row">
                <label for="type_penguji" class="col-sm-2 col-form-label">Tipe Penguji</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" id="type_penguji" name="type_penguji" value="{{ $user->type_penguji }}">
                </div>
            </div>          
            @endif

            <div class="d-flex justify-content-end mb-2">
                <button type="submit" class="btn btn-success rounded text-white">Simpan</button>
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
