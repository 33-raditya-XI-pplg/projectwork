@extends('layouts.panel.index')
@section('title', 'Laporan Perkembangan')
@section('content')

<div class="container mt-4">
    <div class="bg-white rounded-4 px-3 py-4 mb-3 shadow-lg">
        <div class="card-title mb-3 fw-semibold" style="font-size:18px">Pilih Event & Skema</div>

        <div class="d-flex flex-row mx-2">
            <div class="card-header me-2 w-100 mx-1">
                <select id="event_select" name="event_select" class="chosen-select form-control">
                    <option hidden disabled selected>Pilih Event</option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id }}">{{ $event->nama_event }}</option>
                    @endforeach
                </select>
            </div>
            <div class="card-header me-2 w-100 mx-1">
                <select id="skema_select" name="skema_select" class="chosen-select form-control">
                    <option hidden disabled selected>Pilih Event Dahulu</option>
                </select>
            </div>
            <button id="search_btn" class="btn btn-secondary rounded-3 w-25 mx-1" disabled>Submit</button>
        </div>
    </div>
</div>

<div class="container mt-2"> 
    <div class="tab-content" id="pills-tabContent">
        <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab" tabindex="0">
            <div class="bg-white rounded-4 px-3 py-3 mb-3 shadow-lg">
                <div class="card-title mb-4 fw-semibold" style="font-size:18px">Detail Event</div>
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="row">
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="nama_event" class="form-label">Nama Event</label>
                                        <input type="text" class="form-control" id="nama_event" placeholder="kosong" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="nama_skema" class="form-label">Nama Skema</label>
                                        <input type="text" class="form-control" id="nama_skema" placeholder="kosong" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                                        <input type="text" class="form-control" id="tgl_mulai" placeholder="dd-mm-yyyy" disabled>
                                    </div>
                                    <div class="form-check form-switch mt-3">
                                        <label class="form-check-label" for="status">Status</label>
                                        <input class="form-check-input" type="checkbox" id="status" disabled>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="mb-3">
                                        <label for="jenis_event" class="form-label">Jenis Event</label>
                                        <input type="text" class="form-control" id="jenis_event" placeholder="kosong" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tempat_skema" class="form-label">TUK</label>
                                        <input type="text" class="form-control" id="tempat_skema" placeholder="kosong" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                                        <input type="text" class="form-control" id="tgl_selesai" placeholder="dd-mm-yyyy" disabled>
                                    </div>
                                    <div class="mb-3">
                                        <label for="list_penguji" class="form-label">Daftar Penguji</label>
                                        <ol id="list_penguji" class="list-group list-group-numbered">
                                            <!-- List Penguji Here -->
                                        </ol>
                                        <div id="buttonGroup">
                                            <a href="#" id="btnSelengkapnya" class="text-primary mt-2" style="display: none;">Tampilkan Banyak</a>
                                            <a href="#" id="btnSedikit" class="text-primary mt-2" style="display: none;">Tampilkan Sedikit</a>
                                        </div>
                                    </div>
                                </div>
                            </div>              
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-4 px-3 py-3 mb-3 shadow-lg">
                <table id="example" class="table">
                    <thead class="fw-normal">
                        <tr>
                            <th scope="col">No</th>
                            <th scope="col">Nama Peserta</th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody style="vertical-align: middle">
                        <!-- AJAX Response Here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- Create -- Laporan Modal -->
<div class="modal fade" id="createLaporanModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg"> <!-- Modal Large -->
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Tambah Laporan Perkembangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="created_by" value="{{ Auth::user()->id }}">
                <div class="mb-3">
                    <label for="create_nama_peserta" class="form-label">Nama Peserta</label>
                    <input type="text" class="form-control" id="create_nama_peserta">
                </div>
                <div class="mb-3">
                    <label for="create_nama_skema" class="form-label">Skema</label>
                    <input type="text" class="form-control mb-4" id="create_nama_skema">
                </div>
                <label for="create_nama_sub_skema" class="form-label">Sub-Skema</label>
                <div class="form-group" id="create-nilai-sub-skema-wrapper">
                    <div class="input-group mb-3 nilai-sub-skema">
                        <!-- Input dinamis -- Ajax Request -->
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success rounded-3 text-white" id="store_laporan_btn" value="1">Tambah</button>
            </div>
        </div>
    </div>
</div>

