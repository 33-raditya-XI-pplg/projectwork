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
    var skemaID; // ID skema yang dipilih dari dropdown
    var eventID; // ID event yang dipilih dari dropdown
    var event_skemaID; // ID dari tabel event_skema (relasi antara event dan skema)
    var pesertaID;

    var data_laporan_perkembangan;
    var data_skema;
    var data_sub_skema;

    // CKEditor instances
    const fieldsToInitialize = ['edit_pengalaman_anak', 'edit_peralatan_penunjang', 'edit_saran'];
    let editors = {};

    // round Nilai function
    function formatNumber(value) {
        var num = parseFloat(value);
        if (isNaN(num)) {
            return '0';
        }
        var fixedValue = num.toFixed(1);
        return fixedValue.endsWith('.0') ? parseInt(fixedValue) : fixedValue;
    }

    // delete Sweet Alert function
    function confirmDelete(title, text) {
        return Swal.fire({
            title: title,
            text: text,
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Ya, hapus',
            cancelButtonText: 'Batal'
        });
    }

    // format Date function
    function formatDate(dateString) {
        var dateParts = dateString.split("-");
        var year = dateParts[0];
        var month = dateParts[1];
        var day = dateParts[2];

        var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        return day + ' ' + months[parseInt(month) - 1] + ' ' + year;
    }

    function checkEmptyInput(context) {
        var inputs = $(context).find('.kemampuan_dasar-input-create .kemampuan_dasar-input-edit');
        if (inputs.length === 0) {
            $(context).find('#empty-input-message').show();
        } else {
            $(context).find('#empty-input-message').hide();
        }
    }

    // PERBAIKAN: Fungsi fetchDetailData yang menggunakan skemaID dan eventID yang benar
    function fetchDetailData(selectedSkemaID, selectedEventID) {
        // Validasi parameter
        if (!selectedSkemaID || !selectedEventID) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Skema ID atau Event ID tidak valid!'
            });
            return;
        }

        Swal.fire({
            title: 'Memuat...',
            text: 'Sedang Memproses!',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // PERBAIKAN: Menggunakan selectedSkemaID dan selectedEventID
        $.ajax({
            url: '/laporanperkembangan/fetchSkemaData/' + selectedSkemaID + '/' + selectedEventID,
            type: "GET",
            dataType: "json",
            success: function(response) {
                console.log("Response from server: ", response);

                Swal.close();
                if (response) {
                    data_skema = response.data_skema;
                    data_penguji = response.data_penguji;
                    data_sub_skema = response.data_sub_skema;
                    data_peserta = response.data_peserta;
                    data_laporan_perkembangan = response.data_laporan_perkembangan;

                    var data_jumlah_sub_skema = response.jumlahSubSkemaPerEvent;

                    // Input Disabled
                    $('#nama_event').val(data_skema.nama_event);
                    $('#jenis_event').val(data_skema.nama_jenis_event);
                    $('#nama_skema').val(data_skema.nama_skema);
                    $('#tempat_skema').val(data_skema.nama_tempat);
                    $('#tgl_mulai').val(formatDate(data_skema.tgl_mulai));
                    $('#tgl_selesai').val(formatDate(data_skema.tgl_berakhir));

                    // Logic untuk penguji
                    var listPenguji = document.getElementById('list_penguji');
                    var btnSelengkapnya = document.getElementById('btnSelengkapnya');
                    var btnSedikit = document.getElementById('btnSedikit');

                    function renderPenguji(names) {
                        listPenguji.innerHTML = '';
                        names.forEach(function(name) {
                            var listItem = document.createElement('li');
                            listItem.textContent = name;
                            listItem.classList.add('list-group-item');
                            listPenguji.appendChild(listItem);
                        });
                    }

                    var initialPenguji = data_penguji.event_skema_menguji.slice(0, 2).map(
                        function(penguji) {
                            return penguji.nama_lengkap;
                        });
                    renderPenguji(initialPenguji);

                    if (data_penguji.event_skema_menguji.length <= 2) {
                        btnSelengkapnya.style.display = 'none';
                    } else {
                        btnSelengkapnya.style.display = '';
                    }

                    btnSelengkapnya.addEventListener('click', function(event) {
                        event.preventDefault();
                        var allPenguji = data_penguji.event_skema_menguji.map(function(penguji) {
                            return penguji.nama_lengkap;
                        });
                        renderPenguji(allPenguji);
                        btnSelengkapnya.style.display = 'none';
                        btnSedikit.style.display = 'inline';
                    });

                    btnSedikit.addEventListener('click', function(event) {
                        event.preventDefault();
                        var initialPenguji = data_penguji.event_skema_menguji.slice(0, 2).map(
                            function(penguji) {
                                return penguji.nama_lengkap;
                            });
                        renderPenguji(initialPenguji);
                        btnSedikit.style.display = 'none';
                        btnSelengkapnya.style.display = 'inline';
                    });

                    if (data_skema.status === "Aktif") {
                        $('#status').prop('checked', true);
                    } else {
                        $('#status').prop('checked', false);
                    }

                    // Table daftar peserta
                    $('#example').DataTable().destroy();
                    $('tbody').html("");
                    $('#dropdown-menu').html("");

                    // Buat objek penampung untuk peserta unik berdasarkan id_peserta
                    let uniquePeserta = {};

                    $.each(data_peserta, function(index, row) {
                        uniquePeserta[row.id_peserta] = row;
                    });

                    // Convert kembali ke array untuk digunakan dalam $.each
                    let filteredPeserta = Object.values(uniquePeserta);

                    // Tampilkan data ke tabel
                    $.each(filteredPeserta, function(index, row) {
                        var num = index + 1;
                        var buttonAction = '';

                        if (row.catatan) {
                            buttonAction =
                                '<a href="/admin/laporanperkembangan/' + row.id_peserta + '/tambah" class="btn btn-info btn-sm rounded text-white mb-3" data-id="' + row.id_peserta + '">' +
                                '<i class="fa-regular fa-pen-to-square"></i> Tambah' +
                                '</a>';
                        } else {
                            buttonAction =
                                '<a href="/admin/laporanperkembangan/' + row.id_peserta + '/tambah" class="btn btn-info btn-sm rounded text-white mb-3" data-id="' + row.id_peserta + '">' +
                                '<i class="fa-regular fa-pen-to-square"></i> Tambah' +
                                '</a>';
                        }

                        $('tbody').append(
                            '<tr>\
                                <td>' + num + '</td>\
                                <td>' + (row.nama_lengkap || 'Nama tidak tersedia') + '</td>\
                                <td>\
                                    <div class="d-flex flex-column gap-2 px-3 ">' + buttonAction + '</div>\
                                </td>\
                            </tr>'
                        );
                    });

                    $("#example").DataTable();

                }
            },
            error: function() {
                Swal.close();
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal memuat data',
                    text: 'Tidak dapat mengambil data dari server!'
                });
            }
        });
    }

    // Event Dropdown
    $('#event_select').on('change', function() {
        eventID = $(this).val(); // Set eventID dari dropdown
        console.log('Selected eventID:', eventID);

        $('#search_btn').prop('disabled', true);

        if (eventID) {
            $.ajax({
                url: '/laporanperkembangan/fetchEventData/' + eventID,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    console.log("Response from server: ", response);
                    if (response.data) {
                        var data = response.data;
                        $('#skema_select').empty();
                        $('#skema_select').append('<option hidden disabled selected>Pilih Skema</option>');
                        $.each(data, function(key, row) {
                            $('#skema_select').append('<option value="' + row.id_skema + '">' + row.nama_skema + '</option>');
                        });
                        $('#skema_select').trigger("chosen:updated");
                        if (localStorage.getItem('skema_select')) {
                            $('#skema_select').val(localStorage.getItem('skema_select')).trigger('change');
                            $('#search_btn').prop('disabled', false);
                        }
                    }
                }
            });
        }
    });

    $('#skema_select').on('change', function() {
        skemaID = $(this).val();
        console.log('Selected skemaID:', skemaID);

        if (skemaID) {
            $('#search_btn').prop('disabled', false);
        }
    });

    $('#search_btn').on('click', function() {
        $('input[type="text"]').val('');
        $('input[type="date"]').val('');
        $('input[type="checkbox"]').prop('checked', false);

        if (!skemaID || !eventID) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Silakan pilih Event dan Skema terlebih dahulu!'
            });
            return;
        }

        console.log('Search button clicked with skemaID:', skemaID, 'and eventID:', eventID);

        fetchDetailData(skemaID, eventID);
    });

    // Add kemampuan for CREATE modal
    $('#addKemampuanCreate').click(function() {
        $('.kemampuan-wrapper-create').append(`<div class="row mb-3 kemampuan_dasar-input-create">
            <div class="col-md-7">
                <input type="text" class="form-control" name="create_kemampuan_dasar[]" placeholder="Kemampuan Dasar" required>
            </div>
            <div class="col-md-3">
                <select class="form-control" name="create_keterangan[]" required style="">
                    <option value="" disabled selected>Pilih Keterangan</option>
                    <option value="kurang">Kurang</option>
                    <option value="cukup">Cukup</option>
                    <option value="baik">Baik</option>
                    <option value="sangat baik">Sangat Baik</option>
                </select>
            </div>
            <div class="col-md-2">
                <button class="btn btn-outline-danger rounded removeKemampuan" type="button">Hapus</button>
            </div>
        </div>`);
        $('#empty-input-message').hide();
    });

    // Remove kemampuan for CREATE modal
    $(document).on('click', '.removeKemampuan', function() {
        $(this).closest('.kemampuan_dasar-input-create').remove();

        if ($('.kemampuan_dasar-input-create').length === 0) {
            $('#empty-input-message').show();
        }
    });

    // Add kemampuan for EDIT modal
    $('#addKemampuanEdit').click(function() {
        // Generate unique ID for new input
        const uniqueId = 'new_' + Date.now();

        $('.kemampuan-wrapper-edit').append(`
            <div class="row mb-3 kemampuan_dasar-input-edit">
                <div class="col-md-7">
                    <input type="hidden" name="kemampuan_dasar_ids[]" value="${uniqueId}">
                    <input type="text" class="form-control" name="edit_kemampuan_dasar[${uniqueId}]" placeholder="Kemampuan Dasar" required>
                </div>
                <div class="col-md-3">
                    <select class="form-control" name="edit_keterangan[${uniqueId}]" required>
                        <option value="" disabled selected>Pilih Keterangan</option>
                        <option value="kurang">Kurang</option>
                        <option value="cukup">Cukup</option>
                        <option value="baik">Baik</option>
                        <option value="sangat baik">Sangat Baik</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-danger rounded removekemampuan" type="button">Hapus</button>
                </div>
            </div>
        `);
        $('#empty-input-message').hide();
    });

    // Remove kemampuan for EDIT modal (consistent class name)
    $(document).on('click', '.removekemampuan', function() {
        $(this).closest('.kemampuan_dasar-input-edit').remove();

        // Check if there are any remaining inputs
        if ($('.kemampuan_dasar-input-edit').length === 0) {
            $('#empty-input-message').show();
        }
    });

    // Create Laporan Modal Trigger
    $(document).on('click', '.create_laporan_btn', function(e) {
        e.preventDefault();

        var pesertaID = $(this).data('id');
        console.log(pesertaID);

        $('#create_name_peserta').val('');
        $('#peserta_id').val('');
        $('#event_skema_id').val('');
        $('#pengalaman_anak').val('');
        $('#peralatan_penunjang').val('');
        $('#saran').val('');

        $('input[name="create_kemampuan_dasar[]"]').each(function() {
            $(this).val('');
        });

        $('select[name="create_keterangan[]"]').each(function() {
            $(this).val('');
        });

        $('.kemampuan_dasar-input-create').remove();
        $('#empty-input-message').show();

        ['pengalaman_anak', 'peralatan_penunjang', 'saran'].forEach(function(field) {
            if (editors[field]) {
                editors[field].destroy()
                    .then(() => {
                        delete editors[field];
                    })
                    .catch(error => {
                        console.error(error);
                    });
            }
        });

        $.ajax({
            url: '/laporanperkembangan/fetchPesertaData/' + pesertaID,
            type: "GET",
            dataType: "json",
            success: function(response) {
                console.log('respons',response);
                var data_peserta = response.data_peserta;

                $('#createLaporanModal').modal('show');
                $('#create_nama_peserta').val(data_peserta.nama_lengkap);
                $('#peserta_id').val(data_peserta.id_peserta);
                $('#event_skema_id').val(data_peserta.event_skema_id);

                ['pengalaman_anak', 'peralatan_penunjang', 'saran'].forEach(function(field) {
                    if (!editors[field]) {
                        ClassicEditor
                            .create(document.querySelector('#' + field))
                            .then(editor => {
                                editors[field] = editor; // Simpan instance editor baru
                            })
                            .catch(error => {
                                console.error(error);
                            });
                    }
                });
            },
            error: function() {
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal Memuat Data',
                    text: 'Tidak dapat mengambil data dari server!'
                });
            }
        });
    });

    // Store function -- to store and update
    $(document).on('click', '#store_laporan_btn', function() {
        // Mengambil nilai dari input
        var createdBy = $('#created_by').val();
        var pesertaID = $('#peserta_id').val();
        var eventSkemaID = $('#event_skema_id').val();
        var pengalamanAnak = editors['pengalaman_anak'] ? editors['pengalaman_anak'].getData() : '';
        var peralatanPenunjang = editors['peralatan_penunjang'] ? editors['peralatan_penunjang'].getData() : '';
        var saran = editors['saran'] ? editors['saran'].getData() : '';

        var kemampuanDasar = [];
        $('input[name="create_kemampuan_dasar[]"]').each(function(e) {
            var value = $(this).val();
            if (value) {
                kemampuanDasar.push(value);
            }
        });

        var keterangan = [];
        $('select[name="create_keterangan[]"]').each(function() {
            var value = $(this).val();
            if (['kurang', 'cukup', 'baik', 'sangat baik'].includes(value)) {
                keterangan.push(value);
            }
        });

        if (kemampuanDasar.length === 0 || kemampuanDasar.includes('')) {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Semua bidang kemampuan dasar harus diisi!'
            });
            return;
        }

        // Memastikan pesertaID tidak undefined
        if (typeof pesertaID === 'undefined') {
            Swal.fire({
                icon: 'error',
                title: 'Gagal',
                text: 'Peserta ID tidak ditemukan!'
            });
            return;
        }

        console.log('Pengalaman Anak:', pengalamanAnak);
        console.log('Peralatan Penunjang:', peralatanPenunjang);
        console.log('Saran:', saran);

        // Siapkan data untuk dikirim
        var data = {
            event_skema_id: eventSkemaID,
            pesertaID: pesertaID,
            pengalaman_anak: pengalamanAnak,
            kemampuan_dasar: kemampuanDasar,
            keterangan: keterangan,
            peralatan_penunjang: peralatanPenunjang,
            saran: saran,
            created_by: createdBy,
        };

        console.log('Peserta ID:', pesertaID);
        console.log('Data yang dikirim:', data);

        // Setup untuk CSRF token
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });

        $.ajax({
            url: '/laporanperkembangan/storeNilaiData/' + pesertaID,
            type: 'POST',
            data: data,
            dataType: "json",
            success: function(response) {
                console.log('Response:', response);
                if (response.success === true) {
                    $('#createLaporanModal').modal('hide');
                    // Clear the form inputs
                    $('#create_nama_peserta').val('');
                    $('#peserta_id').val('');
                    $('#event_skema_id').val('');
                    $('#pengalaman_anak').val('');
                    $('#peralatan_penunjang').val('');
                    $('#saran').val('');

                    $('input[name="create_kemampuan_dasar[]"]').each(function() {
                        $(this).val('');
                    });

                    $('select[name="create_keterangan[]"]').each(function() {
                        $(this).val('');
                    });

                    // Clear the editor instances if they exist
                    ['pengalaman_anak', 'peralatan_penunjang', 'saran'].forEach(
                        function(field) {
                            if (editors[field]) {
                                editors[field].setData(''); // Clear the editor's content
                            }
                        });

                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: response.message,
                    });

                    // FIX: Pass both skemaID and eventID to fetchDetailData
                    fetchDetailData(skemaID, eventID);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: response.message || 'Terjadi kesalahan saat membuat data.',
                    });
                }
            },
            error: function(xhr) {
                var errorMessage = xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi Error';
                console.log('AJAX Error:', errorMessage);
                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: errorMessage
                });
            }
        });
    });

    // Edit Modal Trigger - FIXED VERSION
    $(document).on('click', '.edit_laporan_btn', function(e) {
        e.preventDefault();

        // Get pesertaID from clicked element
        var clickedPesertaID = $(this).data('id');
        console.log('Edit button clicked for Peserta ID:', clickedPesertaID);

        // Validate pesertaID
        if (!clickedPesertaID) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'ID Peserta tidak ditemukan!'
            });
            return;
        }

        // Show loading
        Swal.fire({
            title: 'Memuat...',
            text: 'Sedang mengambil data laporan',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        // Clear existing dynamic inputs and editors BEFORE AJAX call
        $('.kemampuan_dasar-input-edit').remove();
        $('.kemampuan_dasar-input-create').remove();
        $('#empty-input-message').show();

        // Destroy existing editors
        fieldsToInitialize.forEach(field => {
            if (editors[field]) {
                editors[field].destroy()
                    .then(() => {
                        delete editors[field];
                    })
                    .catch(error => {
                        console.error('Error destroying editor:', error);
                    });
            }
        });

        // Clear form fields first
        $('#edite_id').val('');
        $('#edit_nama_peserta').val('');

        $.ajax({
            url: '/laporanperkembangan/fetchLaporanData/' + clickedPesertaID,
            type: "GET",
            dataType: "json",
            success: function(response) {
                console.log('Full Response data:', response);

                Swal.close(); // Close loading

                // Validate response
                if (!response || !response.data_laporan) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Data laporan tidak ditemukan!'
                    });
                    return;
                }

                // Set the pesertaID to global variable for update function
                pesertaID = clickedPesertaID;

                // Show modal FIRST
                $('#editLaporanModal').modal('show');

                // Wait for modal to be fully shown, then populate data
                $('#editLaporanModal').on('shown.bs.modal', function(e) {
                    // Remove any previous event handlers to prevent multiple bindings
                    $(this).off('shown.bs.modal');

                    console.log('Modal shown, populating data for peserta:', clickedPesertaID);

                    // Set form data
                    $('#edite_id').val(response.data_laporan.peserta_id || clickedPesertaID);
                    $('#edit_nama_peserta').val(response.data_laporan.nama_lengkap || '');

                    // Clear and populate kemampuan dasar data
                    $('.kemampuan_dasar-input-edit').remove();

                    if (response.data_kemampuan_dasar && response.data_kemampuan_dasar.length > 0) {
                        console.log('Populating kemampuan dasar:', response.data_kemampuan_dasar);
                        response.data_kemampuan_dasar.forEach(function(item, index) {
                            var kemampuanHtml = `
                                <div class="row mb-3 kemampuan_dasar-input-edit" data-index="${index}">
                                    <div class="col-md-7">
                                        <input type="hidden" name="kemampuan_dasar_ids[]" value="${item.id_kemampuan_dasar}">
                                        <input type="text" class="form-control" name="edit_kemampuan_dasar[${item.id_kemampuan_dasar}]" value="${item.kemampuan}" placeholder="Kemampuan Dasar" required>
                                    </div>
                                    <div class="col-md-3">
                                        <select class="form-control" name="edit_keterangan[${item.id_kemampuan_dasar}]" required>
                                            <option value="" disabled>Pilih Keterangan</option>
                                            <option value="kurang" ${item.keterangan === 'kurang' ? 'selected' : ''}>Kurang</option>
                                            <option value="cukup" ${item.keterangan === 'cukup' ? 'selected' : ''}>Cukup</option>
                                            <option value="baik" ${item.keterangan === 'baik' ? 'selected' : ''}>Baik</option>
                                            <option value="sangat baik" ${item.keterangan === 'sangat baik' ? 'selected' : ''}>Sangat Baik</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-outline-danger rounded removekemampuan" type="button">Hapus</button>
                                    </div>
                                </div>
                            `;
                            $('.kemampuan-wrapper-edit').append(kemampuanHtml);
                        });
                        $('#empty-input-message').hide();
                    } else {
                        $('#empty-input-message').show();
                    }

                    // Initialize CKEditor for each field
                    setTimeout(() => {
                        fieldsToInitialize.forEach(field => {
                            const fieldElement = document.querySelector('#' + field);
                            if (fieldElement) {
                                // Destroy existing editor if exists
                                if (editors[field]) {
                                    editors[field].destroy()
                                        .then(() => {
                                            delete editors[field];
                                            initializeEditor();
                                        })
                                        .catch(error => {
                                            console.error('Error destroying existing editor:', error);
                                            initializeEditor();
                                        });
                                } else {
                                    initializeEditor();
                                }

                                function initializeEditor() {
                                    ClassicEditor
                                        .create(fieldElement)
                                        .then(editor => {
                                            editors[field] = editor;
                                            // Set data after editor is ready
                                            const fieldData = response.data_laporan[field.replace('edit_', '')] || '';
                                            console.log(`Setting ${field} data:`, fieldData);
                                            editor.setData(fieldData);
                                        })
                                        .catch(error => {
                                            console.error('CKEditor initialization error for ' + field + ':', error);
                                        });
                                }
                            }
                        });
                    }, 300);
                });
            },
            error: function(xhr, status, error) {
                Swal.close();
                console.error('AJAX error:', error);
                console.error('XHR:', xhr.responseText);

                var errorMessage = 'Gagal memuat data laporan';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: errorMessage
                });
            }
        });
    });

    // Update function - FIXED VERSION
    $(document).on('click', '#update_laporan_btn', function(e) {
        e.preventDefault();

        // Get pesertaID from hidden input
        let updatePesertaID = $('#edite_id').val();
        console.log('Update Peserta ID from form:', updatePesertaID);
        console.log('Global pesertaID variable:', pesertaID);

        // Use the form value first, fallback to global variable
        let finalPesertaID = updatePesertaID || pesertaID;

        if (!finalPesertaID) {
            Swal.fire({
                icon: 'error',
                title: 'Oops!',
                text: 'ID peserta tidak ditemukan.',
            });
            return;
        }

        console.log('Final Peserta ID for update:', finalPesertaID);

        // Get data from CKEditor instances
        let pengalamanAnak = editors['edit_pengalaman_anak'] ? editors['edit_pengalaman_anak'].getData() : '';
        let peralatanPenunjang = editors['edit_peralatan_penunjang'] ? editors['edit_peralatan_penunjang'].getData() : '';
        let saran = editors['edit_saran'] ? editors['edit_saran'].getData() : '';

        // Collect kemampuan dasar data
        let kemampuanDasar = [];
        $('.kemampuan_dasar-input-edit').each(function() {
            let id = $(this).find('input[name="kemampuan_dasar_ids[]"]').val();
            let kemampuan = $(this).find('input[name^="edit_kemampuan_dasar"]').val();
            let keterangan = $(this).find('select[name^="edit_keterangan"]').val();

            if (id && kemampuan && keterangan) {
                kemampuanDasar.push({
                    id: id,
                    kemampuan_dasar: kemampuan,
                    keterangan: keterangan
                });
            }
        });

        // Validation
        if (kemampuanDasar.length === 0) {
            Swal.fire({
                icon: 'error',
                title: 'Validasi Gagal',
                text: 'Minimal harus ada satu kemampuan dasar yang diisi.',
            });
            return;
        }

        console.log('Data yang akan dikirim:', {
            pesertaID: finalPesertaID,
            pengalaman_anak: pengalamanAnak,
            kemampuan_dasar: kemampuanDasar,
            peralatan_penunjang: peralatanPenunjang,
            saran: saran,
        });

        // Show loading
        Swal.fire({
            title: 'Memproses...',
            text: 'Sedang mengupdate data laporan',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: '/laporanperkembangan/updateLaporan/' + finalPesertaID,
            type: "POST",
            data: {
                "_token": $('meta[name="csrf-token"]').attr('content'),
                "pengalaman_anak": pengalamanAnak,
                "kemampuan_dasar": kemampuanDasar,
                "peralatan_penunjang": peralatanPenunjang,
                "saran": saran,
            },
            success: function(response) {
                Swal.close();

                if (response.status === 'success') {
                    $('#editLaporanModal').modal('hide');

                    // Clear editors after successful update
                    fieldsToInitialize.forEach(field => {
                        if (editors[field]) {
                            editors[field].destroy()
                                .then(() => {
                                    delete editors[field];
                                })
                                .catch(error => {
                                    console.error('Error destroying editor:', error);
                                });
                        }
                    });

                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Laporan berhasil diupdate!',
                    });

                    // Refresh data
                    fetchDetailData(skemaID, eventID);
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: response.message || 'Terjadi kesalahan saat mengupdate data.',
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.close();
                console.error('Error:', xhr.responseText);

                let errorMessage = 'Terjadi kesalahan saat mengupdate data.';
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    errorMessage = xhr.responseJSON.message;
                } else if (xhr.responseJSON && xhr.responseJSON.errors) {
                    errorMessage = Object.values(xhr.responseJSON.errors).flat().join(', ');
                }

                Swal.fire({
                    icon: 'error',
                    title: 'Gagal',
                    text: errorMessage
                });
            }
        });
    });

    // Delete function - FIXED VERSION
    $(document).on('click', '.delete_laporan_btn', function(e) {
        e.preventDefault();
        pesertaID = $(this).data('id');
        console.log('Peserta ID untuk hapus:', pesertaID);

        confirmDelete('Hapus Laporan Perkembangan Peserta', 'Apakah kamu yakin untuk menghapus?')
            .then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/laporanperkembangan/destroyLaporanData/' + pesertaID,
                        type: 'DELETE',
                        data: {
                            _token: $('meta[name="csrf-token"]').attr('content'),
                            pesertaID: pesertaID
                        },
                        success: function(response) {
                            console.log('Laporan perkembangan peserta berhasil dihapus');

                            // Tampilkan alert sukses
                            Swal.fire({
                                icon: 'success',
                                title: 'Sukses!',
                                text: 'Laporan perkembangan peserta berhasil dihapus!',
                            });

                            // PERBAIKAN: Panggil fetchDetailData dengan parameter yang benar
                            fetchDetailData(skemaID, eventID);
                        },
                        error: function(xhr, status, error) {
                            console.error('Terjadi kesalahan saat menghapus nilai peserta:', error);

                            // Tampilkan alert error
                            let errorMessage = xhr.responseJSON ? xhr.responseJSON.message : 'Terjadi kesalahan saat menghapus data.';
                            Swal.fire({
                                icon: 'error',
                                title: 'Gagal',
                                text: errorMessage
                            });
                        }
                    });
                }
            });
    });

    // Modal close event handlers - destroy editors when modals are closed
    $('#editLaporanModal').on('hidden.bs.modal', function () {
        fieldsToInitialize.forEach(field => {
            if (editors[field]) {
                editors[field].destroy()
                    .then(() => {
                        delete editors[field];
                    })
                    .catch(error => {
                        console.error('Error destroying editor on modal close:', error);
                    });
            }
        });

        // Clear dynamic inputs
        $('.kemampuan_dasar-input-edit').remove();
        $('.kemampuan_dasar-input-create').remove();
        $('#empty-input-message').show();
    });

    $('#createLaporanModal').on('hidden.bs.modal', function () {
        ['pengalaman_anak', 'peralatan_penunjang', 'saran'].forEach(function(field) {
            if (editors[field]) {
                editors[field].destroy()
                    .then(() => {
                        delete editors[field];
                    })
                    .catch(error => {
                        console.error('Error destroying editor on modal close:', error);
                    });
            }
        });

        // Clear form inputs
        $('#create_nama_peserta').val('');
        $('#peserta_id').val('');
        $('#event_skema_id').val('');

        // Clear dynamic inputs
        $('.kemampuan_dasar-input-create').remove();
        $('#empty-input-message').show();
    });

    // Initialize on page load
    if (localStorage.getItem('event_select')) {
        $('#event_select').val(localStorage.getItem('event_select')).trigger('change');
    }

});
</script>
@endpush
