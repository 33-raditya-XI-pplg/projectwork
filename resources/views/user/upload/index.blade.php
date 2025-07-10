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
        </style>
    @endpush

    <div class="container mt-2">
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
                                <td>{{ $row->status_pembayaran ?? 'Belum Dibayar' }}</td>

                                <td class="text-center">
                                    @if (($row->status_pembayaran === 'Menunggu' || $row->status_pembayaran === 'Sudah Dibayar') && $row->bukti_pembayaran)
                                        <a href="{{ asset('storage/' . $row->bukti_pembayaran) }}"
                                            class="btn btn-success btn-sm rounded text-light" target="_blank">
                                            <i class="fa fa-eye"></i> Lihat
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
                        <label class="control-label mb-2">Upload Foto Pengguna <span class="text-danger">*</span></label>
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
                        document.getElementById('debug_id').value = eventId; // Untuk debugging

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
            var debugInput = document.getElementById('debug_id');

            if (fileInput) fileInput.value = '';
            if (previewImg) {
                previewImg.src = '';
                previewImg.style.display = 'none';
            }
            if (hiddenInput) hiddenInput.value = '';
            if (debugInput) debugInput.value = '';
        });
    }
});
</script>

    {{-- <script>
document.addEventListener('DOMContentLoaded', function () {
    var eventRows = document.querySelectorAll('.event-row');

    eventRows.forEach(function(row) {
        row.addEventListener('click', function() {
            var eventId = this.getAttribute('data-event-id');
            var skemaRow = document.getElementById('skema-row-' + eventId);

            if (!skemaRow) {
                skemaRow = document.createElement('tr');
                skemaRow.id = 'skema-row-' + eventId;
                skemaRow.classList.add('skema-row');
                skemaRow.innerHTML = `
                    <td colspan="6">
                        <div id="skema-container-${eventId}" style="padding-left:150px;"></div>
                    </td>
                `;
                this.parentNode.insertBefore(skemaRow, this.nextSibling);
            }

            if (skemaRow.style.display === 'none' || skemaRow.style.display === '') {
                skemaRow.style.display = 'table-row';

                var skemaContainer = document.getElementById('skema-container-' + eventId);
                if (!skemaContainer.innerHTML) {
                    fetch(`/getSkema/${eventId}`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                var table = document.createElement('table');
                                table.classList.add('table', 'table-sm', 'table-bordered');

                                var thead = document.createElement('thead');
                                thead.innerHTML = `
                                    <tr>
                                        <th>No</th>
                                        <th>Nama Skema</th>
                                    </tr>
                                `;
                                table.appendChild(thead);

                                var tbody = document.createElement('tbody');
                                data.forEach(function(skema, index) {
                                    var row = document.createElement('tr');
                                    row.innerHTML = `
                                        <td>${index + 1}</td>
                                        <td>${skema.nama_skema}</td>
                                    `;
                                    tbody.appendChild(row);
                                });
                                table.appendChild(tbody);
                                skemaContainer.innerHTML = '';
                                skemaContainer.appendChild(table);
                            } else {
                                skemaContainer.innerHTML = '<p>Tidak ada skema untuk event ini.</p>';
                            }
                        })
                        .catch(error => {
                            console.error('Error fetching skema:', error);
                            skemaContainer.innerHTML = '<p>Terjadi kesalahan saat memuat skema.</p>';
                        });
                }
            } else {
                skemaRow.style.display = 'none';
            }
        });
    });
});
</script> --}}

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

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('.btn[data-id]').forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    var eventId = this.getAttribute('data-id');
                    fetch('/cek-peserta/' + eventId)
                        .then(res => res.json())
                        .then(data => {
                            if (data.status) {
                                var uploadModal = new bootstrap.Modal(document.getElementById('uploadModal'));
                                uploadModal.show();
                                document.getElementById('event_skema_id').value = eventId;
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
                        });
                });
            });
        });
    </script>
{{--
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var uploadModalEl = document.getElementById('uploadModal');
            if (uploadModalEl) {
                uploadModalEl.addEventListener('hidden.bs.modal', function () {
                    var fileInput = document.getElementById('upload_file');
                    var previewImg = document.getElementById('preview_image');
                    if (fileInput) fileInput.value = '';
                    if (previewImg) {
                        previewImg.src = '';
                        previewImg.style.display = 'none';
                    }

                    document.getElementsByClassName('modal-backdrop').forEach(function(element) {
                        element.remove();
                    });
                });
            }
        });
    </script> --}}
@endsection