<!-- Edit -- Laporan Modal -->
<div class="modal fade" id="editLaporanModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Laporan Perkembangan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" id="edit_id">
                <div class="mb-3">
                    <label for="edit_nama_peserta" class="form-label">Nama Peserta</label>
                    <input type="text" class="form-control" id="edit_nama_peserta">
                </div>
                <div class="mb-3">
                    <label for="edit_nama_skema" class="form-label">Skema</label>
                    <input type="text" class="form-control mb-4" id="edit_nama_skema">
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
                <button type="submit" class="btn btn-success rounded-3 text-white" id="update_laporan_btn" value="1">Update</button>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
    // AJAX untuk mengambil data skema saat event dipilih
    $('#event').on('change', function () {
        var eventId = $(this).val();
        if (eventId) {
            $.get(`/admin/laporan-perkembangan/fetch-skema-data/${eventId}`, function (data) {
                $('#skema').empty().append('<option value="">-- Pilih Skema --</option>');
                $.each(data, function (key, value) {
                    $('#skema').append(`<option value="${value.id}">${value.nama_skema}</option>`);
                });

                // Memuat pengguna yang mengikuti event
                loadUsers(eventId, $('#skema').val());
            });
        }
    });

    // AJAX untuk mengambil data laporan berdasarkan skema yang dipilih
    $('#skema').on('change', function () {  
        var skemaId = $(this).val();
        var eventId = $('#event').val();
        if (skemaId && eventId) {
            $.get(`/admin/laporan-perkembangan/fetch-laporan-data/${skemaId}`, function (data) {
                var rows = '';
                $.each(data, function (index, laporan) {
                    rows += `<tr>
                                <td>${index + 1}</td>
                                <td>${laporan.nama_peserta}</td>
                                <td>${laporan.event.nama_event}</td>
                                <td>${laporan.skema.nama_skema}</td>
                                <td>${laporan.tanggal_penilaian}</td>
                                <td>
                                    <button class="btn btn-warning edit-laporan" data-id="${laporan.id}">Edit</button>
                                    <button class="btn btn-danger delete-laporan" data-id="${laporan.id}">Delete</button>
                                </td>
                             </tr>`;
                });
                $('#laporan-perkembangan-table tbody').html(rows);

                // Memuat pengguna yang mengikuti event dan skema
                loadUsers(eventId, skemaId);
            });
        }
    });

    // Fungsi untuk memuat daftar pengguna yang mengikuti event dan skema
    function loadUsers(eventId, skemaId) {
        if (eventId && skemaId) {
            $.get(`/admin/laporan-perkembangan/fetch-users/${eventId}/${skemaId}`, function (data) {
                $('#user-list').empty();
                $.each(data, function (key, user) {
                    $('#user-list').append(`<li class="list-group-item">${user.name}</li>`);
                });
            });
        } else {
            $('#user-list').empty();
        }
    }

    // Tambah Laporan (Modal)
    $('#btn-tambah-laporan').on('click', function () {
        $('#laporan-form')[0].reset();
        $('#laporan-id').val('');
        $('#laporanModalLabel').text('Tambah Laporan Perkembangan');
    });

    // Simpan Laporan
    $('#laporan-form').on('submit', function (e) {
        e.preventDefault();
        var id = $('#laporan-id').val();
        var url = id ? `/admin/laporan-perkembangan/update/${id}` : '/admin/laporan-perkembangan/store';
        var method = id ? 'PUT' : 'POST';
        var formData = {
            nama_peserta: $('#nama_peserta').val(),
            tanggal_penilaian: $('#tanggal_penilaian').val(),
            event_id: $('#event').val(),
            skema_id: $('#skema').val(),
        };

        $.ajax({
            url: url,
            type: method,
            data: formData,
            success: function (response) {
                $('#laporanModal').modal('hide');
                // Reload tabel setelah simpan data
                $('#skema').trigger('change');
            },
            error: function (error) {
                console.log(error);
                alert('Gagal menyimpan data!');
            }
        });
    });

    // Edit Laporan
    $(document).on('click', '.edit-laporan', function () {
        var id = $(this).data('id');
        $.get(`/admin/laporan-perkembangan/edit/${id}`, function (data) {
            $('#laporanModal').modal('show');
            $('#laporan-id').val(data.id);
            $('#nama_peserta').val(data.nama_peserta);
            $('#tanggal_penilaian').val(data.tanggal_penilaian);
            $('#laporanModalLabel').text('Edit Laporan Perkembangan');
        });
    });

    // Delete Laporan
    $(document).on('click', '.delete-laporan', function () {
        if (confirm('Yakin ingin menghapus laporan ini?')) {
            var id = $(this).data('id');
            $.ajax({
                url: `/admin/laporan-perkembangan/destroy/${id}`,
                type: 'DELETE',
                success: function (response) {
                    // Reload tabel setelah hapus data
                    $('#skema').trigger('change');
                },
                error: function (error) {
                    console.log(error);
                    alert('Gagal menghapus data!');
                }
            });
        }
    });
</script>
@endsection
