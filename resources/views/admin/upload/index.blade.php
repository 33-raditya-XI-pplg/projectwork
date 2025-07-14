@extends('layouts.panel.index')
@section('title', 'Upload Bukti Pembayaran')
@section('content')
    @push('style')
        <style>
            :root {
                --primary-color: #1e90ff;
                --success-color: #2ecc71;
                --danger-color: #e74c3c;
                --info-color: #3498db;
                --warning-color: #f39c12;
                --background-color: #ffffff;
                --card-bg: #f9fafb;
                --text-color: #2d3748;
                --text-muted: #718096;
                --border-color: #e2e8f0;
            }

            /* Dark mode support */
            @media (prefers-color-scheme: dark) {
                :root {
                    --background-color: #1a202c;
                    --card-bg: #2d3748;
                    --text-color: #e2e8f0;
                    --text-muted: #a0aec0;
                    --border-color: #4a5568;
                }
            }

            body {
                background-color: var(--background-color);
                color: var(--text-color);
                font-family: 'Inter', sans-serif;
            }

            .container {
                max-width: 1300px;
                padding: 2rem 1rem;
                margin: 0 auto;
            }



            .card-upload {
                background-color: var(--card-bg);
                border-radius: 16px;
                border: 1px solid var(--border-color);
                overflow: hidden;
                transition: all 0.3s ease-in-out;
            }

            .card-upload:hover {
                box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
                transform: translateY(-3px);
            }

            .card-header {
                background-color: transparent;
                padding: 0;
                border-bottom: none;
            }

            .nav-tabs {
                border-bottom: none;
                padding: 0.5rem 1rem;
                background-color: var(--card-bg);
            }

            .nav-tabs .nav-link {
                color: var(--text-muted);
                font-weight: 600;
                padding: 0.75rem 1.5rem;
                border: none;
                position: relative;
                transition: color 0.3s ease;
            }

            .nav-tabs .nav-link:hover {
                color: var(--primary-color);
            }

            .nav-tabs .nav-link.active {
                color: var(--primary-color);
                background-color: transparent;
            }

            .nav-tabs .nav-link.active::after {
                content: '';
                position: absolute;
                bottom: 0;
                left: 0;
                width: 100%;
                height: 3px;
                background-color: var(--primary-color);
                border-radius: 2px;
            }

            .card-body {
                padding: 2rem;
            }

            .table {
                background-color: var(--card-bg);
                color: var(--text-color);
                border-collapse: separate;
                border-spacing: 0;
            }

            .table thead th {
                font-size: 0.85rem;
                font-weight: 600;
                text-transform: uppercase;
                color: var(--text-muted);
                padding: 1rem;
                border-bottom: 1px solid var(--border-color);
            }

            .table tbody tr {
                transition: background-color 0.2s ease;
            }

            .table tbody tr:hover {
                background-color: rgba(30, 144, 255, 0.05);
            }

            .table td {
                padding: 1rem;
                vertical-align: middle;
                border-top: 1px solid var(--border-color);
            }

            .badge {
                padding: 0.5rem 0.75rem;
                font-size: 0.75rem;
                border-radius: 12px;
            }

            .btn-custom {
                padding: 0.5rem 1rem;
                font-size: 0.9rem;
                font-weight: 500;
                border-radius: 10px;
                display: inline-flex;
                align-items: center;
                gap: 0.5rem;
                transition: all 0.2s ease;
            }

            .btn-custom:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            }

            .btn-info {
                background-color: var(--info-color);
                border-color: var(--info-color);
                color: white;
            }

            .btn-success {
                background-color: var(--success-color);
                border-color: var(--success-color);
                color: white;
            }

            .btn-danger {
                background-color: var(--danger-color);
                border-color: var(--danger-color);
                color: white;
           36

            /* Responsive adjustments */
            @media (max-width: 768px) {
                .card-body {
                    padding: 1rem;
                }

                .nav-tabs .nav-link {
                    padding: 0.5rem 1rem;
                    font-size: 0.9rem;
                }

                .table th, .table td {
                    font-size: 0.8rem;
                    padding: 0.75rem;
                }

                .btn-custom {
                    padding: 0.4rem 0.8rem;
                    font-size: 0.8rem;
                }

                /* .alert {
                    padding: 0.75rem 1rem;
                    font-size: 0.9rem;
                } */

                /* Alert Styles */
                /* .alert {
                    padding: 1rem 1.5rem;
                    border-radius: 12px;
                    border: 1px solid var(--border-color);
                    margin-bottom: 1.5rem;
                    position: relative;
                    display: flex;
                    align-items: center;
                    gap: 0.75rem;
                    font-weight: 500;
                    animation: slideDown 0.3s ease-out;
                    background-color: white;
                    color: var(--text-color);
                    box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
                }

                @keyframes slideDown {
                    from {
                        opacity: 0;
                        transform: translateY(-10px);
                    }
                    to {
                        opacity: 1;
                        transform: translateY(0);
                    }
                }

                .alert-success,
                .alert-danger,
                .alert-warning,
                .alert-info {
                    background-color: white;
                    border-color: var(--border-color);
                    color: var(--text-color);
                }

                .alert .alert-icon {
                    font-size: 1.2rem;
                    flex-shrink: 0;
                }

                .alert .alert-content {
                    flex: 1;
                }

                .alert .alert-title {
                    font-weight: 600;
                    margin-bottom: 0.25rem;
                }

                .alert .alert-message {
                    margin: 0;
                    opacity: 0.9;
                }

                .alert .alert-close {
                    background: none;
                    border: none;
                    font-size: 1.5rem;
                    cursor: pointer;
                    opacity: 0.7;
                    transition: opacity 0.2s ease;
                    color: currentColor;
                    padding: 0;
                    width: 24px;
                    height: 24px;
                    display: flex;
                    align-items: center;
                    justify-content: center;
                }

                .alert .alert-close:hover {
                    opacity: 1;
                }
                @media (prefers-color-scheme: dark) {
                    .alert {
                        background-color: var(--card-bg);
                        color: var(--text-color);
                        border-color: var(--border-color);
                    }

                    .alert-success,
                    .alert-danger,
                    .alert-warning,
                    .alert-info {
                        background-color: var(--card-bg);
                        color: var(--text-color);
                        border-color: var(--border-color);
                    }
                } */
            }
        </style>
    @endpush

    <div class="container">
        <!-- Modal Konfirmasi -->
        <div class="modal fade" id="confirmModal" tabindex="-1" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="confirmModalLabel">Konfirmasi</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        Apakah Anda yakin ingin menyelesaikan pembayaran ini?
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="button" class="btn btn-success" id="confirmSubmit">Selesaikan</button>
                    </div>
                </div>
            </div>
        </div>
        <!-- Alert Messages -->
        @if (session('success'))
            <div class="alert alert-success" id="successAlert">
                <i class="fa fa-check-circle alert-icon"></i>
                <div class="alert-content">
                    <div class="alert-title">Berhasil!</div>
                    <p class="alert-message">{{ session('success') }}</p>
                </div>
                <button type="button" class="alert-close" onclick="closeAlert('successAlert')">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger" id="errorAlert">
                <i class="fa fa-exclamation-circle alert-icon"></i>
                <div class="alert-content">
                    <div class="alert-title">Error!</div>
                    <p class="alert-message">{{ session('error') }}</p>
                </div>
                <button type="button" class="alert-close" onclick="closeAlert('errorAlert')">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        @endif

        @if (session('warning'))
            <div class="alert alert-warning" id="warningAlert">
                <i class="fa fa-exclamation-triangle alert-icon"></i>
                <div class="alert-content">
                    <div class="alert-title">Peringatan!</div>
                    <p class="alert-message">{{ session('warning') }}</p>
                </div>
                <button type="button" class="alert-close" onclick="closeAlert('warningAlert')">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        @endif

        @if (session('info'))
            <div class="alert alert-info" id="infoAlert">
                <i class="fa fa-info-circle alert-icon"></i>
                <div class="alert-content">
                    <div class="alert-title">Informasi</div>
                    <p class="alert-message">{{ session('info') }}</p>
                </div>
                <button type="button" class="alert-close" onclick="closeAlert('infoAlert')">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger" id="validationAlert">
                <i class="fa fa-exclamation-circle alert-icon"></i>
                <div class="alert-content">
                    <div class="alert-title">Terjadi Kesalahan!</div>
                    <div class="alert-message">
                        @foreach ($errors->all() as $error)
                            <p style="margin: 0.25rem 0;">{{ $error }}</p>
                        @endforeach
                    </div>
                </div>
                <button type="button" class="alert-close" onclick="closeAlert('validationAlert')">
                    <i class="fa fa-times"></i>
                </button>
            </div>
        @endif

        <div class="card-upload">
            <div class="card-header">
                <nav>
                    <div class="nav nav-tabs nav-justified" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-all-tab" data-bs-toggle="tab" data-bs-target="#nav-all" type="button"
                            role="tab" aria-controls="nav-all" aria-selected="true">Persetujuan Pembayaran</button>
                        <button class="nav-link" id="nav-draft-tab" data-bs-toggle="tab" data-bs-target="#nav-draft" type="button"
                            role="tab" aria-controls="nav-draft" aria-selected="false">History Pembayaran</button>
                    </div>
                </nav>
            </div>

            <div class="card-body">
                <div class="tab-content" id="nav-tabContent">
                    <!-- Persetujuan Pembayaran Tab -->
                    <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
                        <div class="table-responsive">
                            <table class="table" id="verifikasi-table">
                                <thead>
                                    <tr>
                                        <th scope="col" width="5%">No</th>
                                        <th scope="col" width="20%">Nama</th>
                                        <th scope="col" width="20%">Event</th>
                                        <th scope="col" width="20%">Skema</th>
                                        <th scope="col" width="15%">Tanggal Mulai</th>
                                        <th scope="col" width="15%">Tanggal Berakhir</th>
                                        <th scope="col" width="10%">Status</th>
                                        <th scope="col" width="15%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $num = 1 @endphp
                                    @foreach ($uploadPending as $pending)
                                        <tr class="clickable-row event-row" data-id="{{ $pending->id_upload_pembayaran }}">
                                            <td>{{ $num++ }}</td>
                                            <td>{{ $pending->nama_lengkap }}</td>
                                            <td>{{ $pending->nama_event }}</td>
                                            <td>{{ $pending->nama_skema }}</td>
                                            <td>{{ $pending->tgl_mulai }}</td>
                                            <td>{{ $pending->tgl_berakhir }}</td>
                                            <td>
                                                <span class="badge bg-{{ $pending->status_pembayaran == 'Sudah Dibayar' ? 'success' : ($pending->status_pembayaran == 'Ditolak' ? 'danger' : 'warning') }}">
                                                    {{ $pending->status_pembayaran ?? 'Belum Dibayar' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ asset('storage/' . $pending->bukti_pembayaran) }}" target="_blank"
                                                        class="btn btn-custom btn-info">
                                                        <i class="fa fa-eye"></i> Lihat
                                                    </a>
                                                    <form action="{{ route('upload.updateStatus', $pending->id_upload_pembayaran) }}" method="POST" class="complete-form">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="button" class="btn btn-custom btn-success complete-btn"
                                                            data-bs-toggle="modal" data-bs-target="#confirmModal">
                                                            <i class="fa fa-check"></i> Selesaikan
                                                        </button>
                                                        <input type="hidden" name="status" value="Sudah Dibayar">
                                                    </form>
                                                    <form action="{{ route('upload.updateStatus', $pending->id_upload_pembayaran) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-custom btn-danger"
                                                            name="status" value="Ditolak">
                                                            <i class="fa-solid fa-x"></i> Ditolak
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- History Pembayaran Tab -->
                    <div class="tab-pane fade" id="nav-draft" role="tabpanel" aria-labelledby="nav-draft-tab">
                        <div class="table-responsive">
                            <table class="table" id="history-table">
                                <thead>
                                    <tr>
                                        <th scope="col" width="5%">No</th>
                                        <th scope="col" width="20%">Nama</th>
                                        <th scope="col" width="20%">Event</th>
                                        <th scope="col" width="20%">Skema</th>
                                        <th scope="col" width="15%">Tanggal Mulai</th>
                                        <th scope="col" width="15%">Tanggal Berakhir</th>
                                        <th scope="col" width="10%">Status</th>
                                        <th scope="col" width="10%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @php $num2 = 1 @endphp
                                    @foreach ($uploadAll as $uploadall)
                                        <tr class="clickable-row event-row" data-id="{{ $uploadall->id_upload_pembayaran }}">
                                            <td>{{ $num2++ }}</td>
                                            <td>{{ $uploadall->nama_lengkap }}</td>
                                            <td>{{ $uploadall->nama_event }}</td>
                                            <td>{{ $uploadall->nama_skema }}</td>
                                            <td>{{ $uploadall->tgl_mulai }}</td>
                                            <td>{{ $uploadall->tgl_berakhir }}</td>
                                            <td>
                                                <span class="badge bg-{{ $uploadall->status_pembayaran == 'Sudah Dibayar' ? 'success' : ($uploadall->status_pembayaran == 'Ditolak' ? 'danger' : 'warning') }}">
                                                    {{ $uploadall->status_pembayaran ?? 'Draft' }}
                                                </span>
                                            </td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ asset('storage/' . $uploadall->bukti_pembayaran) }}" target="_blank"
                                                        class="btn btn-custom btn-info">
                                                        <i class="fa fa-eye"></i> Lihat
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                // Initialize Bootstrap tabs
                const tabs = document.querySelectorAll('#nav-tab .nav-link');
                tabs.forEach(tab => {
                    tab.addEventListener('click', e => {
                        e.preventDefault();
                        new bootstrap.Tab(tab).show();
                    });
                });

                // Handle konfirmasi untuk tombol Selesaikan
                const confirmSubmitButton = document.getElementById('confirmSubmit');
                let currentForm = null;

                document.querySelectorAll('.complete-btn').forEach(button => {
                    button.addEventListener('click', () => {
                        currentForm = button.closest('form');
                    });
                });

                confirmSubmitButton.addEventListener('click', () => {
                    if (currentForm) {
                        currentForm.submit();
                    }
                });

                // Handle modal for upload
                const uploadModal = document.getElementById('uploadModal');
                if (uploadModal) {
                    uploadModal.addEventListener('show.bs.modal', e => {
                        const button = e.relatedTarget;
                        const eventId = button.getAttribute('data-id');
                        const eventInput = document.getElementById('event_id');
                        if (eventInput) {
                            eventInput.value = eventId;
                        } else {
                            console.error('Hidden input with ID "event_id" not found.');
                        }
                    });
                }

                // Auto-hide alerts after 5 seconds
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(alert => {
                    setTimeout(() => {
                        if (alert && alert.parentNode) {
                            alert.style.opacity = '0';
                            alert.style.transform = 'translateY(-10px)';
                            setTimeout(() => {
                                alert.remove();
                            }, 300);
                        }
                    }, 5000);
                });
            });

            // Function to close alert manually
            function closeAlert(alertId) {
                const alert = document.getElementById(alertId);
                if (alert) {
                    alert.style.opacity = '0';
                    alert.style.transform = 'translateY(-10px)';
                    setTimeout(() => {
                        alert.remove();
                    }, 300);
                }
            }

            // Function to show custom alert (for JavaScript usage)
            function showAlert(type, title, message) {
                const alertTypes = {
                    success: { icon: 'fa-check-circle', class: 'alert-success' },
                    error: { icon: 'fa-exclamation-circle', class: 'alert-danger' },
                    warning: { icon: 'fa-exclamation-triangle', class: 'alert-warning' },
                    info: { icon: 'fa-info-circle', class: 'alert-info' }
                };

                const alertType = alertTypes[type] || alertTypes.info;
                const alertId = 'customAlert' + Date.now();

                const alertHtml = `
                    <div class="alert ${alertType.class}" id="${alertId}">
                        <i class="fa ${alertType.icon} alert-icon"></i>
                        <div class="alert-content">
                            <div class="alert-title">${title}</div>
                            <p class="alert-message">${message}</p>
                        </div>
                        <button type="button" class="alert-close" onclick="closeAlert('${alertId}')">
                            <i class="fa fa-times"></i>
                        </button>
                    </div>
                `;

                const container = document.querySelector('.container');
                const cardUpload = document.querySelector('.card-upload');
                container.insertBefore(
                    document.createRange().createContextualFragment(alertHtml).firstElementChild,
                    cardUpload
                );

                // Auto-hide after 5 seconds
                setTimeout(() => {
                    closeAlert(alertId);
                }, 5000);
            }
        </script>
    @endpush
@endsection
