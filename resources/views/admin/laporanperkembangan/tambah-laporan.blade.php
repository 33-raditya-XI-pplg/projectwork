@extends('layouts.panel.index')
@section('title', 'Laporan Perkembangan')
@section('content')

    <div class="container mt-2">
        <div class="tab-content" id="pills-tabContent">
            <div class="tab-pane fade show active" id="pills-home" role="tabpanel" aria-labelledby="pills-home-tab"
                tabindex="0">

                <div class="bg-white rounded-4 px-3 py-3 mb-3 shadow-lg">
                    <div class="row">
                        <div class="col-md-12 text-end">
                            <a href="#"class="btn btn-primary btn-sm rounded text-white mb-3 create_laporan_btn "data-id="{{ $peserta->id_peserta }}">
                                    <i class="fa-regular fa-pen-to-square"></i> Tambah</a>
                            </div>
                        </div>
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
                                    @foreach ($laporan as $index=> $row)
                                <tr>
                                    <td>{{ $index + 1 }}</td>
                                    <td>{{ $row->nama_lengkap }}</td>
                                    {{-- @foreach($row->keterangan as $keterangan) --}}
                                    <td>{{ $row->keterangan[1] }}</td>
                                    {{-- @endforeach --}}
                                    {{-- <td>{{ $row->keterangan ?? 'Tidak ada keterangan' }}</td> --}}
                                    <td>{{ $row->tanggal_penilaian ?? 'Tanggal tidak tersedia' }}</td>
                                    <td class="text-center">
                                        <div class="d-flex flex-column gap-2 px-3">
                                            <a href="#"
                                                class="btn btn-info btn-sm rounded text-white mb-2 edit_laporan_btn"
                                                data-id="{{ $row->id_laporan_perkembangan }}">
                                                <i class="fa-regular fa-pen-to-square"></i> Edit
                                            </a>
                                            <a href="#"
                                                class="btn btn-danger btn-sm rounded text-white mb-2 delete_laporan_btn"
                                                data-id="{{ $row->id_peserta }}">
                                                <i class="fa-regular fa-trash-can"></i> Delete
                                            </a>
                                </tr>
                                @endforeach
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
                            <h5 class="modal-title" id="exampleModalLabel">Tambah Laporan</h5>
                            {{-- <p>{{$peserta->event_skema_id}}</p> --}}
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="created_by" value="{{ $peserta->user_id }}">
                            <div class="mb-3">
                                <label for="create_nama_peserta" class="form-label">Nama Peserta</label>
                                <input type="text" class="form-control" id="create_nama_peserta" readonly
                                    value="{{ $peserta->nama_lengkap }}">
                                <input type="hidden" id="peserta_id" value="{{ $peserta->id_peserta }}">
                                <input type="hidden" id="event_skema_id" name="event_skema_id"
                                    value="{{ $peserta->event_skema_id }}">
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

                                <div id="empty-input-message" class="alert alert-info" role="alert"
                                    style="display: show;">
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

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success rounded-3 text-white" id="store_laporan_btn"
                                value="1">Tambah</button>
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
                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <input type="hidden" id="edite_id" value="">
                            <div class="mb-3">
                                <label for="edit_nama_peserta" class="form-label">Nama Peserta</label>
                                <input type="text" class="form-control" id="edit_nama_peserta" readonly disabled>
                            </div>
                            <div>
                                <label class="form-label" for="edit_pengalaman_anak">Keterangan Singkat</label>
                                <!-- PERBAIKAN: Hapus atribut 'hidden' -->
                                <textarea class="form-control" name="edit_pengalaman_anak" id="edit_pengalaman_anak" rows="2"></textarea>
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
                                                    value="{{ $row->kemampuan_dasar }}" placeholder="Kemampuan Dasar"
                                                    required>
                                            </div>
                                            <div class="col-md-3">
                                                <select class="form-control"
                                                    name="edit_keterangan[{{ $row->id_kemampuan_dasar }}]" required
                                                    style="max-width: 120px; background-color: #d1ecf1;">
                                                    <option value="" disabled>Pilih Keterangan</option>
                                                    <option value="kurang"
                                                        {{ $row->keterangan == 'kurang' ? 'selected' : '' }}>
                                                        Kurang</option>
                                                    <option value="cukup"
                                                        {{ $row->keterangan == 'cukup' ? 'selected' : '' }}>
                                                        Cukup</option>
                                                    <option value="baik"
                                                        {{ $row->keterangan == 'baik' ? 'selected' : '' }}>Baik
                                                    </option>
                                                    <option value="sangat baik"
                                                        {{ $row->keterangan == 'sangat baik' ? 'selected' : '' }}>Sangat
                                                        Baik
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
                                <label class="form-label" for="edit_peralatan_penunjang">Peralatan penunjang</label>
                                <!-- PERBAIKAN: Hapus atribut 'hidden' -->
                                <textarea class="form-control" name="edit_peralatan_penunjang" id="edit_peralatan_penunjang" rows="2"></textarea>
                            </div>
                            <div>
                                <label class="form-label" for="edit_saran">Saran</label>
                                <!-- PERBAIKAN: Hapus atribut 'hidden' -->
                                <textarea class="form-control" name="edit_saran" id="edit_saran" rows="2"></textarea>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-danger rounded-3"
                                data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success rounded-3 text-white" id="update_laporan_btn"
                                value="1">Update</button>
                        </div>
                    </div>
                </div>
            </div>

        @endsection

        @push('script')
            {{-- <script>
    $(document).ready(function() {
        $('.js-example-basic-single').each(function() {
            var placeholder = $(this).data('placeholder');

            $(this).select2({
                placeholder: placeholder,
                allowClear: true,
                minimumResultsForSearch: Infinity
            });
        });
    });
    </script> --}}

            <script>
                $(document).ready(function() {
                    var skemaID; // ID skema yang dipilih dari dropdown
                    var eventID; // ID event yang dipilih dari dropdown
                    var event_skemaID; // ID dari tabel event_skema (relasi antara event dan skema)
                    var pesertaID;

                    var data_laporan_perkembangan;
                    var data_skema;
                    var data_sub_skema;

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

                    function fetchDetailData(skemaID, eventID) {

                        $.ajax({
                            url: '/laporanperkembangan/fetchSkemaData/' + skemaID + '/' + eventID,
                            type: "GET",
                            dataType: "json",
                            success: function(response) {
                                Swal.close();
                                if (response) {
                                    data_skema = response.data_skema;
                                    data_penguji = response.data_penguji;
                                    data_sub_skema = response.data_sub_skema;
                                    data_peserta = response.data_peserta;
                                    data_laporan_perkembangan = response.data_laporan_perkembangan;

                                    var data_jumlah_sub_skema = response.jumlahSubSkemaPerEvent;

                                    $('#nama_event').val(data_skema.nama_event);
                                    $('#jenis_event').val(data_skema.nama_jenis_event);
                                    $('#nama_skema').val(data_skema.nama_skema);
                                    $('#tempat_skema').val(data_skema.nama_tempat);
                                    $('#tgl_mulai').val(formatDate(data_skema.tgl_mulai));
                                    $('#tgl_selesai').val(formatDate(data_skema.tgl_berakhir));

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
                                        var allPenguji = data_penguji.event_skema_menguji.map(function(
                                            penguji) {
                                            return penguji.nama_lengkap;
                                        });
                                        renderPenguji(allPenguji);
                                        btnSelengkapnya.style.display = 'none';
                                        btnSedikit.style.display = 'inline';
                                    });

                                    btnSedikit.addEventListener('click', function(event) {
                                        event.preventDefault();
                                        var initialPenguji = data_penguji.event_skema_menguji.slice(0,
                                            2).map(
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

                                    $('#example').DataTable().destroy();
                                    $('tbody').html("");
                                    $('#dropdown-menu').html("");

                                    $.each(data_peserta, function(index, row) {
                                        var num = index + 1;
                                        var buttonAction = '';

                                        if (row.catatan) {
                                            buttonAction =
                                                '<li style="list-style: none;">' +
                                                '<a href="#" class="dropdown-item text-info edit_laporan_btn" data-id="' +
                                                row.id_peserta + '">' +
                                                '<i class="fa-regular fa-pen-to-square"></i> Edit' +
                                                '</a>' +
                                                '</li>' +
                                                '<li style="list-style: none;">' +
                                                '<a href="#" class="dropdown-item text-danger delete_laporan_btn" data-id="' +
                                                row.id_peserta + '">' +
                                                '<i class="fa-regular fa-trash-can"></i> Delete' +
                                                '</a>' +
                                                '</li>';
                                        } else {
                                            buttonAction =
                                                '<a href="#" class="btn btn-info btn-sm rounded text-white mb-3 create_laporan_btn" data-id="' +
                                                row.id_peserta + '">' +
                                                '<i class="fa-regular fa-pen-to-square"></i> Tambah' +
                                                '</a>';
                                        }

                                        $('tbody').append(
                                            '<tr>\
                                                    <td>' + num + '</td>\
                                                    <td>' + (row.nama_lengkap || 'Nama tidak tersedia') + '</td>\
                                                    <td>' + (row.catatan || 'Tidak ada catatan') + '</td>\
                                                    <td>' + (row.tanggal_penilaian ? formatDate(row.tanggal_penilaian) :
                                                'Tanggal tidak tersedia') + '</td>\
                                                    <td>\
                                                        <div class="d-flex flex-column gap-2 px-3 ">\
                                                            ' + buttonAction + '\
                                                        </div>\
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
                        eventID = $(this).val();
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
                                        $('#skema_select').append(
                                            '<option hidden disabled selected>Pilih Skema</option>');
                                        $.each(data, function(key, row) {

                                            $('#skema_select').append('<option value="' + row
                                                .id_skema + '">' + row.nama_skema +
                                                '</option>');
                                        });
                                        $('#skema_select').trigger("chosen:updated");
                                        if (localStorage.getItem('skema_select')) {
                                            $('#skema_select').val(localStorage.getItem('skema_select'))
                                                .trigger('change');
                                            $('#search_btn').prop('disabled', false);
                                        }
                                    }
                                },
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


                    $(document).on('click', '.removeKemampuan', function() {
                        $(this).closest('.kemampuan_dasar-input-create')
                            .remove();


                        if ($('.kemampuan_dasar-input-create').length === 0) {
                            $('#empty-input-message').show();
                        }
                    });



                    $('#addKemampuanEdit').click(function() {
                        $('.kemampuan-wrapper-edit').append(`<div class="row mb-3 kemampuan_dasar-input-create">
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
                        checkEmptyInput('#empty-input-message');
                    });

                    $(document).on('click', '.removeKemampuan', function() {
                        $(this).closest('.kemampuan_dasar-input-edit').remove();


                        if ($('.kemampuan_dasar-input-edit').length === 0) {
                            $('#empty-input-message').show();
                        }
                    });


                    $(document).on('click', '.create_laporan_btn', function(e) {
                        e.preventDefault();

                        var pesertaID = "{{ $peserta->id_peserta }}";
                        console.log('Peserta ID11:', pesertaID);

                        $('#create_name_peserta').val('');
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
                                console.log('response fetch data peserta', response);
                                console.log('debug pesserta id', pesertaID);

                                var data_peserta = response.data_peserta;
                                console.log('debug data peserta', data_peserta);



                                $('#createLaporanModal').modal('show');
                                $('#create_nama_peserta').val(data_peserta
                                    .nama_lengkap);
                                console.log('debug 2', data_peserta);

                                $('#event_skema_id').val(data_peserta.peserta_event_skema_id);

                                ['pengalaman_anak', 'peralatan_penunjang', 'saran'].forEach(function(
                                    field) {
                                    if (!editors[field]) {
                                        ClassicEditor
                                            .create(document.querySelector('#' + field))
                                            .then(editor => {
                                                editors[field] =
                                                    editor;
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


                    $(document).on('click', '#store_laporan_btn', function() {

                        var createdBy = $('#created_by').val();
                        var pesertaID = "{{ $peserta->id_peserta }}";
                        var eventSkemaID = $('#event_skema_id').val();

                        // console.log(pesertaID);
                        console.log('eventSkemaIDdebug:', eventSkemaID);

                        var pengalamanAnak = editors['pengalaman_anak'] ? editors['pengalaman_anak'].getData() : '';
                        var peralatanPenunjang = editors['peralatan_penunjang'] ? editors['peralatan_penunjang']
                            .getData() : '';
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

                                    ['pengalaman_anak', 'peralatan_penunjang', 'saran'].forEach(
                                        function(field) {
                                            if (editors[field]) {
                                                editors[field].setData('');
                                            }
                                        });

                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sukses!',
                                        text: response.message,
                                    });
                                    window.location.reload()

                                    //tanda
                                    console.log('debugggg', data_peserta);

                                    fetchDetailData(data_peserta.skema_id, data_peserta.event_id);
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops!',
                                        text: response.message ||
                                            'Terjadi kesalahan saat membuat data.',
                                    });
                                }
                            },
                            error: function(xhr) {
                                var errorMessage = xhr.responseJSON ? xhr.responseJSON.message :
                                    'Terjadi Error';
                                console.log('AJAX Error:', errorMessage);
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: errorMessage
                                });
                            }
                        });
                    });

                    // Edit Modal Trigger
                    const fieldsToInitialize = ['edit_pengalaman_anak', 'edit_peralatan_penunjang', 'edit_saran'];
                    let editors = {};

                    $(document).on('click', '.edit_laporan_btn', function(e) {
                        e.preventDefault();

                        console.log('Edit button clicked');
                        laporanID = $(this).data('id');

                        $('.kemampuan_dasar-input-edit').remove();

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

                        $.ajax({
                            url: '/laporanperkembangan/fetchLaporanData/' + laporanID,
                            type: "get",
                            dataType: "json",
                            success: function(response) {
                                console.log(response);

                                $('#editLaporanModal').modal('show');

                                $('#edite_id').val(response.data_laporan.peserta_id);
                                $('#edit_nama_peserta').val(response.data_laporan.nama_lengkap);

                                $('.kemampuan_dasar-input-edit').remove();

                                if (response.data_kemampuan_dasar && response.data_kemampuan_dasar
                                    .length > 0) {
                                    response.data_kemampuan_dasar.forEach(function(item) {
                                        $('.kemampuan-wrapper-edit').append(`<div class="row mb-3 kemampuan_dasar-input-edit">
                                    <div class="col-md-7">
                                        <input type="hidden" name="kemampuan_dasar_ids[]" value="${item.id_kemampuan_dasar}">
                                        <input type="text" class="form-control" name="edit_kemampuan_dasar[${item.id_kemampuan_dasar}]" value="${item.kemampuan}" placeholder="Kemampuan Dasar" required>
                                    </div>
                                    <div class="col-md-3 mb-2">
                                        <select class="form-control" name="edit_keterangan[${item.id_kemampuan_dasar}]" required>
                                            <option value="" disabled>Pilih Keterangan</option>
                                            <option value="kurang" ${item.keterangan === 'kurang' ? 'selected' : ''}>Kurang</option>
                                            <option value="cukup" ${item.keterangan === 'cukup' ? 'selected' : ''}>Cukup</option>
                                            <option value="baik" ${item.keterangan === 'baik' ? 'selected' : ''}>Baik</option>
                                            <option value="sangat baik" ${item.keterangan === 'sangat baik' ? 'selected' : ''}>Sangat Baik</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <button class="btn btn-outline-danger rounded removeKemampuan" type="button">Hapus</button>
                                    </div>
                                </div>`);
                                    });
                                    $('#empty-input-message').hide();
                                } else {
                                    $('#empty-input-message').show();
                                }

                                setTimeout(() => {
                                    fieldsToInitialize.forEach(field => {
                                        const fieldElement = document.querySelector(
                                            '#' + field);
                                        if (fieldElement && !editors[field]) {
                                            ClassicEditor
                                                .create(fieldElement)
                                                .then(editor => {
                                                    editors[field] = editor;
                                                    const fieldName = field.replace(
                                                        'edit_', '');
                                                    const fieldData = response
                                                        .data_laporan[fieldName] ||
                                                        '';
                                                    editor.setData(fieldData);
                                                    console.log(
                                                        `Data untuk ${field}:`,
                                                        fieldData);
                                                })
                                                .catch(error => {
                                                    console.error(
                                                        'CKEditor initialization error:',
                                                        error);
                                                });
                                        }
                                    });
                                }, 100);

                                console.log('ID peserta dari respons:', response.data_laporan
                                    .peserta_id);
                            },
                            error: function(xhr, status, error) {
                                console.error('AJAX error:', error);
                            }
                        });
                    });

                    // Lanjutan dari update function
                    $(document).on('click', '#update_laporan_btn', function(e) {
                        e.preventDefault();

                        let pesertaID = $('#edite_id').val();
                        console.log('Peserta ID before AJAX call:', pesertaID);

                        if (!pesertaID) {
                            Swal.fire({
                                icon: 'error',
                                title: 'Oops!',
                                text: 'ID peserta tidak ditemukan.',
                            });
                            return;
                        }

                        let pengalamanAnak = editors['edit_pengalaman_anak'] ? editors['edit_pengalaman_anak']
                            .getData() : '';
                        let peralatanPenunjang = editors['edit_peralatan_penunjang'] ? editors[
                            'edit_peralatan_penunjang'].getData() : '';
                        let saran = editors['edit_saran'] ? editors['edit_saran'].getData() : '';

                        let kemampuanDasar = [];
                        $('.kemampuan_dasar-input-edit').each(function() {
                            let id = $(this).find('input[name="kemampuan_dasar_ids[]"]').val();
                            let kemampuan = $(this).find('input[name="edit_kemampuan_dasar[' + id + ']"]')
                                .val();
                            let keterangan = $(this).find('select[name="edit_keterangan[' + id + ']"]')
                            .val();

                            if (id && kemampuan && keterangan) {
                                kemampuanDasar.push({
                                    id: id,
                                    kemampuan_dasar: kemampuan,
                                    keterangan: keterangan
                                });
                            }
                        });

                        console.log('Data sebelum kirim update:', {
                            pesertaID,
                            pengalaman_anak: pengalamanAnak,
                            kemampuan_dasar: kemampuanDasar,
                            peralatan_penunjang: peralatanPenunjang,
                            saran: saran,
                        });

                        $.ajax({
                            url: '/laporanperkembangan/updateLaporan/' + pesertaID,
                            type: "POST",
                            data: {
                                "_token": $('meta[name="csrf-token"]').attr('content'),
                                "pengalaman_anak": pengalamanAnak,
                                "kemampuan_dasar": kemampuanDasar,
                                "peralatan_penunjang": peralatanPenunjang,
                                "saran": saran,
                            },
                            success: function(response) {
                                if (response.status === 'success') {
                                    $('#editLaporanModal').modal('hide');
                                    Swal.fire({
                                        icon: 'success',
                                        title: 'Sukses!',
                                        text: 'Laporan berhasil diupdate!',
                                    });
                                    window.location.reload();
                                    fetchDetailData(skemaID, eventID);
                                } else {
                                    Swal.fire({
                                        icon: 'error',
                                        title: 'Oops!',
                                        text: 'Terjadi kesalahan saat mengupdate data.',
                                    });
                                }
                            },
                            error: function(xhr, status, error) {
                                console.error('Error:', xhr.responseText);
                                let errorMessage = xhr.responseJSON ? xhr.responseJSON.message :
                                    'Terjadi kesalahan saat mengupdate data.';
                                Swal.fire({
                                    icon: 'error',
                                    title: 'Gagal',
                                    text: errorMessage
                                });
                            }
                        });
                    });


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
                                            console.log(
                                                'Laporan perkembangan peserta berhasil dihapus');

                                            Swal.fire({
                                                icon: 'success',
                                                title: 'Sukses!',
                                                text: 'Laporan perkembangan peserta berhasil dihapus!',
                                            });
                                            window.location.reload();

                                            fetchDetailData(skemaID, eventID);
                                        },
                                        error: function(xhr, status, error) {
                                            console.error(
                                                'Terjadi kesalahan saat menghapus nilai peserta:',
                                                error);

                                            let errorMessage = xhr.responseJSON ? xhr.responseJSON
                                                .message : 'Terjadi kesalahan saat menghapus data.';
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

                    if (localStorage.getItem('event_select')) {
                        $('#event_select').val(localStorage.getItem('event_select')).trigger('change');
                    }

                });
            </script>
        @endpush
