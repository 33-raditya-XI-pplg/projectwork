@extends('layouts.panel.index')
@section('title', 'Pengguna')
@section('content')

<div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
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
                        <input type="text" class="form-control" name="nama_lengkap" id="nama_lengkap" value="{{ isset($pengguna) ? $pengguna->nama_lengkap : '' }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                        <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" value="{{ isset($pengguna) ? $pengguna->tempat_lahir : '' }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                        <input type="date" class="form-control" name="tgl_lahir"
                            id="tgl_lahir" placeholder="DD/MM/YYYY" value="{{ isset($pengguna) ? $pengguna->tgl_lahir : '' }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="jenis_kelamin" class="form-label">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-select">
                            <option selected disabled>Pilih...</option>
                            @if (isset($pengguna))
                                <option value="laki-laki" {{ $pengguna->jenis_kelamin == 'laki-laki' ? 'selected' : '' }}>Laki-Laki</option>
                                <option value="perempuan" {{ $pengguna->jenis_kelamin == 'perempuan' ? 'selected' : '' }}>Perempuan</option>
                            @elseif (!isset($pengguna))
                                <option value="laki-laki">Laki-Laki</option>
                                <option value="perempuan">Perempuan</option>
                            @endif
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="nomor_induk" class="form-label">NIK</label>
                        <input type="text" class="form-control" name="nomor_induk" id="nomor_induk" value="{{ isset($pengguna) ? $pengguna->nomor_induk : '' }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat" name="alamat" rows="2" required>{{ isset($pengguna) ? $pengguna->alamat : '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="alamat_kota" class="form-label">Kota</label>
                        <textarea class="form-control" id="alamat_kota" name="alamat_kota" rows="2" required>{{ isset($pengguna) ? $pengguna->alamat_kota : '' }}</textarea>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="text" class="form-control" name="email" id="email" value="{{ isset($pengguna) ? $pengguna->email : '' }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="no_telp" class="form-label">No. HP</label>
                        <input type="text" class="form-control" name="no_telp" id="no_telp" value="{{ isset($pengguna) ? $pengguna->no_telp : '' }}"
                            required>
                    </div>
                    <div class="mb-3">
                        <label for="foto_pengguna" class="mb-2">Foto Pengguna</label>
                        <input class="form-control" name="foto" type="file" id="formFile" accept=".png" {{ isset($pengguna->path_foto) ? '' : 'required' }}>
                    </div>

                </div>

                <div class="col">
                    <h5 class="text-center text-primary mb-4 fw-bold rounded">- Data Pendidikan Terakhir -</h5>
                    
                    <div class="mt-3">
                        <label for="nama_sekolah" class="form-label">Nama Sekolah/Universitas</label>
                        <input type="text" class="form-control" name="nama_sekolah" id="nama_sekolah"
                            required value="{{ isset($pengguna) ? $pengguna->nama_sekolah : '' }}">
                    </div>
                    <div class="mt-3">
                        <label for="jurusan" class="form-label">Jurusan</label>
                        <input type="text" class="form-control" name="jurusan" id="jurusan"
                            required value="{{ isset($pengguna) ? $pengguna->jurusan : '' }}">
                    </div>
                    <div class="mt-3">
                        <label for="jenjang" class="form-label">Jenjang</label>
                        <input type="text" class="form-control" name="jenjang" id="jenjang"
                            required value="{{ isset($pengguna) ? $pengguna->jenjang : '' }}">
                    </div>
                    <div class="mt-3">
                        <label for="tahun_lulus" class="form-label">Tahun Lulus</label>
                        <input type="text" class="form-control" name="tahun_lulus" id="tahun_lulus"
                            required value="{{ isset($pengguna) ? $pengguna->tahun_lulus : '' }}">
                    </div>
                    <h5 class="text-center text-primary mt-5 fw-bold rounded" style="margin-bottom: 28px;">- Data Pekerjaan Sekarang -</h5>
                    
                    <div class="mt-3">
                        <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                        <input type="text" class="form-control" name="nama_perusahaan" id="nama_perusahaan"
                            required value="{{ isset($pengguna) ? $pengguna->nama_perusahaan : '' }}">
                    </div>
                    <div class="mt-3">
                        <label for="alamat_perusahaan" class="form-label">Alamat</label>
                        <textarea class="form-control" id="alamat_perusahaan" name="alamat_perusahaan" rows="2" required>{{ isset($pengguna) ? $pengguna->alamat_perusahaan : '' }}</textarea>
                    </div>
                    <div class="mt-3">
                        <label for="alamat_kota_perusahaan" class="form-label">Kota</label>
                        <textarea class="form-control" id="alamat_kota_perusahaan" name="alamat_kota_perusahaan" rows="2" required>{{ isset($pengguna) ? $pengguna->alamat_kota_perusahaan : '' }}</textarea>
                    </div>
                    <div class="mt-3">
                        <label for="jabatan_pekerjaan" class="form-label">Jabatan</label>
                        <input type="text" class="form-control" name="jabatan_pekerjaan" id="jabatan_pekerjaan"
                            required value="{{ isset($pengguna) ? $pengguna->jabatan_pekerjaan : '' }}">
                    </div>
                    <div class="mt-3">
                        <label for="no_telp_perusahaan" class="form-label">Telepon</label>
                        <input type="text" class="form-control" name="no_telp_perusahaan" id="no_telp_perusahaan"
                            required value="{{ isset($pengguna) ? $pengguna->no_telp_perusahaan : '' }}">
                    </div>

                    <div class="modal-footer justify-content-between mt-3">
                        <div class="form-check form-switch mb-3">
                            {{-- <label for="status" class="me-3">Status</label>
                            @if (isset($pengguna))
                                <input class="form-check-input" type="checkbox" role="switch" id="status"
                                    name="status" value="Verified" {{ $pengguna->status == 'Verified' ? 'checked' : '' }}>
                            @elseif (!isset($pengguna))
                                <input class="form-check-input" type="checkbox" role="switch" id="status"
                                    name="status" value="Verified" {{ $user->status == 'Verified' ? 'checked' : '' }}>
                            @endif --}}
                        </div>
                        <div class="d-flex justify-content-end mb-2">
                            <button type="submit" class="btn btn-success rounded text-white">Simpan</button>
                        </div>	
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
        var button = document.getElementById('add')

        button.style.display = 'none';
    </script>
@endpush

