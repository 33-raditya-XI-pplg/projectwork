@extends('layouts.panel.index')
@section('title', 'Rincian Event')

@push('style')
    <style>
        h5 {
            font-weight: 300;
        }

        #img-rincian {
            width: 380px;
            height: 320px;
        }

        .dropdown-toggle i.fa-bars {
            font-size: 0.75rem;
        }

        .dropdown-menu .small-icon {
            font-size: 0.95rem;
            /* Ubah sesuai kebutuhan */
        }

        .custom-btn {
            font-size: 0.9rem;
            padding: 4px 4px;
        }

        .custom-btn i {
            font-size: 0.8rem;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="card mb-5">
                <div class="card-body">
                    <img id="img-rincian" src="{{ $banner }}" class="img-fluid mx-auto d-block" alt="Banner Event">
                    <hr>
                    <br>
                    <p class="mt-2 mb-4">{!! strip_tags($data_event->deskripsi) !!}</p>
                    <div class="row">
                        <div class="mb-4 col-6">
                            <h6 class="fs-5 ls-2">Event</h6>
                            <p class="mb-0">{{ $data_event->nama_event }}</p>
                        </div>
                        <div class="mb-4 col-6" style="position:relative; left:-50px;">
                            <h6 class="fs-5 ls-2">TUK</h6>
                            <p class="mb-3">{{ $data_event->nama_tempat }}</p>
                        </div>
                        <div class="col-12 d-flex flex-row justify-content-between align-items-center">
                            <div class="d-flex flex-column me-7">
                                <h6 class="fs-5 ls-2">Tanggal Mulai</h6>
                                <p class="mb-0">{{ $data_event->tgl_mulai }}</p>
                            </div>
                            <div class="d-flex flex-column me-4">
                                <h6 class="fs-5 ls-2">Tanggal Berakhir</h6>
                                <p class="mb-0">{{ $data_event->tgl_berakhir }}</p>
                            </div>
                            <div class="d-flex flex-column me-4">
                                <h6 class="fs-5 ls-2">harga Registrasi</h6>
                                <p class="mb-0">{{ $data_event->biaya_regis }}</p>
                            </div>
                        </div>
                    </div>
                    <div class="back mt-4 mb-3">
                        <a href="{{ route('event-user.index') }}" class="btn btn-primary rounded">Kembali</a>
                    </div>
                </div>
            </div>

            <h4 class="card-title mb-3">Daftar Skema</h4>
            <div class="card">
                <div class="card-body">
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
                                    <td><button type="button"
                                            class="btn rounded-3 {{ $row->telah_terdaftar == 1 ? 'btn-outline-success' : 'btn-outline-danger' }}"
                                            disabled>
                                            {{ $row->telah_terdaftar == 1 ? 'Sudah Terdaftar' : 'Dapat Mendaftar' }}</button>
                                    </td>

                                    @if ($row->telah_terdaftar == 1)
                                        <td class="text-center">
                                            <a href="{{ route('event.rincian-skema', $row->id_event_skema) }}"
                                                class="btn btn-secondary btn-sm rounded custom-btn">
                                                <i class="fa fa-info"></i> Rincian</a>
                                        </td>
                                    @else
                                       <td class="text-center">
    <div class="d-flex justify-content-center gap-2">
        <!-- Tombol Daftar -->
        <form id="mendaftarForm-{{ $row->id_event_skema }}" class="mendaftarForm"
            action="{{ route('mendaftar.event') }}" method="POST">
            @csrf
            <input type="hidden" name="event_skema_id" required value="{{ $row->id_event_skema }}">
            <button type="submit" class="btn btn-success btn-sm text-white d-flex align-items-center gap-1">
                <i class="fa-regular fa-pen-to-square small-icon" style="font-size: 0.75rem; color: white;"></i>
                <span class="text-white">Daftar</span>
            </button>
        </form>

        <!-- Tombol Rincian -->
        <a href="{{ route('event.rincian-skema', $row->id_event_skema) }}"
            class="btn btn-danger btn-sm text-white d-flex align-items-center gap-1">
            <i class="fa fa-info small-icon" style="font-size: 0.75rem; color: white;"></i>
            <span class="text-white">Rincian</span>
        </a>
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
            // Hide the button when the page loads
            var tambahBtn = document.getElementById('tambahBtn');
            if (tambahBtn) {
                tambahBtn.style.display = 'none';
            }

            // Handle all register buttons
            var registerButtons = document.querySelectorAll('.registerButton');
            registerButtons.forEach(function(button, index) {
                button.addEventListener('click', function(event) {
                    event.preventDefault(); // Prevent default action

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
                            // Get the correct form using the index
                            var forms = document.querySelectorAll('.mendaftarForm');
                            if (forms[index]) {
                                forms[index].submit();
                            }
                        }
                    });
                });
            });
        });
    </script>
@endpush
