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

            /* Custom styling untuk alert yang lebih menonjol */
            .alert-rejection-summary {
                border-left: 4px solid #dc3545;
                background-color: #f8d7da;
                border-color: #f5c6cb;
            }

            .alert-rejection-summary .alert-heading {
                color: #721c24;
                font-weight: 600;
            }

            .alert-rejection-summary ul {
                margin-bottom: 0;
            }

            .alert-rejection-summary li {
                margin-bottom: 0.25rem;
            }

            .alert-rejection-summary .btn-close {
                filter: invert(1);
            }
        </style>
    @endpush

    <div class="container mt-2">
        <!-- Alert untuk pembayaran yang ditolak dari session -->
        @if(session('payment_rejected'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Pembayaran Ditolak!</strong> {{ session('payment_rejected') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Alert untuk pembayaran yang berhasil diupload -->
        @if(session('payment_success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fas fa-check-circle me-2"></i>
                <strong>Berhasil!</strong> {{ session('payment_success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Alert untuk error upload -->
        @if(session('payment_error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <i class="fas fa-times-circle me-2"></i>
                <strong>Error!</strong> {{ session('payment_error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Alert untuk ringkasan pembayaran yang ditolak -->
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
            <div class="alert alert-danger alert-dismissible fade show alert-rejection-summary" role="alert">
                <div class="d-flex align-items-start">
                    <i class="fas fa-exclamation-triangle me-3 mt-1" style="font-size: 1.2rem;"></i>
                    <div class="flex-grow-1">
                        <h6 class="alert-heading mb-2">
                            <i class="fas fa-ban me-1"></i>
                            Pembayaran Ditolak ({{ count($rejectedPayments) }} item)
                        </h6>
                        <p class="mb-2">Terdapat pembayaran yang ditolak oleh admin. Silakan upload ulang bukti pembayaran yang sesuai untuk item berikut:</p>
                        <div class="row">
                            <div class="col-12">
                                <div class="border rounded p-2 bg-light">
                                    @foreach($rejectedPayments as $index => $rejected)
                                        <div class="d-flex justify-content-between align-items-center py-1 {{ $index < count($rejectedPayments) - 1 ? 'border-bottom' : '' }}">
                                            <div>
                                                <strong class="text-danger">{{ $rejected->nama_event }}</strong>
                                                <span class="text-muted">-</span>
                                                <span class="text-dark">{{ $rejected->nama_skema }}</span>
                                            </div>
                                            <small class="text-muted">
                                                <i class="fas fa-calendar-alt me-1"></i>
                                                {{ date('d/m/Y', strtotime($rejected->tgl_mulai)) }}
                                            </small>
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <small class="text-muted">
                                <i class="fas fa-info-circle me-1"></i>
                                Klik tombol "Upload Ulang" pada tabel di bawah untuk mengupload bukti pembayaran yang baru.
                            </small>
                        </div>
                    </div>
                </div>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <!-- Alert khusus jika ada lebih dari 3 pembayaran ditolak -->
        @if(count($rejectedPayments) > 3)
            <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <strong>Perhatian!</strong> Anda memiliki banyak pembayaran yang ditolak.
                Pastikan untuk mengupload bukti pembayaran yang jelas dan sesuai dengan instruksi.
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
                            $previousEventName = '';
                        @endphp

                        @foreach ($upload as $row)
                            @if ($row->nama_event !== $previousEventName)
                                @php
                                    $previousEventName = $row->nama_event;
                                    $num = 1;
                                @endphp
                            @endif

                            <tr class="event-row" data-event-id="{{ $row->id_event_skema }}">
                                <td>{{ $num++ }}</td>
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
                                                <i class="fas fa-info-circle"></i>
                                                Silakan upload ulang bukti pembayaran
                                            </small>
                                        </div>
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if (($row->status_pembayaran === 'Menunggu' || $row->status_pembayaran === 'Sudah Dibayar') && $row->bukti_pembayaran)
                                        <a href="{{ asset('storage/' . $row->bukti_pembayaran) }}"
                                            class="btn btn-success btn-sm rounded text-light" target="_blank">
                                            <i class="fas fa-eye"></i> Lihat
                                        </a>
                                    @elseif($row->status_pembayaran === 'Ditolak')
                                        <a href="#" class="btn btn-warning btn-sm rounded" data-id="{{ $row->id_event_skema }}">
                                            <i class="fas fa-upload"></i> Upload Ulang
                                        </a>
                                    @else
                                        <a href="#" class="btn btn-secondary btn-sm rounded" data-id="{{ $row->id_event_skema }}">
                                            <i class="fas fa-money-bill-wave"></i> Bayar
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

    {{-- Modal untuk upload pembayaran --}}
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

                console.log('Tombol diklik, Event ID:', eventId);

                fetch('/cek-peserta/' + eventId)
                    .then(res => res.json())
                    .then(data => {
                        if (data.status) {
                            document.getElementById('event_skema_id').value = eventId;
                            console.log('Input hidden diset dengan value:', eventId);

                            var uploadModal = new bootstrap.Modal(document.getElementById('uploadModal'));
                            uploadModal.show();
                        } else {
                            // Show Bootstrap alert instead of SweetAlert
                            showBootstrapAlert('warning', 'Tidak Bisa Upload', data.message);
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        showBootstrapAlert('danger', 'Error', 'Terjadi kesalahan saat memproses permintaan.');
                    });
            });
        });

        // Function to show Bootstrap alert
        function showBootstrapAlert(type, title, message) {
            const alertHtml = `
                <div class="alert alert-${type} alert-dismissible fade show" role="alert">
                    <i class="fas fa-${type === 'danger' ? 'times-circle' : 'exclamation-triangle'} me-2"></i>
                    <strong>${title}!</strong> ${message}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            `;

            // Insert alert at the top of the container
            const container = document.querySelector('.container.mt-2');
            container.insertAdjacentHTML('afterbegin', alertHtml);

            // Auto-dismiss after 5 seconds
            setTimeout(function() {
                const alert = container.querySelector('.alert');
                if (alert) {
                    const closeBtn = alert.querySelector('.btn-close');
                    if (closeBtn) {
                        closeBtn.click();
                    }
                }
            }, 5000);
        }

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

    {{-- Upload gambar script --}}
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
