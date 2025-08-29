    @extends('layouts.panel.index')
    @section('title', 'Penilaian')
    @section('content')


        <div class="container mt-4">
            <div class="bg-white rounded-4 px-3 py-4 mb-3 shadow-lg">
                <div class="card-title mb-3 fw-semibold" style="font-size:18px">Pilih Event & Skema</div>

                <div class="d-flex flex-row mx-2">
                    <div class="card-header me-2 w-100 mx-1">
                        <select id="event_select" name="event_select" class=" form-control js-example-basic-single"
                            data-placeholder="Pilih Event">
                            <option hidden disabled selected></option>
                            @foreach ($event as $row)
                                <option value="{{ $row->id_event }}">{{ $row->nama_event }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="card-header me-2 w-100 mx-1">
                        <select id="skema_select" name="skema_select" class=" form-control js-example-basic-single"
                            data-placeholder="Pilih Event Dahulu">
                            <option hidden disabled selected> </option>
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
                                            <div class="form-check form-switch mt-3">
                                                <label class="form-check-label" for="status">Status</label>
                                                <input class="form-check-input" type="checkbox" id="status" disabled>
                                            </div>
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
                                            <div class="mb-3">
                                                <label for="list_penguji" class="form-label">Daftar Penguji</label>
                                                <ol id="list_penguji" class="list-group list-group-numbered">
                                                    <!-- List Penguji Here -->
                                                </ol>

                                                <div id="buttonGroup">
                                                    <a href="#" id="btnSelengkapnya" class="text-primary mt-2"
                                                        style="display: none;">Tampilkan Banyak</a>
                                                    <a href="#" id="btnSedikit" class="text-primary mt-2"
                                                        style="display: none;">Tampilkan Sedikit</a>
                                                </div>
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
                            <th scope="col">No</th>
                            <th scope="col">Nama Perserta</th>
                            <th scope="col">Status Nilai</th>
                            <th scope="col">Nilai Peserta
                                <span style="color: grey; font-size: 15px;">avg</span>
                            </th>
                            <th scope="col">Keterangan</th>
                            <th scope="col">Tanggal</th>
                            <th scope="col" class="text-center">Aksi</th>
                        </thead>
                        <tbody style="vertical-align: middle">
                            <!-- AJAX Response Here -->
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
        </div>

        <!-- Create -- Nilai Modal -->
        <div class="modal fade" id="createNilaiModal" tabindex="-1" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog modal-lg"> <!-- Modal Large -->
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Tambah Nilai Peserta</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <input type="hidden" id="created_by" value="{{ Auth::user()->id_user }}">
                        <div class="mb-3">
                            <label for="create_nama_peserta" class="form-label">Nama Peserta</label>
                            <input type="text" class="form-control" id="create_nama_peserta" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="create_nama_skema" class="form-label">Skema</label>
                            <input type="text" class="form-control mb-4" id="create_nama_skema" disabled>
                        </div>
                        <label for="create_nama_sub_skema" class="form-label">Sub-Skema</label>
                        <div class="form-group" id="nilai-sub-skema-wrapper">
                            <div class="input-group mb-3 nilai-sub-skema">
                                <!-- Input dinamis -- Ajax Request -->
                            </div>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success rounded-3 text-white" id="store_nilai_btn"
                            value="1">Tambah</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Edit -- Nilai Modal -->
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
                        <button type="submit" class="btn btn-success rounded-3 text-white" id="store_nilai_btn"
                            value="0">Simpan</button>
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

            // ================== DEKLARASI VARIABEL ==================
            var skemaID;
            var eventID;
            var pesertaID;
            var event_skemaID; // Pastikan ini juga dideklarasikan
            var data_nilai_peserta;
            var data_skema;
            var data_sub_skema;
            var data_penguji;

            // ================== FUNGSI-FUNGSI HELPER ==================
            function formatNumber(value) {
                var num = parseFloat(value);
                if (isNaN(num)) return '0';
                var fixedValue = num.toFixed(1);
                return fixedValue.endsWith('.0') ? parseInt(fixedValue) : fixedValue;
            }

            function confirmDelete(title, text) {
                return Swal.fire({
                    title: title, text: text, icon: 'warning',
                    showCancelButton: true, confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal'
                });
            }

            function formatDate(dateString) {
                if (!dateString) return '-';
                var dateParts = dateString.split("-");
                var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
                return dateParts[2] + ' ' + months[parseInt(dateParts[1]) - 1] + ' ' + dateParts[0];
            }

            function formatTimestamps(dateString) {
                if (!dateString) return '-';
                let dateOnly = new Date(dateString).toISOString().slice(0, 10);
                return formatDate(dateOnly);
            }

            // ================== FUNGSI UTAMA (FETCH DATA & RENDER) ==================
            function fetchDetailData(selectedSkemaID) {
                Swal.fire({
                    title: 'Memuat Detail...', text: 'Sedang memproses data!',
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                $.ajax({
                    url: `/penilaian/fetchSkemaData/${selectedSkemaID}/${eventID}`,
                    type: "GET",
                    dataType: "json",
                    success: function(response) {
                        if (!response) {
                            Swal.fire('Error', 'Tidak ada respons dari server.', 'error');
                            return;
                        }

                        data_skema = response.data_skema;
                        data_penguji = response.data_penguji;
                        data_sub_skema = response.data_sub_skema;
                        data_nilai_peserta = response.data_nilai_peserta;

                        $('#nama_event').val(data_skema.nama_event);
                        $('#jenis_event').val(data_skema.nama_jenis_event);
                        $('#nama_skema').val(data_skema.nama_skema);
                        $('#tempat_skema').val(data_skema.nama_tempat);
                        $('#tgl_mulai').val(formatDate(data_skema.tgl_mulai));
                        $('#tgl_selesai').val(formatDate(data_skema.tgl_berakhir));
                        $('#status').prop('checked', data_skema.status === "Aktif");

                        const listPenguji = $('#list_penguji'), btnSelengkapnya = $('#btnSelengkapnya'), btnSedikit = $('#btnSedikit');
                        function renderPenguji(pengujiArray) {
                            listPenguji.html('');
                            pengujiArray.forEach(penguji => listPenguji.append(`<li class="list-group-item">${penguji.nama_lengkap}</li>`));
                        }

                        if (data_penguji && data_penguji.event_skema_menguji) {
                            const semuaPenguji = data_penguji.event_skema_menguji;
                            renderPenguji(semuaPenguji.slice(0, 2));
                            if (semuaPenguji.length > 2) { btnSelengkapnya.show(); btnSedikit.hide(); }
                            else { btnSelengkapnya.hide(); btnSedikit.hide(); }
                        }
                        btnSelengkapnya.off('click').on('click', e => { e.preventDefault(); renderPenguji(data_penguji.event_skema_menguji); btnSelengkapnya.hide(); btnSedikit.show(); });
                        btnSedikit.off('click').on('click', e => { e.preventDefault(); renderPenguji(data_penguji.event_skema_menguji.slice(0, 2)); btnSedikit.hide(); btnSelengkapnya.show(); });

                        if ($.fn.DataTable.isDataTable('#example')) {
                            $('#example').DataTable().destroy();
                        }
                        $('#example tbody').html("");

                        $.each(data_nilai_peserta, function(index, row) {
                            event_skemaID = row.id_event_skema;
                            var num = index + 1, buttonAction;
                            if (row.banyak_nilai != null) {
                                buttonAction = `<button type="button" class="btn btn-info btn-sm edit_nilai_btn me-1 text-white rounded mb-1" data-id="${row.id_peserta}"><i class="fa-regular fa-pen-to-square"></i> Edit</button> <button type="button" class="btn btn-danger btn-sm delete_nilai_btn rounded mb-1" data-id="${row.id_peserta}"><i class="fa-regular fa-trash-can"></i> Delete</button>`;
                            } else {
                                buttonAction = `<button type="button" class="btn btn-primary btn-sm create_nilai_btn rounded" data-id="${row.id_peserta}"><i class="fa-regular fa-pen-to-square"></i> Tambah</button>`;
                            }
                            var banyakData, nilaiData, inisialNilaiData, timestampsNilaiData;
                            if (row.banyak_nilai_nol == 0) {
                                banyakData = 'Nilai Lengkap';
                                nilaiData = formatNumber(row.avg_nilai);
                                let color = (row.keterangan_rentang_nilai.includes("Kompeten")) ? 'green' : 'red';
                                inisialNilaiData = `<span style="color: ${color}; font-weight: bold;">${row.keterangan_rentang_nilai}</span>`;
                                timestampsNilaiData = formatTimestamps(row.updated_at || row.created_at);
                            } else if (row.banyak_nilai_nol == null) {
                                banyakData = '-'; nilaiData = '-'; inisialNilaiData = '-'; timestampsNilaiData = '-';
                            } else {
                                banyakData = `<span style="color: red; font-weight: bold;">Nilai kurang = ${row.banyak_nilai_nol}</span>`;
                                nilaiData = `<span style="color: red; font-weight: bold;">${formatNumber(row.avg_nilai)}</span>`;
                                inisialNilaiData = '<span style="color: red; font-weight: bold;">Nilai Kurang</span>';
                                timestampsNilaiData = `<span style="color: red; font-weight: bold;">${formatTimestamps(row.updated_at || row.created_at)}</span>`;
                            }
                            $('#example tbody').append(`<tr><td>${num}</td><td>${row.nama_lengkap}</td><td>${banyakData}</td><td>${nilaiData}</td><td>${inisialNilaiData}</td><td>${timestampsNilaiData}</td><td class="text-center">${buttonAction}</td></tr>`);
                        });
                        $("#example").DataTable();
                        Swal.close();
                    },
                    error: function() {
                        Swal.fire({ icon: 'error', title: 'Gagal Memuat Data', text: 'Tidak dapat mengambil data dari server!' });
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
                        url: `/penilaian/fetchEventData/${eventID}`,
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
                if (skemaID && eventID) { fetchDetailData(skemaID); }
                else { Swal.fire('Peringatan', 'Silakan pilih event dan skema terlebih dahulu!', 'warning'); }
            });

            $(document).on('click', '.create_nilai_btn', function(e) {
                e.preventDefault();
                pesertaID = $(this).data('id');
                $.ajax({
                    url: `/penilaian/fetchPesertaData/${pesertaID}`, type: "GET", dataType: "json",
                    success: function(response) {
                        $('#create_nama_peserta').val(response.data_peserta.nama_lengkap);
                        $('#create_nama_skema').val(data_skema.nama_skema);
                        $('#nilai-sub-skema-wrapper').html("");
                        $.each(data_sub_skema, (index, row) => $('#nilai-sub-skema-wrapper').append(`<div class="px-1 mb-3 row"><label class="col-sm-8 col-form-label fs-6">${row.judul_sub}</label><div class="col-sm-4 d-flex justify-content-end"><label class="text-white center bg-secondary rounded-start px-4 py-1" style="height: 35px;">Nilai</label><input type="hidden" class="create_id_sub_skema" value="${row.id_sub_skema}"><input type="number" class="form-control rounded-0 rounded-end create_nilai_sub_skema" style="width: 100px; height: 35px;"></div></div>`));
                        $('#createNilaiModal').modal('show');
                    }
                });
            });

            $(document).on('click', '.edit_nilai_btn', function(e) {
                e.preventDefault();
                pesertaID = $(this).data('id');
                $.ajax({
                    url: `/penilaian/fetchNilaiData/${pesertaID}`, type: "GET", dataType: "json",
                    success: function(response) {
                        var data_peserta_edit = response.data_nilai;
                        $('#edit_nama_peserta').val(data_peserta_edit[0].nama_lengkap);
                        $('#edit_nama_skema').val(data_skema.nama_skema);
                        $('#edit-nilai-sub-skema-wrapper').html("");
                        $.each(data_peserta_edit, (index, row) => $('#edit-nilai-sub-skema-wrapper').append(`<div class="px-1 mb-3 row"><label class="col-sm-8 col-form-label fs-6">${row.judul_sub}</label><div class="col-sm-4 d-flex justify-content-end"><label class="text-white center bg-secondary rounded-start px-4 py-1" style="height: 35px;">Nilai</label><input type="hidden" class="edit_id_sub_skema" value="${row.sub_skema_id}"><input type="number" class="form-control rounded-0 rounded-end edit_nilai_sub_skema" style="width: 100px; height: 35px;" value="${row.nilai}"></div></div>`));
                        $('#editNilaiModal').modal('show');
                    }
                });
            });

            $(document).on('click', '#store_nilai_btn', function() {
                var btnIdentifier = $(this).val();
                var createdBy = $('#created_by').val();
                var subSkemaSelector = (btnIdentifier != 0) ? '.create_id_sub_skema' : '.edit_id_sub_skema';
                var nilaiSelector = (btnIdentifier != 0) ? '.create_nilai_sub_skema' : '.edit_nilai_sub_skema';
                
                var nilaiSubSkemaArray = {};
                $(subSkemaSelector).each(function(index) {
                    var sub_skema_id = $(this).val();
                    var nilai = $(nilaiSelector).eq(index).val();
                    nilaiSubSkemaArray[sub_skema_id] = (nilai === "" || nilai == null) ? null : nilai;
                });

                $.ajax({
                    url: '/penilaian/storeNilaiData', type: 'POST',
                    headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                    data: { pesertaID: pesertaID, event_skemaID: event_skemaID, nilaiSubSkema: nilaiSubSkemaArray, createdBy: createdBy },
                    success: function() {
                        $('#createNilaiModal').modal('hide');
                        $('#editNilaiModal').modal('hide');
                        Swal.fire('Berhasil', 'Nilai berhasil disimpan.', 'success');
                        fetchDetailData(skemaID);
                    },
                    error: function(xhr) {
                        Swal.fire('Gagal', xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi Error', 'error');
                    }
                });
            });

            $(document).on('click', '.delete_nilai_btn', function(e) {
                e.preventDefault();
                pesertaID = $(this).data('id');
                confirmDelete('Hapus Nilai Peserta', 'Apakah Anda yakin ingin menghapus nilai peserta ini?').then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: `/penilaian/destroyNilaiData/${pesertaID}`, type: 'DELETE',
                            headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                            success: function() {
                                Swal.fire('Berhasil', 'Nilai peserta berhasil dihapus.', 'success');
                                fetchDetailData(skemaID);
                            },
                            error: function() { Swal.fire('Gagal', 'Terjadi kesalahan saat menghapus nilai.', 'error'); }
                        });
                    }
                });
            });
        });
    </script>
    @endpush
