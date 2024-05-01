@extends('layouts.panel.index')
@section('title', 'Penilaian')
@section('content')


<div class="container mt-4">
    <div class="bg-white rounded-4 px-3 py-4 mb-3 shadow-lg">
        <div class="card-title mb-3 fw-semibold" style="font-size:18px">Pilih Event & Skema</div>

        <div class="d-flex flex-row mx-2">
            <div class="card-header me-2 w-100 mx-1">
                <select id="event_select" name="event_select" class="chosen-select form-control">
                    <option hidden disabled selected>Pilih Event</option>
                    @foreach ($event as $row)
                        <option value="{{ $row->id_event }}">{{ $row->nama_event }}</option>
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
<div class="modal fade" id="createNilaiModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
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
                <button type="submit" class="btn btn-success rounded-3 text-white" 
                    id="store_nilai_btn" value="1">Tambah</button>
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
                <button type="submit" class="btn btn-success rounded-3 text-white" 
                    id="store_nilai_btn" value="0">Simpan</button>
            </div>
        </div>
    </div>
</div>
            
@endsection

@push('script')
<script>
    $(".chosen-select").chosen()

    $(document).ready(function() {
        var skemaID;
        var event_skemaID
        var pesertaID;

        var data_nilai_peserta;
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

        // fetch Detail Data function
        function fetchDetailData(skemaID) {
            Swal.fire({
                title: 'Memuat...',
                text: 'Sabar wir.',
                allowOutsideClick: false,
                didOpen: () => {
                    Swal.showLoading();
                }
            });

            $.ajax({
                url: '/penilaian/fetchSkemaData/' + skemaID,
                type: "GET",
                dataType: "json",
                
                success: function(response) {
                    Swal.close();
                    if(response){
                        data_skema = response.data_skema;
                        data_penguji = response.data_penguji;
                        data_sub_skema = response.data_sub_skema;
                        data_nilai_peserta = response.data_nilai_peserta;

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

                        $.each(data_nilai_peserta, function(index, row) {
                            event_skemaID = row.id_event_skema;
                            var num = index + 1;
                            
                            // Kondisi -> Button aksi -- tabel nilai
                            var buttonAction;
                            if (row.banyak_nilai != null) {
                                buttonAction = 
                                '<li>\
                                    <a href="#" class="dropdown-item text-info edit_nilai_btn" data-id="' + row.id_peserta + '">\
                                        <i class="fa-regular fa-pen-to-square"></i>\
                                     Edit</a>\
                                </li>\
                                <li>\
                                    <a href="#" class="dropdown-item text-danger delete_nilai_btn" data-id="' + row.id_peserta + '">\
                                        <i class="fa-regular fa-trash-can pe-none"></i>\
                                     Delete</a>\
                                </li>'
                            } else {
                                buttonAction = 
                                '<li>\
                                    <a href="#" class="dropdown-item text-primary create_nilai_btn" data-id="' + row.id_peserta + '">\
                                        <i class="fa-regular fa-pen-to-square"></i>\
                                     Tambah</a>\
                                </li>'
                            }
                            
                            // Kondisi -> Keterangan nilai kosong -- tabel nilai
                            var banyakData, nilaiData;
                            if (row.banyak_nilai_nol == 0) {
                                banyakData = 'Nilai Lengkap';
                                nilaiData = formatNumber(row.avg_nilai)
                                inisialNilaiData = row.keterangan
                            } else if (row.banyak_nilai_nol == null) {
                                banyakData = '-';
                                nilaiData = '-'
                                inisialNilaiData = '-'
                            } else {
                                banyakData = '<span style="color: red; font-weight: bold;">Nilai kurang =  ' + row.banyak_nilai_nol + '</span>';
                                nilaiData = '<span style="color: red; font-weight: bold;"> ' + formatNumber(row.avg_nilai) + '</span>'
                                inisialNilaiData = '<span style="color: red; font-weight: bold;">Nilai Kurang wir</span>'
                            }

                            $('tbody').append(
                                '<tr>\
                                <td>' + num + '</td>\
                                <td>' + row.nama_lengkap + '</td>\
                                <td>' + banyakData +'</td>\
                                <td>' + nilaiData +'</td>\
                                <td>' + inisialNilaiData +'</td>\
                                <td>' + formatDate(data_skema.tgl_mulai) + '</td>\
                                <td class="text-center">\
                                    <div class="dropdown">\
                                        <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"\
                                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">\
                                            <i class="fa-solid fa-bars"></i>\
                                        </a>\
                                        <ul id="dropdown-menu" class="dropdown-menu" aria-labelledby="dropdownMenuButton1">\
                                            '+ buttonAction +'\
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

        // Event Dropdown
        $('#event_select').on('change', function() {
            var eventID = $(this).val();
            $('#search_btn').prop('disabled', true);

            if(eventID) {
                $.ajax({
                    url: '/penilaian/fetchEventData/'+eventID,
                    type: "GET",
                    dataType: "json",

                    success:function(response) {
                        if(response){
                            var data = response.data;

                            $('#skema_select').empty();
                            $('#skema_select').append('<option hidden disabled selected>Pilih Skema</option>'); 
                            
                            $.each(data, function(key, row){
                                $('select[id="skema_select"]').append('<option value="'+ row.id_skema +'">' + row.nama_skema+ '</option>');
                            });

                            $('#skema_select').trigger("chosen:updated");
                        }
                    }
                });
            }

        });

        // Skema Dropdown
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

        // Create Modal Trigger
        $(document).on('click', '.create_nilai_btn', function (e){
            e.preventDefault()
            pesertaID = $(this).data('id')

            $.ajax({
                url: '/penilaian/fetchPesertaData/' + pesertaID,
                type: "get",
                dataType: "json",

                success: function(response) {
                    var data_peserta_create = response.data_peserta;
                    
                    $('#createNilaiModal').modal('show');
                    $('#create_nama_peserta').val(data_peserta_create.nama_lengkap);
                    $('#create_nama_skema').val(data_skema.nama_skema);

                    $('#nilai-sub-skema-wrapper').html("")
                    $('.nilai_sub_skema').val('')

                    $.each(data_sub_skema, function(index, row) {
                        $('#nilai-sub-skema-wrapper').append(
                            '<div class="px-1 mb-3 row">\
                                <label class="col-sm-8 col-form-label" style="font-size: 18px;">'+row.judul_sub+'</label>\
                                <div class="col-sm-4 d-flex justify-content-end">\
                                    <label for="input nilai" class="text-white center bg-secondary rounded-start px-4 py-1"\
                                        style="height: 35px;">Nilai</label>\
                                    <input type="hidden" class="create_id_sub_skema" value="' + row.id_sub_skema + '">\
                                    <input type="number" class="form-control rounded-0 rounded-end create_nilai_sub_skema"\
                                        style="width: 100px; height: 35px;">\
                                </div>\
                            </div>'
                        );
                        
                    });
                    
                }
                
            });
        });

        // Edit Modal Trigger
        $(document).on('click', '.edit_nilai_btn', function (e){
            e.preventDefault()
            pesertaID = $(this).data('id')

            $.ajax({
                url: '/penilaian/fetchNilaiData/' + pesertaID,
                type: "get",
                dataType: "json",

                success: function(response) {
                    var data_peserta_edit = response.data_nilai;
                    
                    $('#editNilaiModal').modal('show');
                    $('#edit_nama_peserta').val(data_peserta_edit[0].nama_lengkap);
                    $('#edit_nama_skema').val(data_skema.nama_skema);

                    $('#edit-nilai-sub-skema-wrapper').html("")
                    $('.nilai_sub_skema').val('')
                    $.each(data_peserta_edit, function(index, row) {
                        $('#edit-nilai-sub-skema-wrapper').append(
                            '<div class="px-1 mb-3 row">\
                                <label class="col-sm-8 col-form-label" style="font-size: 18px;">'+row.judul_sub+'</label>\
                                <div class="col-sm-4 d-flex justify-content-end">\
                                    <label for="input nilai" class="text-white center bg-secondary rounded-start px-4 py-1"\
                                        style="height: 35px;">Nilai</label>\
                                    <input type="hidden" class="edit_id_sub_skema" value="' + row.sub_skema_id + '">\
                                    <input type="number" class="form-control rounded-0 rounded-end edit_nilai_sub_skema"\
                                        style="width: 100px; height: 35px;" value="' + row.nilai + '">\
                                </div>\
                            </div>'
                        );

                    });
                    
                }
                
            });
        });

        // Store function -- to store and update
        $(document).on('click', '#store_nilai_btn', function () {
            var btnIdentifier = $(this).val();
            var createdBy = $('#created_by').val();

            var create_nilai_data = [];
            var create_sub_skemaID = [];

            if (btnIdentifier != 0) {
                $('.create_id_sub_skema').each(function() {
                    var sub_skemaID = $(this).val();
                    create_sub_skemaID.push(sub_skemaID);
                });

                $('.create_nilai_sub_skema').each(function() {
                    var nilai = $(this).val();
                    create_nilai_data.push(nilai);
                });
            } else {
                $('.edit_id_sub_skema').each(function() {
                    var sub_skemaID = $(this).val();
                    create_sub_skemaID.push(sub_skemaID);
                });

                $('.edit_nilai_sub_skema').each(function() {
                    var nilai = $(this).val();
                    create_nilai_data.push(nilai);
                });
            }
            
            // looping for Create Associative Array
            var nilaiSubSkemaArray = {};
            for (var i = 0; i < create_sub_skemaID.length; i++) {
                nilaiSubSkemaArray[create_sub_skemaID[i]] = create_nilai_data[i];
            }

            // looping for Set null Data to 0
            Object.keys(nilaiSubSkemaArray).forEach(key => {
                if (nilaiSubSkemaArray[key] === "" || nilaiSubSkemaArray[key] == null) {
                    nilaiSubSkemaArray[key] = 0;
                }
            });

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/penilaian/storeNilaiData',
                type: 'POST',
                data: {
                    pesertaID: pesertaID,
                    event_skemaID: event_skemaID,
                    nilaiSubSkema: nilaiSubSkemaArray,
                    createdBy: createdBy
                },
                dataType: "json",

                success: function(response) {
                    $('#createNilaiModal').modal('hide');
                    $('#editNilaiModal').modal('hide');
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Nilai berhasil ditambahkan.'
                    });

                    fetchDetailData(skemaID);
                }
                    
            });
        })
        
        // Delete function
        $(document).on('click', '.delete_nilai_btn', function(e) {
            e.preventDefault()
            pesertaID = $(this).data('id')

            confirmDelete('Hapus Nilai Peserta', 'Apakah kamu yakin untuk menghapus?').then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/penilaian/destroyNilaiData/' + pesertaID,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                            pesertaID: pesertaID
                        },
                        success: function(response) {
                            console.log('Nilai peserta berhasil dihapus');
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