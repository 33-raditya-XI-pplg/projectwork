@extends('layouts.panel.index')
@section('title', 'Laporan Perkembangan')
@section('content')

<div class="container mt-4">
    <div class="bg-white rounded-4 px-3 py-4 mb-3 shadow-lg">
        <div class="card-title mb-3 fw-semibold" style="font-size:18px">Pilih Event & Skema</div>

        <div class="d-flex flex-row mx-2">
            <div class="card-header me-2 w-100 mx-1">
                <select id="event_select" name="event_select" class=" form-control js-example-basic-single" data-placeholder="Pilih Event">
                    <option hidden disabled selected> </option>
                    @foreach ($events as $event)
                        <option value="{{ $event->id_event }}">{{ $event->nama_event }}</option>
                    @endforeach
                </select>
            </div>
            <div class="card-header me-2 w-100 mx-1">
                <select id="skema_select" name="skema_select" class="form-control js-example-basic-single" data-placeholder="Pilih Event Dahulu">
                    <option hidden disabled selected></option>
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
                        <input type="text" class="form-control" id="create_nama_peserta" readonly disabled>
                        <input type="hidden" id="peserta_id" value="">
                        <input type="hidden" id="event_skema_id" name="event_skema_id" value="">
                    </div>
                    <div>
                        <label class="form-label" for="pengalaman_anak">Pengalaman anak di dunia komputer</label>
                        <textarea class="form-control " name="pengalaman_anak" id="pengalaman_anak" rows="2"></textarea>
                    </div>
                    <div class="form-group kemampuan-wrapper-create mb-3 mt-3">
                        <div class="d-flex justify-content-between">
                            <label class="form-label">Kemampuan Dasar</label>
                            <button type="button" class="btn btn-primary btn-sm rounded mb-2" id="addKemampuanCreate">Tambah kemampuan Dasar</button>
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
                <input type="hidden" id="edite_id" value="">
                <div class="mb-3">
                    <label for="edit_nama_peserta" class="form-label">Nama Peserta</label>
                    <input type="text" class="form-control" id="edit_nama_peserta" readonly disabled>
                </div>
                <div>
                    <label class="form-label" for="pengalaman_anak">Pengalaman anak di dunia komputer</label>
                    <textarea class="form-control " name="pengalaman_anak" id="edit_pengalaman_anak" rows="2" hidden></textarea>
                </div>
                <div class="form-group kemampuan-wrapper-edit mb-3 mt-3">
                    <div class="d-flex justify-content-between">
                        <label class="form-label">Kemampuan Dasar</label>
                            <button type="button" class="btn btn-primary btn-sm rounded mb-2" id="addKemampuanEdit">Tambah Kemampuan Dasar</button>
                    </div>                                     
                    @if(isset($kemampuan) && !$kemampuan->isEmpty())
                        @foreach ($kemampuan as $row)
                        <div class="input-group mb-3 kemampuan_dasar-input-edit">
                            <input type="hidden" name="kemampuan_dasar_ids[]" value="{{ $row->id_kemampuan_dasar }}">
                            <input type="text" class="form-control" name="edit_kemampuan_dasar[{{ $row->id_kemampuan_dasar }}]" value="{{ $row->kemampuan_dasar }}" 
                                placeholder="Kemampuan Dasar" required>
                                <select class="form-control" name="edit_keterangan[{{ $row->id_kemampuan_dasar }}]" required style="max-width: 120px; background-color: #d1ecf1;">
                                    <option value="" disabled>Pilih Keterangan</option>
                                    <option value="kurang" {{ $row->keterangan == 'kurang' ? 'selected' : '' }}>Kurang</option>
                                    <option value="cukup" {{ $row->keterangan == 'cukup' ? 'selected' : '' }}>Cukup</option>
                                    <option value="baik" {{ $row->keterangan == 'baik' ? 'selected' : '' }}>Baik</option>
                                    <option value="sangat baik" {{ $row->keterangan == 'sangat baik' ? 'selected' : '' }}>Sangat Baik</option>
                                </select>

                            <div class="input-group-append">
                                <button class="btn btn-outline-danger rounded removekemampuan" type="button">Remove</button>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div id="empty-input-message" class="alert alert-info" role="alert" style="display: show;">
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
                <button type="submit" class="btn btn-success rounded-3 text-white" id="update_laporan_btn" value="1">Update</button>
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
        var skemaID;
        var event_skemaID
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

        // format Date function
        function formatDate(dateString) {
            var dateParts = dateString.split("-");
            var year = dateParts[0];
            var month = dateParts[1];
            var day = dateParts[2];

            var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                        'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

            return day + ' ' + months[parseInt(month) - 1] + ' ' + year;
        }

        function checkEmptyInput(context) {
            var inputs = $(context).find('.kemampuan_dasar-input-create .kemampuan_dasar-input-edit');
            if (inputs.length === 0) {
            $(context).find('#empty-input-message').show(); // Tampilkan pesan jika tidak ada input tersisa
            } else {
            $(context).find('#empty-input-message').hide(); // Sembunyikan pesan jika masih ada input
            }
        }

        // format Timestamps function
        function fetchDetailData(skemaID) {
            Swal.fire({
                title: 'Memuat...',
                text: 'Sedang Memproses!',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '/laporanperkembangan/fetchSkemaData/' + skemaID,
                type: "GET",
                dataType: "json",
                
                success: function(response) {
                    Swal.close();
                    if(response){
                        data_skema = response.data_skema;
                        data_penguji = response.data_penguji;
                        data_sub_skema = response.data_sub_skema;
                        data_peserta= response.data_peserta;
                        data_laporan_perkembangan = response.data_laporan_perkembangan;

                        var data_jumlah_sub_skema = response.jumlahSubSkemaPerEvent;
                        
                        // Input Disabled 
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

                        // Tampilkan hanya 2 penguji awal
                        var initialPenguji = data_penguji.event_skema_menguji.slice(0, 2).map(function(penguji) {
                            return penguji.nama_lengkap;
                        });
                        renderPenguji(initialPenguji);

                        // Tentukan apakah tombol "Selengkapnya" perlu ditampilkan
                        if (data_penguji.event_skema_menguji.length <= 2) {
                            btnSelengkapnya.style.display = 'none';
                        } else {
                            btnSelengkapnya.style.display = '';
                        }

                        // Tambahkan event listener untuk tombol Selengkapnya
                        btnSelengkapnya.addEventListener('click', function(event) {
                            event.preventDefault();
                            var allPenguji = data_penguji.event_skema_menguji.map(function(penguji) {
                                return penguji.nama_lengkap;
                            });
                            renderPenguji(allPenguji);
                            btnSelengkapnya.style.display = 'none'; 
                            btnSedikit.style.display = 'inline'; 
                        });

                        // Tambahkan event listener untuk tombol Sedikit
                        btnSedikit.addEventListener('click', function(event) {
                            event.preventDefault();
                            var initialPenguji = data_penguji.event_skema_menguji.slice(0, 2).map(function(penguji) {
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

                     $.each(data_peserta, function(index, row) {
                        var num = index + 1;
                        var buttonAction;

                        // Jika ada catatan, tampilkan tombol edit dan delete
                        if (row.catatan != null) {
                            buttonAction = 
                            '<li>\
                                <a href="#" class="dropdown-item text-info edit_laporan_btn" data-id="' + row.id_peserta + '">\
                                    <i class="fa-regular fa-pen-to-square"></i> Edit</a>\
                            </li>\
                            <li>\
                                <a href="#" class="dropdown-item text-danger delete_laporan_btn" data-id="' + row.id_peserta + '">\
                                    <i class="fa-regular fa-trash-can"></i> Delete</a>\
                            </li>';
                        } 
                        // Jika tidak ada catatan, tampilkan tombol tambah
                        else {
                            buttonAction = 
                            '<li>\
                                <a href="#" class="dropdown-item text-primary create_laporan_btn" data-id="' + row.id_peserta + '">\
                                    <i class="fa-regular fa-pen-to-square"></i> Tambah</a>\
                            </li>';
                        }

                        // Tampilkan data ke dalam tabel
                        $('tbody').append(
                            '<tr>\
                                <td>' + num + '</td>\
                                <td>' + (row.nama_lengkap || 'Nama tidak tersedia') + '</td>\
                                <td>' + (row.catatan || 'Tidak ada catatan') + '</td>\
                                <td>' + (row.tanggal_penilaian ? formatDate(row.tanggal_penilaian) : 'Tanggal tidak tersedia') + '</td>\
                                <td>\
                                    <div class="dropdown px-3">\
                                        <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"\
                                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">\
                                            <i class="fa-solid fa-bars"></i>\
                                        </a>\
                                        <ul id="dropdown-menu" class="dropdown-menu" aria-labelledby="dropdownMenuButton1">\
                                            ' + buttonAction + '\
                                        </ul>\
                                    </div>\
                                </td>\
                            </tr>'
                        );
                    });

                    $("#example").DataTable();

                    }
                },
                error: function() {
                    Swal.fire({
                        icon: 'error',
                        title: 'Gagal memuat data',
                        text: 'Tidak dapat mengambil data dari server!'
                    });
                }
                
            });
        }
       

        ///////

        // Event Dropdown
        $('#event_select').on('change', function() {
            var eventID = $(this).val();
            $('#search_btn').prop('disabled', true);

            if(eventID) {
                $.ajax({
                    url: '/laporanperkembangan/fetchEventData/'+eventID,
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
                }
            },
                });
            }

        });

        /////

        $('#skema_select').on('change', function() {
            skemaID = $(this).val();

            if (skemaID) {
                $('#search_btn').prop('disabled', false);
            }
        });

        // Search Button -- fetch Detail Data
        $('#search_btn').on('click', function() {
            $('input[type="text"]').val('');
            $('input[type="date"]').val('');
            $('input[type="checkbox"]').prop('checked', false);

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Data berhasil dicari.'
            });
            
            fetchDetailData(skemaID);
        
        });


        //muncul create kemampuan
        $('#addKemampuanCreate').click(function() {
            $('.kemampuan-wrapper-create').append(`<div class="row mb-3 kemampuan_dasar-input-create">
                <div class="col-md-6">
                    <input type="text" class="form-control" name="create_kemampuan_dasar[]" placeholder="Kemampuan Dasar" required>
                </div>
                <div class="col-md-4">
                    <select class="form-control" name="create_keterangan[]" required style="max-width: 120px; background-color: #d1ecf1;">
                        <option value="" disabled selected>Pilih Keterangan</option>
                        <option value="kurang">Kurang</option>
                        <option value="cukup">Cukup</option>
                        <option value="baik">Baik</option>
                        <option value="sangat baik">Sangat Baik</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <button class="btn btn-outline-danger rounded removeKemampuan" type="button">Remove</button>
                </div>
            </div>`);
            $('#empty-input-message').hide(); // Sembunyikan pesan jika input tidak kosong
            });

            // Fungsi untuk menghapus input Sub-Skema
            $(document).on('click', '.removeKemampuan', function() {
            $(this).closest('.kemampuan_dasar-input-create').remove(); // Hapus elemen input yang terkait

            // Check if there are no more inputs left
            if ($('.kemampuan_dasar-input-create').length === 0) {
                $('#empty-input-message').show(); // Show the message if no inputs are left
            }
        });      

        //muncul edit kemampuan
        $('#addKemampuanEdit').click(function() {
            $('.kemampuan-wrapper-edit').append('<div class="input-group mb-3 kemampuan_dasar-input-edit d-flex align-items-center">' +
            '<input type="text" class="form-control" name="edit_kemampuan_dasar[]" placeholder="Kemampuan Dasar" required>' +
            '<select class="form-control" name="edit_keterangan[]" required style="max-width: 120px; background-color: #d1ecf1;">' +
                '<option value="" disabled selected>Pilih Keterangan</option>' +
                '<option value="kurang">Kurang</option>' +
                '<option value="cukup">Cukup</option>' +
                '<option value="baik">Baik</option>' +
                '<option value="sangat baik">Sangat Baik</option>' +
            '</select>' +
            '<button class="btn btn-outline-danger rounded removeKemampuan" type="button">Remove</button>' +
            '</div>');
            checkEmptyInput('#empty-input-message'); // Sembunyikan pesan jika input tidak kosong
            });

            // Fungsi untuk menghapus input Sub-Skema
            $(document).on('click', '.removeKemampuan', function() {
            $(this).closest('.kemampuan_dasar-input-edit').remove(); // Hapus elemen input yang terkait

            // Check if there are no more inputs left
            if ($('.kemampuan_dasar-input-edit').length === 0) {
                $('#empty-input-message').show(); // Show the message if no inputs are left
            }
        });
        
        // Create Modal Trigger
        $(document).on('click', '.create_laporan_btn', function (e) {
            e.preventDefault();

            var pesertaID = $(this).data('id'); // Mengambil ID peserta dari tombol yang diklik
            console.log(pesertaID); 

            $('#create_name_peserta').val('');
            $('#peserta_id').val('');
            $('#event_skema_id').val('');
            $('#pengalaman_anak').val('');
            $('#peralatan_penunjang').val('');
            $('#saran').val('');

            $('input[name="create_kemampuan_dasar[]"]').each(function(){
                $(this).val('');
            });

            $('select[name="create_keterangan[]"]').each(function(){
                $(this).val('');
            });


            $('.kemampuan_dasar-input-create').remove(); // Clear only the inputs
            $('#empty-input-message').show();

            ['pengalaman_anak', 'peralatan_penunjang', 'saran'].forEach(function(field) {
                if (editors[field]) {
                    editors[field].destroy()
                        .then(() => {
                            delete editors[field]; // Hapus dari daftar editors
                        })
                        .catch(error => {
                            console.error(error);
                        });
                }
            });
           

            // Mengambil data peserta berdasarkan ID
            $.ajax({
                url: '/laporanperkembangan/fetchPesertaData/' + pesertaID,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    console.log(response); 
                    var data_peserta = response.data_peserta;     

                    // Tampilkan modal
                    $('#createLaporanModal').modal('show');                                  
                    $('#create_nama_peserta').val(data_peserta.nama_lengkap); // Mengisi nama peserta ke input
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
        $(document).on('click', '#store_laporan_btn', function () {
            // Mengambil nilai dari input
            var createdBy = $('#created_by').val();
            var pesertaID = $('#peserta_id').val(); 
            var eventSkemaID = $('#event_skema_id').val();
            var pengalamanAnak = editors['pengalaman_anak'] ? editors['pengalaman_anak'].getData() : ''; 
            var peralatanPenunjang = editors['peralatan_penunjang'] ? editors['peralatan_penunjang'].getData() : ''; 
            var saran = editors['saran'] ? editors['saran'].getData() : '';
            // var pengalamanAnak = $('#pengalaman_anak').val();
            // var kemampuanDasar = $('#kemampuan_dasar').val();
            // var peralatanPenunjang = $('#peralatan_penunjang').val();
            // var saran = $('#saran').val();

            var kemampuanDasar = [];
            $('input[name="create_kemampuan_dasar[]"]').each(function(){
                var value = $(this).val();
                if (value) { 
                    kemampuanDasar.push(value);
                }
            });

            var keterangan = [];
            $('select[name="create_keterangan[]"]').each(function(){
                var value = $(this).val();
                if(['kurang','cukup','baik','sangat baik'].includes(value)){
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

                            $('input[name="create_kemampuan_dasar[]"]').each(function(){
                                $(this).val('');
                            });

                            $('select[name="create_keterangan[]"]').each(function(){
                                $(this).val('');
                            });

                            // Clear the editor instances if they exist
                            ['pengalaman_anak', 'peralatan_penunjang', 'saran'].forEach(function(field) {
                                if (editors[field]) {
                                    editors[field].setData(''); // Clear the editor's content
                                }
                            });                        
                        Swal.fire({
                            icon: 'success',
                            title: 'Sukses!',
                            text: response.message, 
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops!',
                            text: response.message || 'Terjadi kesalahan saat membuat data.',
                        });
                    }
                    fetchDetailData(eventSkemaID); 
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

            // Edit Modal Trigger
            const fieldsToInitialize = ['edit_pengalaman_anak', 'edit_peralatan_penunjang', 'edit_saran'];                                
            let editors = {};

            $(document).on('click', '.edit_laporan_btn', function (e){
                e.preventDefault()

                console.log('Edit button clicked');  // Tambahkan ini untuk debugging
                pesertaID = $(this).data('id');
                console.log('Peserta ID: ', pesertaID);

                $('.kemampuan_dasar-input-edit').remove(); // Clear only the inputs
                $('#empty-input-message').show();

                $.ajax({
                    url: '/laporanperkembangan/fetchLaporanData/' + pesertaID,
                    type: "get",
                    dataType: "json",

                    success: function(response) {
                        console.log(response);
                        // var data_peserta_edit = response.data_nilai;
                        
                        $('#editLaporanModal').modal('show');
                    

                        $('#edite_id').val(response.data_laporan.peserta_id);

                        $('#edit_nama_peserta').val(response.data_laporan.nama_lengkap);
                        // $('#edit_pengalaman_anak').val(response.data_laporan.pengalaman_anak);
                        // // $('#edit_kemampuan_dasar').val(response.data_laporan.kemampuan_dasar);
                        // $('#edit_peralatan_penunjang').val(response.data_laporan.peralatan_penunjang);
                        // $('#edit_saran').val(response.data_laporan.saran);                    
                        
                        $('.kemampuan_dasar-input-edit').empty();

                            // Check if data_kemampuan_dasar exists and populate
                            if (response.data_kemampuan_dasar && response.data_kemampuan_dasar.length > 0) {
                                response.data_kemampuan_dasar.forEach(function(item) {
                                    $('.kemampuan-wrapper-edit').append('<div class="input-group mb-3 kemampuan_dasar-input-edit">' +
                                        '<input type="hidden" name="kemampuan_dasar_ids[]" value="' + item.id_kemampuan_dasar + '">' +
                                        '<input type="text" class="form-control" name="edit_kemampuan_dasar[' + item.id_kemampuan_dasar + ']" value="' + item.kemampuan_dasar + '" placeholder="Kemampuan Dasar" required>' +
                                        '<select class="form-control" name="edit_keterangan[' + item.id_kemampuan_dasar + ']" required style="max-width: 120px; background-color: #d1ecf1;">' +
                                            '<option value="" disabled>Pilih Keterangan</option>' +
                                            '<option value="kurang" ' + (item.keterangan === 'kurang' ? 'selected' : '') + '>Kurang</option>' +
                                            '<option value="cukup" ' + (item.keterangan === 'cukup' ? 'selected' : '') + '>Cukup</option>' +
                                            '<option value="baik" ' + (item.keterangan === 'baik' ? 'selected' : '') + '>Baik</option>' +
                                            '<option value="sangat baik" ' + (item.keterangan === 'sangat baik' ? 'selected' : '') + '>Sangat Baik</option>' +
                                        '</select>' +
                                        '<button class="btn btn-outline-danger rounded removeKemampuan" type="button">Remove</button>' +
                                    '</div>');
                                });
                                $('#empty-input-message').hide(); // Hide message if data exists
                            } else {
                                $('#empty-input-message').show(); // Show message if no data
                            }                        
                             fieldsToInitialize.forEach(field => {
                                const fieldElement = document.querySelector('#' + field);
                                if (fieldElement) {
                                    if (!editors[field]) {
                                        ClassicEditor
                                            .create(fieldElement)
                                            .then(editor => {
                                                editors[field] = editor;
                                                editor.setData(response.data_laporan[field.replace('edit_', '')] || '');
                                            })
                                            .catch(error => {
                                                console.error('CKEditor initialization error:', error);
                                            });
                                    } else {
                                        editors[field].setData(response.data_laporan[field.replace('edit_', '')] || '');
                                    }
                                }
                            });                           
                        console.log('ID peserta dari respons:', response.data_laporan.peserta_id);
                        },
                        error: function(xhr,status,error) {
                            console.error('AJAX error:' ,error);
                        }
                            
                    });
            });        


        //update function
        $(document).on('click','#update_laporan_btn',function(e){
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
            fieldsToInitialize.forEach(field => {
                if (editors[field]) {
                    // Transfer CKEditor data to the corresponding textarea
                    $('#' + field).val(editors[field].getData());
                }
            });

            let pengalamanAnak = $('#edit_pengalaman_anak').val() || ''; // Default ke string kosong jika tidak ada
            let peralatanPenunjang = $('#edit_peralatan_penunjang').val() || '';
            let saran = $('#edit_saran').val() || '';


            let kemampuanDasar = [];
            // let isValid = true; // Tambahkan flag untuk validasi          

            $('.kemampuan_dasar-input-edit').each(function() {
                let id = $(this).find('input[name="kemampuan_dasar_ids[]"]').val();
                let kemampuan = $(this).find('input[name="edit_kemampuan_dasar['+id+']"]').val();
                let keterangan = $(this).find('select[name="edit_keterangan['+id+']"]').val();
                
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
                url:'/laporanperkembangan/updateLaporan/' + pesertaID,
                type:"POST",
                data:{
                    "_token": $('meta[name="csrf-token"]').attr('content'), 
                    "pengalaman_anak": pengalamanAnak,
                    "kemampuan_dasar": kemampuanDasar,
                    "peralatan_penunjang": peralatanPenunjang,
                    "saran": saran,
                },
                success: function(response) {
                    if(response.status === 'success') {              
                    $('#editLaporanModal').modal('hide');                              
                    Swal.fire({
                        icon: 'success',
                        title: 'Sukses!',
                        text: 'Laporan berhasil diupdate!',
                        });               
                    }  else {
                        Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text: 'Terjadi kesalahan saat mengupdate data.',
                        });
                    }    
                    fetchDetailData(skemaID);
                },
                error: function(xhr, status, error) {
                    console.error('Error:', xhr.responseText);
                    // Tampilkan pesan error
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops!',
                        text:  'Terjadi kesalahan saat memproses permintaan.',
                    });
                }
            });
        })

        
        // Delete function
        $(document).on('click', '.delete_laporan_btn', function(e) {
            e.preventDefault()
            pesertaID = $(this).data('id')
            console.log('Peserta ID untuk hapus:', pesertaID);

            confirmDelete('Hapus Laporan Perkembangan Peserta', 'Apakah kamu yakin untuk menghapus?').then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/laporanperkembangan/destroyLaporanData/' + pesertaID,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                            pesertaID: pesertaID
                        },
                        success: function(response) {
                            console.log('Laporan perkembangan peserta berhasil dihapus');
                            fetchDetailData(skemaID)
                        },
                        error: function(xhr, status, error) {
                            console.error('Terjadi kesalahan saat menghapus nilai peserta:', error);
                        }
                    });
                }
            });
        });
        
    });

</script>
@endpush
