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

        .action-buttons {
            display: flex;
            flex-wrap: wrap;
            gap: 5px;
            justify-content: center;
        }

        .action-buttons .btn {
            font-size: 0.75rem;
            padding: 3px 6px;
            min-width: 70px;
        }

        .action-buttons .btn i {
            font-size: 0.7rem;
        }
    </style>
@endpush

@section('content')
<iframe id="printFrame" style="display:none;" name="printFrame"></iframe>

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
                        <a href="{{ route('follow-event') }}" class="btn btn-primary rounded">Kembali</a>
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
                            <th scope="col" width="20%" class="text-center">Aksi</th>
                        </thead>

                        <tbody class="table-responsive" style="vertical-align: middle">
                            @php $num = 1 @endphp
                            @foreach ($data_skema as $row)
                                <tr>
                                    <td>{{ $num++ }}</td>
                                    <td>{{ $row->nama_skema }}</td>
                                    <td>
                                        <button type="button"
                                            class="btn rounded-3 {{ $row->telah_terdaftar == 1 ? 'btn-outline-success' : 'btn-outline-danger' }}"
                                            disabled>
                                            {{ $row->telah_terdaftar == 1 ? 'Sudah Terdaftar' : 'Dapat Mendaftar' }}
                                        </button>
                                    </td>
                                    @if ($row->telah_terdaftar == 1)
                                        <td class="text-center">
                                            <div class="d-flex flex-wrap justify-content-center gap-2">
                                                <!-- Tombol Rincian -->
                                                <a href="{{ route('event.rincian-skema', $row->id_event_skema) }}"
                                                class="btn btn-secondary btn-sm px-3 py-1 rounded d-flex align-items-center">
                                                    <i class="fa fa-info me-1" style="font-size: 0.9rem;"></i>
                                                    <span style="font-size: 0.8rem;">Rincian</span>
                                                </a>

                                                <!-- Tombol Sertifikat -->
                                                <button type="button"
                                                        class="btn btn-success btn-sm px-3 py-1 rounded text-white d-flex align-items-center print-certificate-btn"
                                                        onclick="printCertificate({{ $row->id_peserta }})"
                                                        data-peserta-id="{{ $row->id_peserta }}">
                                                    <i class="fa fa-certificate me-1" style="font-size: 0.9rem;"></i>
                                                    <span style="font-size: 0.8rem;">Sertifikat</span>
                                                </button>

                                                <!-- Tombol Penilaian -->
                                                <button type="button" class="btn btn-danger btn-sm penilaian_btn me-1 text-white rounded mb-1 "
                                                    data-id="{{ $row->id_event_skema }}"
                                                    data-peserta-id="{{ $row->id_peserta }}"
                                                    >
                                                  <i class="fa fa-star me-1" style="font-size: 1rem;"></i>
                                                    <span style="font-size: 0.8rem;">Penilaian</span>
                                                </button>

                                                <!-- Tombol Laporan Perkembangan -->
                                                <a href="{{ route('event.laporan-perkembangan', $row->id_event_skema) }}"
                                                class="btn btn-info btn-sm px-3 py-1 rounded d-flex align-items-center text-white">
                                                    <i class="fa fa-chart-line me-1" style="font-size: 0.9rem;"></i>
                                                    <span style="font-size: 0.8rem;">Laporan</span>
                                                </a>
                                            </div>
                                        </td>
                                    @else
                                        <td class="text-center">
                                            <div class="d-flex flex-wrap justify-content-center gap-2">
                                                <!-- Tombol Daftar -->
                                                <form id="mendaftarForm-{{ $row->id_event_skema }}" class="mendaftarForm"
                                                    action="{{ route('mendaftar.event') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="event_skema_id" required value="{{ $row->id_event_skema }}">
                                                    <button type="button"
                                                            class="btn btn-success btn-sm px-3 py-1 rounded text-white registerButton d-flex align-items-center">
                                                        <i class="fa-regular fa-pen-to-square me-1" style="font-size: 0.9rem;"></i>
                                                        <span style="font-size: 0.8rem;">Daftar</span>
                                                    </button>
                                                </form>

                                                <!-- Tombol Rincian -->
                                                <a href="{{ route('event.rincian-skema', $row->id_event_skema) }}"
                                                class="btn btn-secondary btn-sm px-3 py-1 rounded text-white d-flex align-items-center">
                                                    <i class="fa fa-info me-1" style="font-size: 0.9rem;"></i>
                                                    <span style="font-size: 0.8rem;">Rincian</span>
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

    <div class="modal fade" id="editNilaiModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Nilai Peserta</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <div class="modal-body">
                <input type="hidden" id="created_by" value="{{ Auth::user()->id_user }}">
                <div class="mb-3">
                    <label for="edit_nama_peserta" class="form-label">Nama Peserta</label>
                    <input type="text" class="form-control" id="edit_nama_peserta" disabled>
                </div>
                <div class="mb-3">
                    <label for="edit_nama_skema" class="form-label">Skema</label>
                    <input type="text" class="form-control mb-4" id="edit_nama_skema" disabled>
                </div>
                <label for="edit_nama_sub_skema" class="form-label">Sub-Skema</label>
                <div class="form-group" id="edit-nilai-sub-skema-wrapper">
                    <div class="input-group mb-3 nilai-sub-skema">
                        <!-- Input dinamis -- Ajax Request -->
                    </div>
                </div>

            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success rounded-3 text-white"
                    id="store_nilai_btn" value="0">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
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
                        confirmButtonText: 'Daftar',
                        cancelButtonText: 'Batal'
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

        function printCertificate(id) {
            var printFrame = document.getElementById('printFrame');

            // Show loading alert
            Swal.fire({
                title: 'Memuat...',
                text: 'Sedang Memproses!',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            printFrame.src = '/sertifikat/showSertifikat/' + id + '/pdf';

            printFrame.onload = function() {
                // Add delay to ensure PDF is fully loaded
                setTimeout(function() {
                    try {
                        window.frames['printFrame'].print();

                        // Close loading alert and show success message
                        Swal.fire({
                            title: 'Berhasil!',
                            text: 'Sertifikat siap dicetak',
                            icon: 'success',
                            timer: 2000,
                            showConfirmButton: false
                        });
                    } catch (error) {
                        // Close loading alert and show error message
                        Swal.fire({
                            title: 'Error!',
                            text: 'Gagal membuka dialog cetak',
                            icon: 'error'
                        });
                    }
                }, 1000); // Wait 1 second for PDF to fully load
            };

            // Handle error case
            printFrame.onerror = function() {
                Swal.fire({
                    title: 'Error!',
                    text: 'Gagal memuat sertifikat',
                    icon: 'error'
                });
            };
        }
    </script>

    <script>
        $(document).ready(function() {
            $(document).on('click', '.penilaian_btn', function (e) {
                e.preventDefault();
                pesertaID = $(this).data('peserta-id');

                $.ajax({
                    url: '/',
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        var data_peserta_edit = response.data_nilai;

                        $('#editNilaiModal').modal('show');
                        $('#edit_nama_peserta').val(data_peserta_edit[0].nama_lengkap);
                        $('#edit_nama_skema').val(data_skema.nama_skema);

                        $('#edit-nilai-sub-skema-wrapper').html("");
                        $('.nilai_sub_skema').val('');

                        $.each(data_peserta_edit, function(index, row) {
                            $('#edit-nilai-sub-skema-wrapper').append(
                                '<div class="px-1 mb-3 row">\
                                    <label class="col-sm-8 col-form-label" style="font-size: 18px;">' + row.judul_sub + '</label>\
                                    <div class="col-sm-4 d-flex justify-content-end">\
                                        <label for="input nilai" class="text-white center bg-secondary rounded-start px-4 py-1"\
                                            style="height: 35px;">Nilai</label>\
                                        <input type="hidden" class="edit_id_sub_skema" value="' + row.sub_skema_id + '">\
                                        <input type="number" class="form-control rounded-0 rounded-end edit_nilai_sub_skema"\
                                            style="width: 100px; height: 35px;" value="' + row.nilai + '">\
                                    </div>\
                                </div>'
                            );
                        });
                    },
                    error: function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Gagal memuat data nilai!'
                        });
                    }
                });
            });
        });
    </script>
@endpush
