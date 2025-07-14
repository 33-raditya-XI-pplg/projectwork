@extends('layouts.panel.index')
@section('title', 'Sertifikat')
@section('content')
    @push('style')
        <style>
            .ck-editor__editable {
                min-height: 200px;
            }

            .dropzone-wrapper {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                height: 200px;
                border: 2px dashed #ddd;
                background-color: #f9f9f9;
                position: relative;
                cursor: pointer;
            }

            #image_preview {
                display: flex;
                align-items: center;
                justify-content: center;
                width: 100%;
                height: auto;
                max-width: 180px;
                max-height: 180px;
                overflow: hidden;
                margin: 0 auto;
            }

            #preview_image {
                max-width: 100%;
                max-height: 100%;
                object-fit: contain;
                display: block;
            }

            .shift-right {
                padding-left: 20px;
                /* Atau bisa juga margin-left jika lebih tepat */
            }

            .alert-rejected {
                background-color: #f8d7da;
                border-color: #f5c6cb;
                color: #721c24;
                padding: 10px;
                margin: 10px 0;
                border: 1px solid transparent;
                border-radius: 4px;
            }

            .status-badge {
                display: inline-block;
                padding: 0.25em 0.5em;
                font-size: 0.875em;
                font-weight: 500;
                line-height: 1;
                text-align: center;
                white-space: nowrap;
                vertical-align: baseline;
                border-radius: 0.25rem;
            }

            .status-ditolak {
                background-color: #dc3545;
                color: white;
            }

            .status-menunggu {
                background-color: #ffc107;
                color: #212529;
            }

            .status-dibayar {
                background-color: #28a745;
                color: white;
            }

            .status-belum {
                background-color: #6c757d;
                color: white;
            }
        </style>
    @endpush

    <div class="container mt-2">
        <!-- Alert untuk pembayaran yang ditolak -->
        @if(session('payment_rejected'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Pembayaran Ditolak!</strong> {{ session('payment_rejected') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Alert untuk pembayaran yang berhasil diupload -->
        @if(session('payment_success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <strong>Berhasil!</strong> {{ session('payment_success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Alert untuk error upload -->
        @if(session('payment_error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <strong>Error!</strong> {{ session('payment_error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Periksa apakah ada pembayaran yang ditolak -->
        @php
            $hasRejectedPayment = false;
            $rejectedPayments = [];
            foreach($upload as $row) {
                if($row->status_pembayaran === 'Ditolak') {
                    $hasRejectedPayment = true;
                    $rejectedPayments[] = $row;
                }
            }
        @endphp

        @if($hasRejectedPayment)
            <div class="alert alert-danger alert-dismissible fade show p-3 d-block" role="alert">
                <h6 class=""><i class="fa fa-exclamation-triangle"></i> Pembayaran Ditolak</h6>
                <p>Terdapat pembayaran yang ditolak. Silakan upload ulang bukti pembayaran yang sesuai:</p>
                <ul class="mb-0">
                    @foreach($rejectedPayments as $rejected)
                        <li><strong>{{ $rejected->nama_event }}</strong> - {{ $rejected->nama_skema }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="tab-content" id="pills-tabContent">
            <div class="bg-white rounded-4 px-3 py-3 mb-3 shadow-lg">
                <table id="example" class="table">
                    <thead class="fw-normal">
                        <tr>
                            <th scope="col" width="5%">No</th>
                            <th scope="col" width="20%">Event</th>
                            <th scope="col" width="20%">Skema</th>
                            <th scope="col" width="15%">Tanggal Mulai</th>
                            <th scope="col" width="15%">Tanggal Berakhir</th>
                            <th scope="col" width="8%">Status Pembayaran</th>
                            <th scope="col" width="8%" class="text-center">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="table-responsive" style="vertical-align: middle">
                        @php
                            $num = 1;
                            $previousEventName = ''; // Variable to track the previous event name
                        @endphp

                        @foreach ($upload as $row)
                            @if ($row->nama_event !== $previousEventName)
                                @php
                                    $previousEventName = $row->nama_event; // Update previous event name
                                    $num = 1; // Reset number when event name changes
                                @endphp
                            @endif

                            <tr class="event-row" data-event-id="{{ $row->id_event_skema }}">
                                <td>{{ $num++ }}</td> <!-- Display current number -->
                                <td>{{ $row->nama_event }}</td>
                                <td>{{ $row->nama_skema }}</td>
                                <td>{{ $row->tgl_mulai }}</td>
                                <td>{{ $row->tgl_berakhir }}</td>
                                <td>
                                    @php
                                        $status = $row->status_pembayaran ?? 'Belum Dibayar';
                                        $badgeClass = '';
                                        switch($status) {
                                            case 'Ditolak':
                                                $badgeClass = 'status-ditolak';
                                                break;
                                            case 'Menunggu':
                                                $badgeClass = 'status-menunggu';
                                                break;
                                            case 'Sudah Dibayar':
                                                $badgeClass = 'status-dibayar';
                                                break;
                                            default:
                                                $badgeClass = 'status-belum';
                                        }
                                    @endphp
                                    <span class="status-badge {{ $badgeClass }}">{{ $status }}</span>

                                    @if($row->status_pembayaran === 'Ditolak')
                                        <div class="mt-1">
                                            <small class="text-danger">
                                                <i class="fa fa-info-circle"></i>
                                                Silakan upload ulang bukti pembayaran
                                            </small>
                                        </div>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if (($row->status_pembayaran === 'Menunggu' || $row->status_pembayaran === 'Sudah Dibayar') && $row->bukti_pembayaran)
                                        <a href="{{ asset('storage/' . $row->bukti_pembayaran) }}"
                                            class="btn btn-success btn-sm rounded text-light" target="_blank">
                                            <i class="fa fa-eye"></i> Lihat
                                        </a>
                                    @elseif($row->status_pembayaran === 'Ditolak')
                                        <a href="#" class="btn btn-warning btn-sm rounded" data-id="{{ $row->id_event_skema }}">
                                            <i class="fa fa-upload"></i> Upload Ulang
                                        </a>
                                    @else
                                        <a href="#" class="btn btn-secondary btn-sm rounded" data-id="{{ $row->id_event_skema }}">
                                            <i class="fa fa-money-bill-1-wave"></i> Bayar
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- Modal untuk membuka modal --}}
<div class="modal fade" id="uploadModal" tabindex="-1" aria-labelledby="uploadModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="uploadModalLabel">Upload Pembayaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="uploadForm" action="{{ route('uploadPembayaran-user.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    {{-- Hapus value statis, biarkan JavaScript yang mengisi --}}
                    <input type="hidden" name="event_skema_id" id="event_skema_id" value="">

                    <div class="form-group mb-2">
                        <label class="control-label mb-2">Upload Bukti Pembayaran <span class="text-danger">*</span></label>
                        <div class="dropzone-wrapper">
                            <div class="dropzone-desc">
                                <i class="glyphicon glyphicon-download-alt"></i>
                                <p>Pilih gambar atau seret ke sini.</p>
                            </div>
                            <input type="file" name="upload_file" class="dropzone" id="upload_file" accept="image/*" required>
                            <div id="image_preview" class="mt-3">
                                <img id="preview_image" src="" alt="Image preview" style="max-width: 100%; max-height: 100%; object-fit: contain; display: none;">
                            </div>
                        </div>
                        <div class="mt-1">
                            <small style="color: red;">Format harus berupa: .jpg, .jpeg, .png, .bmp dan ukuran maksimal 2mb</small>
                        </div>
                        @error('path_foto')
                            <div class="text-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Handle tombol bayar
    document.querySelectorAll('.btn[data-id]').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var eventId = this.getAttribute('data-id');

            console.log('Tombol diklik, Event ID:', eventId); // Debug log

            fetch('/cek-peserta/' + eventId)
                .then(res => res.json())
                .then(data => {
                    if (data.status) {
                        // Set nilai yang benar ke input hidden
                        document.getElementById('event_skema_id').value = eventId;

                        console.log('Input hidden diset dengan value:', eventId); // Debug log

                        var uploadModal = new bootstrap.Modal(document.getElementById('uploadModal'));
                        uploadModal.show();
                    } else {
                        if (typeof Swal !== 'undefined') {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Tidak Bisa Upload',
                                text: data.message,
                                confirmButtonColor: '#3085d6',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            alert(data.message);
                        }
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Error',
                            text: 'Terjadi kesalahan saat memproses permintaan.',
                            confirmButtonColor: '#3085d6',
                            confirmButtonText: 'OK'
                        });
                    } else {
                        alert('Terjadi kesalahan saat memproses permintaan.');
                    }
                });
        });
    });

    // Preview image on file input change
    var uploadFileInput = document.getElementById('upload_file');
    if (uploadFileInput) {
        uploadFileInput.addEventListener('change', function(event) {
            const file = event.target.files[0];
            const preview = document.getElementById('preview_image');
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                    preview.style.display = 'block';
                }
                reader.readAsDataURL(file);
            }
        });
    }

    // Reset form saat modal ditutup
    var uploadModalEl = document.getElementById('uploadModal');
    if (uploadModalEl) {
        uploadModalEl.addEventListener('hidden.bs.modal', function () {
            var fileInput = document.getElementById('upload_file');
            var previewImg = document.getElementById('preview_image');
            var hiddenInput = document.getElementById('event_skema_id');

            if (fileInput) fileInput.value = '';
            if (previewImg) {
                previewImg.src = '';
                previewImg.style.display = 'none';
            }
            if (hiddenInput) hiddenInput.value = '';
        });
    }

    // Auto-dismiss alerts after 5 seconds
    setTimeout(function() {
        var alerts = document.querySelectorAll('.alert');
        alerts.forEach(function(alert) {
            if (alert.querySelector('.btn-close')) {
                alert.querySelector('.btn-close').click();
            }
        });
    }, 5000);
});
</script>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Preview image on file input change
            var uploadFileInput = document.getElementById('upload_file');
            if (uploadFileInput) {
                uploadFileInput.addEventListener('change', function(event) {
                    const file = event.target.files[0];
                    const preview = document.getElementById('preview_image');
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            preview.src = e.target.result;
                            preview.style.display = 'block';
                        }
                        reader.readAsDataURL(file);
                    }
                });
            }
        });
    </script>

    {{-- upload gambar  --}}
    <script>
        Dropzone.options.path_file = {
            maxFilesize: 2,
            acceptedFiles: "image/*",
            init: function() {
                this.on("success", function(file, response) {});
                this.on("error", function(file, response) {
                    document.getElementById('image_error').innerHTML = response.message;
                });
            }
        };
    </script>
@endsection
