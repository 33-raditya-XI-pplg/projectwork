@extends('layouts.panel.index')
@section('title', 'Pengguna')
@section('content')
<style>
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
</style>

    <div class="d-flex justify-content-between mb-3">
        <nav aria-label="breadcrumb">

        </nav>
        <div>
            <button type="button" class="btn btn-success rounded text-white" data-bs-toggle="modal" data-bs-target="#excel">
                Impor <i class="fa-solid fa-download"></i>
            </button>
            <a class="btn btn-primary rounded" href="{{ route('user.create') }}">Tambah <i class="fa-solid fa-user-plus"></i></a>
        </div>
    </div>


    <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg ">
        <table id="example" class="table">
            <thead class="fw-normal">
                <th>No</th>
                <th scope="col">Nama Lengkap</th>
                <th scope="col">Email</th>
                <th scope="col">NIK</th>
                <th scope="col">Jenis Kelamin</th>
                <th scope="col">Status</th>
                <th scope="col">Aksi</th>
            </thead>
            <tbody class="" style="vertical-align: middle">
                @foreach ($pengguna as $row)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                        <td>{{ $row->nama_lengkap }}</td>
                        <td>{{ $row->email }}</td>
                        <td>{{ $row->nomor_induk ?? '-' }}</td>
                        <td>{{ $row->jenis_kelamin ?? '-' }}</td>
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
                                    <li><a class="dropdown-item text-info" href="{{ route('user.edit', $row->id_user) }}"
                                            data-bs-target="#edit{{ $row->id_user }}"><i
                                                class="fa-regular fa-pen-to-square"></i> Edit</a>
                                    </li>
                                    <li><a href="{{ route('user.destroy', $row->id_user) }}"
                                            class="dropdown-item text-danger" data-confirm-delete="true"><i
                                                class="fa-regular fa-trash-can pe-none"></i>
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

    <!-- Modal import-->
    <div class="modal fade" id="excel" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1"
        aria-labelledby="staticBackdropLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="staticBackdropLabel">Masukkan Data Peserta</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.import') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="mb-3">
                            <input class="form-control form-control-sm" name="data-peserta" type="file" accept=".xlsx">
                        </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Impor</button>
                </div>
                </form>
            </div>
        </div>
    </div>

    {{-- Rincian --}}
    @foreach ($pengguna as $row)
    <div class="modal modal-lg fade" id="rincian{{ $row->id_user }}">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-primary-gradient text-white">
                    <h5 class="modal-title" id="exampleModalLabel">Rincian Pengguna</h5>
                    <button type="button" class="btn-kembali rounded-3" data-bs-dismiss="modal">Kembali</button> 
                </div>
                 <div class="modal-body">                
                    <div class="container">
                        <div class="row">
                            <div class="col">
                                <h5 class="text-center">--Data Diri--</h5>
                                    <div class="mb-3 mt-4">
                                        <label for="nama_lengkap" class="form-label">Nama Pengguna</label>
                                        <input type="text" class="form-control" name="nama_lengkap"
                                            id="nama_lengkap" value="{{ $row->nama_lengkap ?? '   -   ' }}" disabled readonly >
                                    </div>
                                    <div class="mb-3">
                                        <label for="tempat_lahir" class="form-label">Tempat Lahir</label>
                                        <input type="text" class="form-control" name="tempat_lahir" id="tempat_lahir" value="{{$row->tempat_lahir ?? '   -   ' }}" disabled readonly>                                         
                                    </div>
                                    <div class="mb-3">
                                        <label for="tgl_lahir" class="form-label">Tanggal Lahir</label>
                                        <input type="text" class="form-control" name="tgl_lahir" id="tgl_lahir" value="{{ $row->tgl_lahir ?? '   -   ' }}" disabled readonly>
                                    </div>                                                                
                                    <div class="mb-3">
                                        <label for="jenis_kelamin" class="form-label">Jenis-Kelamin</label>    
                                        <input type="text" class="form-control" name="jenis_kelamin" id="jenis_kelamin" value="{{ $row->jenis_kelamin ?? '   -   ' }}" disabled readonly>
                                    </div>  
                                    <div class="mb-3">
                                        <label for="nomor_induk" class="form-label">NIK</label>
                                        <input type="number" class="form-control" name="nomor_induk" id="nomor_induk" value="{{ $row->nomor_induk  ?? '   -   ' }}" disabled readonly >
                                    </div>  
                                    <div class="mb-3">
                                        <label for="alamat" class="form-label">Alamat</label>
                                        <textarea class="form-control" id="alamat" name="alamat" rows="2"  disabled readonly >{{ $row->alamat ?? '   -   ' }}</textarea>
                                    </div>   
                                    <div class="mb-3">
                                        <label for="alamat_kota" class="form-label">Kota</label>    
                                        <input type="text" class="form-control" name="alamat_kota" id="alamat_kota" value="{{ $row->alamat_kota ?? '   -   ' }}" disabled readonly>
                                    </div>                           
                                    <div class="mb-3">
                                        <label for="email" class="form-label">Email</label>    
                                        <input type="text" class="form-control" name="email" id="email" value="{{ $row->email ?? '   -   ' }}" disabled readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="no" class="form-label">No. telp</label>
                                        <input type="text" class="form-control" name="no_telp" id="no_telp" value="{{ $row->no_telp ?? '   -   ' }}"disabled readonly >
                                    </div>                             
                            </div>
                            <div class="col">
                                <h5 class="text-center">--Data Pendidikan Terakhir--</h5>                                
                                <div class="mb-3 mt-4">
                                    <label for="nama_sekolah" class="form-label">Nama Sekolah/Instansi</label>
                                    <input type="text" class="form-control" name="nama_sekolah" id="nama_sekolah" value="{{ $row->nama_sekolah ?? '   -   ' }}" disabled readonly >
                                </div>
                                <div class="mb-3">
                                    <label for="jurusan" class="form-label">Jurusan</label>
                                    <input type="text" class="form-control" name="jurusan" id="jurusan" value="{{ $row->jurusan ?? '   -   ' }}" disabled readonly >
                                </div>
                                <div class="mb-3">
                                    <label for="jenjang" class="form-label">Jenjang</label>
                                    <input type="text" class="form-control" name="jenjang" id="jenjang" value="{{ $row->jenjang ?? '   -   ' }}" disabled readonly>                               
                                </div>
                                <div class="mb-4">
                                    <label for="tahun_lulus" class="form-label">Tahun Lulus</label>
                                    <input type="email" class="form-control" name="tahun_lulus" id="tahun_lulus" value="{{ $row->tahun_lulus ?? '   -   ' }}" disabled readonly>
                                </div>
                                @if(!empty($row->nama_perusahaan)|| !empty($row->alamat_perusahaan) || !empty($row->alamat_kota_perusahaan) || !empty($row->jabatan_pekerjaan) || !empty($row->no_telp_perusahaan))
                                <div class="data-pekerjaan">
                                <h5 class="text-center">--Data Pekerjaan Sekarang--</h5>
                                <div class="mb-3 mt-2 ">
                                    <label for="nama_perusahaan" class="form-label">Nama Perusahaan</label>
                                    <input type="text" class="form-control" name="nama_perusahaan" id="nama_perusahaan" value="{{ $row->nama_perusahaan ?? '   -   ' }}" disabled readonly>
                                </div>                       
                                <div class="mb-3 ">
                                    <label for="alamat_perusahaan" class="form-label">Alamat</label>
                                    <input type="text" class="form-control" name="alamat_perusahaan" id="alamat_perusahaan" value="{{ $row->alamat_perusahaan ?? '   -   ' }}" disabled readonly>
                                </div>                        
                                <div class="mb-3">
                                    <label for="alamat_kota_perusahaan" class="form-label">Kota</label>
                                    <input type="text" class="form-control" name="alamat_kota_perusahaan" id="alamat_kota_perusahaan" value="{{ $row->alamat_kota_perusahaan ?? '   -   ' }}" disabled readonly>
                                </div>                            
                                <div class="mb-3">
                                    <label for="jabatan_pekerjaan" class="form-label">Jabatan</label>
                                    <input type="text" class="form-control" name="jabatan_pekerjaan" id="jabatan_pekerjaan" value="{{ $row->jabatan_pekerjaan ?? '   -   ' }} " disabled readonly>
                                </div>                            
                                <div class="mb-3">
                                    <label for="no_telp_perusahaan" class="form-label">Telepon Perusahaan</label>                                    
                                    <input type="text" class="form-control" name="no_telp_perusahaan" id="no_telp_perusahaan" value="{{ $row->no_telp_perusahaan ?? '   -   ' }}" disabled readonly>
                                </div>   
                                </div>                     
                                @endif
                            </div>
                            <div class="form-group mb-3">
                                <label class="control-label mb-2"> Foto Pengguji <span class="text-danger">*</span></label>
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

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    {{-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> --}}
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
        url: '{{ route('user.updateStatus', ':id') }}'.replace(':id', userId),
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

    </script>
    
        

@endsection








{{-- @push('script')
    <script>
        var add = document.getElementById('add');
        add.style.display = '';

        add.addEventListener('click', function(event) {

            event.preventDefault();
            window.location.href = "{{ route('user.create') }}";
        })
    </script>
@endpush --}}
