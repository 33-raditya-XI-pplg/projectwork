@extends('layouts.panel.index')
@section('title', 'Laporan Perkembangan')
@section('content')

    <div class="container mt-4">
        <div class="bg-white rounded-4 px-3 py-4 mb-3 shadow-lg">
            <div class="card-title mb-3 fw-semibold" style="font-size:18px">Pilih Event & Skema</div>

            <div class="d-flex flex-row mx-2">
                <div class="card-header me-2 w-100 mx-1">
                    <select id="event_select" name="event_select" class=" form-control js-example-basic-single"
                        data-placeholder="Pilih Event">
                        <option hidden disabled selected> </option>
                        @foreach ($events as $event)

                            <option value="{{ $event->id_event }}">{{ $event->nama_event }}</option>

                        @endforeach
                    </select>
                </div>
                <div class="card-header me-2 w-100 mx-1">
                    <select id="skema_select" name="skema_select" class="form-control js-example-basic-single"
                        data-placeholder="Pilih Event Dahulu">
                        <option hidden disabled selected></option>
                    </select>
                </div>
                <button id="search_btn" class="btn btn-secondary rounded-3 w-25 mx-1" disabled>Submit</button>
            </div>
        </div>
    </div>

    <div class="container mt-2">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                tabindex="0">
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
                                            <input type="text" class="form-control" id="nama_event" placeholder="kosong"
                                                disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nama_skema" class="form-label">Nama Skema</label>
                                            <input type="text" class="form-control" id="nama_skema" placeholder="kosong"
                                                disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                                            <input type="text" class="form-control" id="tgl_mulai"
                                                placeholder="dd-mm-yyyy" disabled>
                                        </div>
                                        {{-- <div class="form-check form-switch mt-3">
                                            <label class="form-check-label" for="status">Status</label>
                                            <input class="form-check-input" type="checkbox" id="status" disabled>
                                        </div> --}}
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="jenis_event" class="form-label">Jenis Event</label>
                                            <input type="text" class="form-control" id="jenis_event" placeholder="kosong"
                                                disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tempat_skema" class="form-label">TUK</label>
                                            <input type="text" class="form-control" id="tempat_skema"
                                                placeholder="kosong" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                                            <input type="text" class="form-control" id="tgl_selesai"
                                                placeholder="dd-mm-yyyy" disabled>
                                        </div>
                                        {{-- <div class="mb-3">
                                            <label for="list_penguji" class="form-label">Daftar Penguji</label>
                                            <ol id="list_penguji" class="list-group list-group-numbered">
                                                <!-- List Penguji Here -->
                                            </ol>
                                            <div id="buttonGroup">
                                                <a href="#" id="btnSelengkapnya" class="text-primary mt-2"
                                                    style="display: none;">Tampilkan Banyak</a>
                                                <a href="#" id="btnSedikit" class="text-primary mt-2"
                                                    style="display: none;">Tampilkan Sedikit</a>
                                            </div> --}}
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
                                <th scope="col" class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody style="vertical-align: middle">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Create -- Laporan Modal -->
    <div class="modal fade" id="createLaporanModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
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
                        <input type="hidden" id="peserta_id" value="">
                        <input type="hidden" id="event_skema_id" name="event_skema_id" value="">
                    </div>
                    <div>
                        <label class="form-label" for="pengalaman_anak">Keterangan Singkat</label>
                        <textarea class="form-control " name="pengalaman_anak" id="pengalaman_anak" rows="2"></textarea>
                    </div>
                    <div class="form-group kemampuan-wrapper-create mb-3 mt-3">
                        <div class="d-flex justify-content-between">
                            <label class="form-label">Kemampuan Dasar</label>
                            <button type="button" class="btn btn-primary btn-sm rounded mb-2"
                                id="addKemampuanCreate">Tambah kemampuan Dasar</button>
                        </div>

                        <div id="empty-input-message" class="alert alert-info" role="alert" style="display: show;">
                            <h6 class="mx-3 mt-2">Tambah Kemampuan Dasar</h6>
                        </div>

                        <div class="input-group mb-3 kemampuan_dasar-input-create">
                            <!-- Input Dinamis -->
                        </div>
                    </div>
                    <div>
                        <label class="form-label" for="">Peralatan penunjang</label>
                        <textarea class="form-control " name="peralatan_penunjang" id="peralatan_penunjang" rows="2"></textarea>
                    </div>
                    <div>
                        <label class="form-label" for="">Saran</label>
                        <textarea class="form-control " name="saran" id="saran" rows="2"></textarea>
                    </div>
                    {{-- <div class="mb-3">
                        <label for="create_nama_skema" class="form-label">Skema</label>
                        <input type="text" class="form-control mb-4" id="create_nama_skema">
                    </div>
                    <label for="create_nama_sub_skema" class="form-label">Sub-Skema</label>
                    <div class="form-group" id="create-nilai-sub-skema-wrapper">
                        <div class="input-group mb-3 nilai-sub-skema">
                            <!-- Input dinamis -- Ajax Request -->
                        </div>
                    </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-3 text-white" id="store_laporan_btn"
                        value="1">
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit -- Laporan Modal -->
    <div class="modal fade" id="editLaporanModal" tabindex="-1" aria-labelledby="exampleModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Edit Laporan Perkembangan</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" id="edite_id" value="">
                    <div class="mb-3">
                        <label for="edit_nama_peserta" class="form-label">Nama Peserta</label>
                        <input type="text" class="form-control" id="edit_nama_peserta" readonly disabled>
                    </div>
                    <div>
                        <label class="form-label" for="pengalaman_anak">Keterangan Singkat</label>
                        <textarea class="form-control " name="pengalaman_anak" id="edit_pengalaman_anak" rows="2" hidden></textarea>
                    </div>
                    <div class="form-group kemampuan-wrapper-edit mb-3 mt-3">
                        <div class="d-flex justify-content-between">
                            <label class="form-label">Kemampuan Dasar</label>
                            <button type="button" class="btn btn-primary btn-sm rounded mb-2"
                                id="addKemampuanEdit">Tambah Kemampuan Dasar</button>
                        </div>
                        @if (isset($kemampuan) && !$kemampuan->isEmpty())
                            @foreach ($kemampuan as $row)
                                <div class="row mb-3 kemampuan_dasar-input-edit">
                                    <div class="col-md-7">
                                        <input type="hidden" name="kemampuan_dasar_ids[]"
                                            value="{{ $row->id_kemampuan_dasar }}">
                                        <input type="text" class="form-control"
                                            name="edit_kemampuan_dasar[{{ $row->id_kemampuan_dasar }}]"
                                            value="{{ $row->kemampuan_dasar }}" placeholder="Kemampuan Dasar" required>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control"
                                            name="edit_keterangan[{{ $row->id_kemampuan_dasar }}]" required
                                            style="max-width: 120px; background-color: #d1ecf1;">
                                            <option value="" disabled>Pilih Keterangan</option>
                                            <option value="kurang" {{ $row->keterangan == 'kurang' ? 'selected' : '' }}>
                                                Kurang</option>
                                            <option value="cukup" {{ $row->keterangan == 'cukup' ? 'selected' : '' }}>
                                                Cukup</option>
                                            <option value="baik" {{ $row->keterangan == 'baik' ? 'selected' : '' }}>Baik
                                            </option>
                                            <option value="sangat baik"
                                                {{ $row->keterangan == 'sangat baik' ? 'selected' : '' }}>Sangat Baik
                                            </option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-outline-danger rounded removekemampuan"
                                            type="button">Hapus</button>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <div id="empty-input-message" class="alert alert-info" role="alert"
                                style="display: show;">
                                <h6 class="mx-3 mt-2">Tidak Memiliki Kemampuan Dasar</h6>
                            </div>
                        @endif
                    </div>
                    <div>
                        <label class="form-label" for="">Peralatan penunjang</label>
                        <textarea class="form-control " name="peralatan_penunjang" id="edit_peralatan_penunjang" rows="2" hidden></textarea>
                    </div>
                    <div>
                        <label class="form-label" for="">Saran</label>
                        <textarea class="form-control " name="saran" id="edit_saran" rows="2" hidden></textarea>
                    </div>
                    {{-- <div class="mb-3">
                    <label for="edit_nama_skema" class="form-label">Skema</label>
                    <input type="text" class="form-control mb-4" id="edit_nama_skema">
                </div>
                <label for="edit_nama_sub_skema" class="form-label">Sub-Skema</label>
                <div class="form-group" id="edit-nilai-sub-skema-wrapper">
                    <div class="input-group mb-3 nilai-sub-skema">
                        <!-- Input dinamis -- Ajax Request -->
                    </div>
                </div> --}}
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-3 text-white" id="update_laporan_btn"
                        value="1">Update</button>
                </div>
            </div>
        </div>
    </div>

@endsection
@push('script')
<script>
    $(document).ready(function() {
        // ================== 1. INISIALISASI PLUGIN ==================
        $('.js-example-basic-single').select2({
            theme: "bootstrap-5"
        });

        $('.js-example-basic-single').on('select2:open', function(e) {
            const elementId = $(this).attr('id');
            let placeholderText = 'Cari...';
            if (elementId === 'event_select') {
                placeholderText = 'Cari Event...';
            } else if (elementId === 'skema_select') {
                placeholderText = 'Cari Skema...';
            }
            $('.select2-search__field').attr('placeholder', placeholderText);
        });

        // Inisialisasi CKEditor (akan dibuat saat modal terbuka)
        let editors = {};
        const fieldsToInitialize = ['pengalaman_anak', 'peralatan_penunjang', 'saran', 'edit_pengalaman_anak', 'edit_peralatan_penunjang', 'edit_saran'];

        // ================== DEKLARASI VARIABEL ==================
        var skemaID, eventID, pesertaID;

        // ================== FUNGSI-FUNGSI HELPER ==================
        function formatDate(dateString) {
            if (!dateString) return '-';
            var dateParts = dateString.split("-");
            var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            return dateParts[2] + ' ' + months[parseInt(dateParts[1]) - 1] + ' ' + dateParts[0];
        }

        function initializeEditors(ids) {
            ids.forEach(id => {
                if (editors[id]) {
                    editors[id].destroy().catch(err => console.error(err));
                    delete editors[id];
                }
                ClassicEditor.create(document.querySelector(`#${id}`))
                    .then(editor => { editors[id] = editor; })
                    .catch(error => { console.error(`Error initializing editor for #${id}:`, error); });
            });
        }

        // ================== FUNGSI UTAMA (FETCH DATA & RENDER) ==================
        function fetchDetailData(selectedSkemaID, selectedEventID) {
            Swal.fire({
                title: 'Memuat Detail...', text: 'Sedang memproses data!',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            $.ajax({
                url: `/laporanperkembangan/fetchSkemaData/${selectedSkemaID}/${selectedEventID}`,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (!response) {
                        Swal.fire('Error', 'Tidak ada respons dari server.', 'error');
                        return;
                    }

                    const { data_skema, data_penguji, data_peserta } = response;

                    $('#nama_event').val(data_skema.nama_event);
                    $('#jenis_event').val(data_skema.nama_jenis_event);
                    $('#nama_skema').val(data_skema.nama_skema);
                    $('#tempat_skema').val(data_skema.nama_tempat);
                    $('#tgl_mulai').val(formatDate(data_skema.tgl_mulai));
                    $('#tgl_selesai').val(formatDate(data_skema.tgl_berakhir));

                    const listPenguji = $('#list_penguji'), btnSelengkapnya = $('#btnSelengkapnya'), btnSedikit = $('#btnSedikit');
                    function renderPenguji(pengujiArray) {
                        listPenguji.html('');
                        pengujiArray.forEach(penguji => listPenguji.append(`<li class="list-group-item">${penguji.nama_lengkap}</li>`));
                    }
                    if (data_penguji && data_penguji.event_skema_menguji) {
                        const semuaPenguji = data_penguji.event_skema_menguji;
                        renderPenguji(semuaPenguji.slice(0, 2));
                        (semuaPenguji.length > 2) ? btnSelengkapnya.show() : btnSelengkapnya.hide();
                        btnSedikit.hide();
                    }
                    btnSelengkapnya.off('click').on('click', e => { e.preventDefault(); renderPenguji(data_penguji.event_skema_menguji); btnSelengkapnya.hide(); btnSedikit.show(); });
                    btnSedikit.off('click').on('click', e => { e.preventDefault(); renderPenguji(data_penguji.event_skema_menguji.slice(0, 2)); btnSedikit.hide(); btnSelengkapnya.show(); });

                    if ($.fn.DataTable.isDataTable('#example')) {
                        $('#example').DataTable().destroy();
                    }
                    let tableBody = $('#example tbody');
                    tableBody.html("");

                    $.each(data_peserta, function(index, row) {
                        var num = index + 1;
                        var buttonAction = `<a href="/admin/laporanperkembangan/${row.id_peserta}/tambah" class="btn btn-info btn-sm rounded text-white mb-3" data-id="${row.id_peserta}"><i class="fa-regular fa-pen-to-square"></i> Tambah</a>`;
                        tableBody.append(`<tr><td>${num}</td><td>${row.nama_lengkap || 'Nama tidak tersedia'}</td><td>${buttonAction}</td></tr>`);
                    });

                    $("#example").DataTable();
                    Swal.close();
                },
                error: function() {
                    Swal.fire('Gagal', 'Tidak dapat mengambil data dari server!', 'error');
                }
            });
        }

        // ================== EVENT HANDLERS ==================
        $('#event_select').on('change', function() {
            eventID = $(this).val();
            $('#search_btn').prop('disabled', true);
            $('#skema_select').prop('disabled', true).empty().append('<option></option>').trigger('change');

            if (eventID) {
                Swal.fire({ title: 'Memuat Skema...', allowOutsideClick: false, didOpen: () => { Swal.showLoading(); } });
                $.ajax({
                    url: `/laporanperkembangan/fetchEventData/${eventID}`,
                    type: "GET", dataType: "json",
                    success: function(response) {
                        if (response && response.data) {
                            $.each(response.data, function(key, row) { $('#skema_select').append(`<option value="${row.id_skema}">${row.nama_skema}</option>`); });
                        }
                        $('#skema_select').prop('disabled', false).trigger('change');
                        Swal.close();
                    },
                    error: function() { Swal.fire('Error', 'Gagal memuat data skema.', 'error'); }
                });
            }
        });

        $('#skema_select').on('change', function() {
            skemaID = $(this).val();
            $('#search_btn').prop('disabled', !skemaID);
        });

        $('#search_btn').on('click', function() {
            if (skemaID && eventID) {
                fetchDetailData(skemaID, eventID);
            } else {
                Swal.fire('Peringatan', 'Silakan pilih event dan skema terlebih dahulu!', 'warning');
            }
        });

        // Event handler untuk modal dan logika lainnya akan ditambahkan di sini...
        // ... (Logika untuk create, store, edit, update, delete modal Anda)

    });
</script>
@endpush
