@extends('layouts.panel.index')
@section('title', 'Upload Bukti pembayaran')
@section('content')
    @push('style')
        <style>
            .ck-editor__editable {
                min-height: 200px;
            }
        </style>
    @endpush

    <div class="container mt-2">
        <div class="tab-content" id="pills-tabContent">
            <div class="bg-white rounded-4 px-3 py-3 mb-3 shadow-lg">
                <table id="example" class="table">
                    <thead class="fw-normal">
                        <th scope="col" width="5%">No</th>
                        <th scope="col" width="20%">Nama</th>
                        <th scope="col" width="20%">Event</th>
                        <th scope="col" width="20%">Skema</th>
                        <th scope="col" width="15%">Tanggal Mulai</th>
                        <th scope="col" width="15%">Tanggal Berakhir</th>
                        <th scope="col" width="8%">Status</th>
                        <th scope="col" width="8%" class="text-center">Aksi</th>
                    </thead>

                    <tbody class="table-responsive" style="vertical-align: middle">
                        @php $num = 1 @endphp
                        @foreach ($upload as $row)
                            <tr class="clickable-row event-row" data-id="{{ $row->id_upload_pembayaran }}">
                                <td>{{ $num++ }}</td>
                                <td>{{ $row->nama_lengkap }}</td>
                                <td>{{ $row->nama_skema }}</td>
                                <td>{{ $row->nama_event }}</td>
                                <td>{{ $row->tgl_mulai }}</td>
                                <td>{{ $row->tgl_berakhir }}</td>
                                <td>{{ $row->status_pembayaran ?? 'Belum Dibayar' }}</td>
                                    <td class="text-center">
                                        <div class="d-flex justify-content-center gap-2">
                                            <a href="{{ asset('storage/' . $row->bukti_pembayaran) }}" target="_blank"
                                                class="btn btn-info btn-sm rounded text-white d-flex align-items-center gap-1">
                                                <i class="fa fa-eye" style="font-size: 0.75rem; color: white;"></i>
                                                <span class="text-white">Lihat</span>
                                            </a>

                                            <form action="{{ route('upload.updateStatus', $row->id_upload_pembayaran) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="btn btn-success btn-sm rounded text-white d-flex align-items-center gap-1"
                                                    name="status" value="Sudah Dibayar">
                                                    <i class="fa fa-check" style="font-size: 0.75rem; color: white;"></i>
                                                    <span class="text-white">Selesaikan</span>
                                                </button>
                                            </form>

                                            <form action="{{ route('upload.updateStatus', $row->id_upload_pembayaran) }}" method="POST">
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
    </div>
    {{-- <script>
        document.addEventListener('DOMContentLoaded', function () {
            var eventRows = document.querySelectorAll('.event-row');

            eventRows.forEach(function(row) {
                row.addEventListener('click', function() {
                    var eventId = this.getAttribute('data-id');
                    var skemaRow = document.getElementById('skema-row-' + eventId);

                    if (!skemaRow) {
                        skemaRow = document.createElement('tr');
                        skemaRow.id = 'skema-row-' + eventId;
                        skemaRow.classList.add('skema-row');
                        skemaRow.innerHTML = `
                            <td colspan="7">
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
document.addEventListener('DOMContentLoaded', function () {
    var uploadModal = document.getElementById('uploadModal');
    uploadModal.addEventListener('show.bs.modal', function (event) {
        var button = event.relatedTarget;
        var eventId = button.getAttribute('data-id');

        var eventInput = document.getElementById('event_id');
        var uploadSection = document.getElementById('uploadSection');
        var submitButton = document.getElementById('submitButton');
        if (eventInput) {
            eventInput.value = eventId;
        }else {
            console.error('Hidden input with ID "event_id" not found.');
        }
    });
});
    </script>

@endsection

