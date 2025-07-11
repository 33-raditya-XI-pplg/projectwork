@extends('layouts.panel.index')
@section('title', 'Upload Bukti Pembayaran')
@section('content')
    @push('style')
        <style>
            .ck-editor__editable {
                min-height: 200px;
            }
            .nav-pills .nav-link {
                border-radius: 0;
                margin-bottom: -1px; /* To overlap the border of the card */
            }
            .nav-pills .nav-link.active {
                background-color: #007bff; /* Active tab color */
                color: white;
            }
            .table-responsive {
                border-radius: 0 0 0.5rem 0.5rem;
            }

            .card-upload {
                padding: 1px;
                display: grid;
                gap: 1rem;
                background-color: var(--extra-light);
                border-radius: 5px;
                box-shadow: 5px 5px 30px rgba(0, 0, 0, 0.1);
                cursor: pointer;
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
        </style>
    @endpush

    <div class="container mt-4">
        <div class="card-upload">
            <div class="card-header">
                <nav>
                    <div class="nav nav-pills nav-justified" id="nav-tab" role="tablist">
                        <button class="nav-link active" id="nav-all-tab" data-bs-toggle="tab" data-bs-target="#nav-all" type="button"
                            role="tab" aria-controls="nav-all" aria-selected="true">Persetujuan Pembayaran</button>
                        <button class="nav-link" id="nav-draft-tab" data-bs-toggle="tab" data-bs-target="#nav-draft" type="button"
                            role="tab" aria-controls="nav-draft" aria-selected="false">History Pembayaran</button>
                    </div>
                </nav>
            </div>

            <div class="card-body">
                <div class="tab-content" id="nav-tabContent">
                    <!-- All Tab Content -->
                    <div class="tab-pane fade show active" id="nav-all" role="tabpanel" aria-labelledby="nav-all-tab">
                        <div class="table-responsive">
                            <table class="table" id="verifikasi-table">
                                <thead class="fw-normal">
                                    <tr>
                                        <th scope="col" width="5%">No</th>
                                        <th scope="col" width="20%">Nama</th>
                                        <th scope="col" width="20%">Event</th>
                                        <th scope="col" width="20%">Skema</th>
                                        <th scope="col" width="15%">Tanggal Mulai</th>
                                        <th scope="col" width="15%">Tanggal Berakhir</th>
                                        <th scope="col" width="8%">Status</th>
                                        <th scope="col" width="8%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="table-responsive" style="vertical-align: middle">
                                    @php $num = 1 @endphp
                                    @foreach ($uploadPending as $pending)
                                        <tr class="clickable-row event-row" data-id="{{ $pending->id_upload_pembayaran }}">
                                            <td>{{ $num++ }}</td>
                                            <td>{{ $pending->nama_lengkap }}</td>
                                            <td>{{ $pending->nama_event }}</td>
                                            <td>{{ $pending->nama_skema }}</td>
                                            <td>{{ $pending->tgl_mulai }}</td>
                                            <td>{{ $pending->tgl_berakhir }}</td>
                                            <td>{{ $pending->status_pembayaran ?? 'Belum Dibayar' }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ asset('storage/' . $pending->bukti_pembayaran) }}" target="_blank"
                                                        class="btn btn-info btn-sm rounded text-white d-flex align-items-center gap-1">
                                                        <i class="fa fa-eye" style="font-size: 0.75rem; color: white;"></i>
                                                        <span class="text-white">Lihat</span>
                                                    </a>
                                                    <form action="{{ route('upload.updateStatus', $pending->id_upload_pembayaran) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-success btn-sm rounded text-white d-flex align-items-center gap-1"
                                                            name="status" value="Sudah Dibayar">
                                                            <i class="fa fa-check" style="font-size: 0.75rem; color: white;"></i>
                                                            <span class="text-white">Selesaikan</span>
                                                        </button>
                                                    </form>
                                                    <form action="{{ route('upload.updateStatus', $pending->id_upload_pembayaran) }}" method="POST">
                                                        @csrf
                                                        @method('PUT')
                                                        <button type="submit" class="btn btn-danger btn-sm rounded text-white d-flex align-items-center gap-1"
                                                            name="status" value="Ditolak">
                                                            <i class="fa-solid fa-x" style="font-size: 0.75rem; color: white;"></i>
                                                            <span class="text-white">Ditolak</span>
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

                    <!-- Draft Tab Content -->
                    <div class="tab-pane fade" id="nav-draft" role="tabpanel" aria-labelledby="nav-draft-tab">
                        <div class="table-responsive">
                            <table class="table" id="history-table">
                                <thead class="fw-normal">
                                    <tr>
                                        <th scope="col" width="5%">No</th>
                                        <th scope="col" width="20%">Nama</th>
                                        <th scope="col" width="20%">Event</th>
                                        <th scope="col" width="20%">Skema</th>
                                        <th scope="col" width="15%">Tanggal Mulai</th>
                                        <th scope="col" width="15%">Tanggal Berakhir</th>
                                        <th scope="col" width="8%">Status</th>
                                        <th scope="col" width="8%" class="text-center">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody class="table-responsive" style="vertical-align: middle">
                                    @php $num2 = 1 @endphp
                                    @foreach ($uploadAll as $uploadall)
                                        <tr class="clickable-row event-row" data-id="{{ $uploadall->id_upload_pembayaran }}">
                                            <td>{{ $num2++ }}</td>
                                            <td>{{ $uploadall->nama_lengkap }}</td>
                                            <td>{{ $uploadall->nama_event }}</td>
                                            <td>{{ $uploadall->nama_skema }}</td>
                                            <td>{{ $uploadall->tgl_mulai }}</td>
                                            <td>{{ $uploadall->tgl_berakhir }}</td>
                                            <td>{{ $uploadall->status_pembayaran ?? 'Draft' }}</td>
                                            <td class="text-center">
                                                <div class="d-flex justify-content-center gap-2">
                                                    <a href="{{ asset('storage/' . $uploadall->bukti_pembayaran) }}" target="_blank"
                                                        class="btn btn-info btn-sm rounded text-white d-flex align-items-center gap-1">
                                                        <i class="fa fa-eye" style="font-size: 0.75rem; color: white;"></i>
                                                        <span class="text-white">Lihat</span>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Additional Tabs (Publish, Berlangsung, Selesai) -->
                    <div class="tab-pane fade" id="nav-publish" role="tabpanel" aria-labelledby="nav-publish-tab">
                        <!-- Content for Publish Tab -->
                    </div>
                    <div class="tab-pane fade" id="nav-live" role="tabpanel" aria-labelledby="nav-live-tab">
                        <!-- Content for Berlangsung Tab -->
                    </div>
                    <div class="tab-pane fade" id="nav-end" role="tabpanel" aria-labelledby="nav-end-tab">
                        <!-- Content for Selesai Tab -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Initialize Bootstrap tabs
            var triggerTabList = [].slice.call(document.querySelectorAll('#nav-tab button'));
            triggerTabList.forEach(function (triggerEl) {
                var tabTrigger = new bootstrap.Tab(triggerEl);
                triggerEl.addEventListener('click', function (event) {
                    event.preventDefault();
                    tabTrigger.show();
                });
            });

            // Handle modal for upload
            var uploadModal = document.getElementById('uploadModal');
            if (uploadModal) {
                uploadModal.addEventListener('show.bs.modal', function (event) {
                    var button = event.relatedTarget;
                    var eventId = button.getAttribute('data-id');
                    var eventInput = document.getElementById('event_id');
                    if (eventInput) {
                        eventInput.value = eventId;
                    } else {
                        console.error('Hidden input with ID "event_id" not found.');
                    }
                });
            }
        });
    </script>
@endsection
