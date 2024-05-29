@extends('layouts.panel.index')
@section('title', 'Rincian Event')

@push('style')
    <style>
        h5 {
            font-weight: 300;
        }
        #img-rincian{
            width: 400px;
            height: 300px;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="card mb-5">
                <div class="card-body">
                    <h4 class="card-title">Rincian Event</h4>
                    <img id="img-rincian" src="{{ $banner }}" class="img-fluid mx-auto d-block" alt="Banner Event">
                    <hr>
                    <br>
                    <p class="mt-2 mb-4">{{ $data_event->deskripsi }}</p>
                    <div class="row">
                        <div class="mb-4 col-6">
                            <h6 class="fs-5 ls-2">Event</h6>
                            <p class="mb-0">{{ $data_event->nama_event }}</p>
                        </div>
                        <div class="mb-4 col-6">
                            <h6 class="fs-5 ls-2">TUK</h6>
                            <p class="mb-0">{{ $data_event->nama_tempat }}</p>
                        </div>
                        <div class="col-6">
                            <h6 class="fs-5 ls-2">Tanggal Mulai</h6>
                            <p class="mb-0">{{ $data_event->tgl_mulai }}</p>
                        </div>
                        <div class="col-6">
                            <h6 class="fs-5 ls-2">Tanggal Berakhir</h6>
                            <p class="mb-0">{{ $data_event->tgl_berakhir }}</p>
                        </div>
                    </div>
                    <div class="back mt-4 mb-3">
                        <a href="{{ route('event-user.index') }}" class="btn btn-primary rounded">Kembali</a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Daftar Skema</h4>
                    <table id="example" class="table">
                        <thead class="fw-normal">
                            <th scope="col" width="5%">No</th>
                            <th scope="col" width="20%">Skema</th>
                            <th scope="col" width="15%">Status</th>
                            <th scope="col" width="8%" class="text-center">Aksi</th>
                        </thead>

                        <tbody class="table-responsive" style="vertical-align: middle">
                            @php $num = 1 @endphp
                            @foreach ($data_skema as $row)
                                <tr>
                                    <td>{{ $num++ }}</td>
                                    <td>{{ $row->nama_skema }}</td>
                                    <td><button type="button" class="btn rounded-3 {{ $row->telah_terdaftar == 1 ? 'btn-outline-success' : 'btn-outline-danger' }}" disabled>
                                        {{ $row->telah_terdaftar == 1 ? 'Sudah Terdaftar' : 'Dapat Mendaftar' }}</button>
                                    </td>

                                    @if ($row->telah_terdaftar == 1)
                                        <td class="text-center">
                                            <a href="{{ route('event.rincian-skema', $row->id_event_skema) }}" class="btn btn-secondary btn-sm rounded">
                                                    <i class="fa fa-info"></i> Rincian</a>
                                        </td>
                                    @else
                                        <td class="text-center"> 
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-solid fa-bars"></i>
                                                </a>

                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a href="#" class="dropdown-item text-success" id="registerButton">
                                                            <i class="fa-regular fa-pen-to-square"></i> Daftar</a>
                                                            <form id="mendaftarForm" action="{{ route('mendaftar.event') }}" method="POST">
                                                                @csrf
                                                                <input type="hidden" name="event_skema_id" required value="{{ $row->id_event_skema }}">
                                                            </form>
                                                    </li>
                                                    <li><a href="{{ route('event.rincian-skema', $row->id_event_skema) }}" class="dropdown-item text-danger">
                                                            <i class="fa fa-info"></i> Rincian</a>
                                                    </li>
                                                </ul>
                                            </div>                                               
                                        </td>
                                    @endif
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>

        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var button = document.getElementById('tambahBtn');
            button.style.display = 'none';
        });
        
        document.getElementById('registerButton').addEventListener('click', function () {
            Swal.fire({
                title: 'Apakah Anda yakin?',
                text: "Anda akan mendaftar untuk event ini!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Daftar'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('mendaftarForm').submit();
                }
            })
        });

    </script>
@endpush