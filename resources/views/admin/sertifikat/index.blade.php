@extends('layouts.panel.index')
@section('title', 'Sertifikat')
@section('content')

    <div class="container mt-4">
        <div class="bg-white rounded-4 px-3 py-4 mb-3 shadow-lg">
            <div class="card-title mb-3 fw-semibold" style="font-size:18px">Pilih Event & Skema</div>
            <div class="d-flex flex-row mx-2">
                <div class="card-header me-2 w-100 mx-1">
                    <select id="event_select" name="event_select" class=" form-control js-example-basic-single" data-placeholder="Piih Event">
                        <option hidden disabled selected></option>
                        @foreach ($event as $row)
                            <option value="{{ $row->id_event }}">{{ $row->nama_event }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="card-header me-2 w-100 mx-1">
                    <select id="skema_select" name="skema_select" class=" form-control js-example-basic-single" data-placeholder="Pilih Event Dahulu">
                        <option hidden disabled selected></option>
                    </select>
                </div>
                <button id="search_btn" class="btn btn-secondary rounded-3 w-25 mx-1" disabled>Submit</button>
            </div>
        </div>
    </div>

    <div class="container mt-2">
        <div class="bg-white rounded-4 px-3 py-3 mb-3 shadow-lg">
            <div class="card-title mb-4 fw-semibold" style="font-size:18px">Detail Sertifikat</div>
            <div class="container">
                <div class="row">
                    <div class="col">
                        <div class="row">
                            <div class="col-6">
                                <input type="hidden" id="created_by" value="{{ Auth::user()->id_user }}">
                                <div class="mb-3">
                                    <label for="nama_ttd" class="form-label">Nama Peserta</label>
                                    <select class="chosen-select form-control" id="peserta_select" disabled>
                                        <option hidden disabled selected>Pilih Skema Dulu</option>
                                        <!-- Ajax Response Here -->
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="create_tgl_terbit" class="form-label">Tanggal terbit</label>
                                    <input type="date" class="form-control" id="create_tgl_terbit" disabled>
                                </div>
                            </div>
                            <div class="col-6">
                                <div class="mb-3">
                                    <label for="nama_skema" class="form-label">Nama Skema</label>
                                    <input type="text" class="form-control" id="nama_skema" placeholder="Pilih Skema Dulu" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="create_tgl_berakhir" class="form-label">Tanggal Berakhir</label>
                                    <input type="date" class="form-control" id="create_tgl_berakhir" disabled>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
                <button id="store_sertifikat_btn" class="btn btn-secondary rounded-3" value="1" disabled>Tambah</button>

            </div>
        </div>
    </div>

    <div class="container mt-2">
        <div class="bg-white rounded-4 px-3 py-3 mb-3 shadow-lg">
            <div class="card-header">
                <form id="export-form" action="{{ route('exportToPDF') }}" method="POST">
                    @csrf

                    <input type="hidden" name="event_skema_id" id="event_skema_id">
                    <button type="button" class="btn btn-secondary rounded-3 mb-3" id="cetak_sertifikat_btn"
                        onclick="submitForm()" disabled>Cetak
                    </button>

                    <table id="example" class="table">
                        <thead class="fw-normal">
                            <th><input type="checkbox" id="checkAll" disabled> </th>
                            <th scope="col">No</th>
                            <th scope="col">Nama Perserta</th>
                            <th scope="col">Nomor Sertifikat</th>
                            <th scope="col">Tanggal Terbit</th>
                            <th scope="col">Masa Berlaku</th>
                            <th scope="col">Aksi</th>
                        </thead>
                        <tbody class="" style="vertical-align: middle">
                            <!-- AJAX Response Here -->
                        </tbody>
                    </table>

                <iframe id="printFrame" name="printFrame" style="visibility: hidden; height: 0; width: 0;"></iframe>
            </div>
        </div>
    </div>

<!-- Edit -- Nilai Modal -->
<div class="modal fade" id="editSertifikatModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Edit Sertifikat Peserta</h5>
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

                <div class="mb-3">
                    <label for="edit_tgl_terbit" class="form-label">Tanggal Terbit</label>
                    <input type="date" class="form-control" id="edit_tgl_terbit">
                </div>
                <div class="mb-3">
                    <label for="edit_tgl_berakhir" class="form-label">Tanggal Berakhir</label>
                    <input type="date" class="form-control" id="edit_tgl_berakhir">
                </div>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Batal</button>
                <button type="submit" class="btn btn-success rounded-3 text-white"
                    id="store_sertifikat_btn" value="0">Simpan</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('script')
<script>
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
    </script>

<script>

    // submit Form Trigger function
    function submitForm() {
        var form = document.getElementById('export-form');

        Swal.fire({
            title: 'Memproses...',
            text: 'Sedang Memproses!',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });
        form.submit();
    }

    // checkbox if Checked function
    document.addEventListener('DOMContentLoaded', function () {
        var checkAllCheckbox = document.getElementById('checkAll');
        var printButton = document.getElementById('cetak_sertifikat_btn');
        var table = document.getElementById('example');

        checkAllCheckbox.addEventListener('click', function () {
            var checkboxes = document.querySelectorAll('input[name="selected_ids[]"]');
            for (var checkbox of checkboxes) {
                checkbox.checked = this.checked;
            }

            var selectedCheckboxes = document.querySelectorAll('input[name="selected_ids[]"]:checked');
            if (selectedCheckboxes.length > 0) {
                printButton.disabled = false;
            } else {
                printButton.disabled = true;
            }
        });

        table.addEventListener('change', function(event) {
            var target = event.target;

            if (target && target.id === 'selected_ids') {
                var checkboxes = table.querySelectorAll('#selected_ids:checked');

                if (checkboxes.length > 0) {
                    printButton.disabled = false;
                } else {
                    printButton.disabled = true;
                }
            }

        });
    });

    // format Timestamps function
    function formatTimestamps(dateString) {
        let dateOnly = new Date(dateString).toISOString().slice(0, 10);

        var dateParts = dateOnly.split("-");
        var year = dateParts[0];
        var month = dateParts[1];
        var day = dateParts[2];

        var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
                    'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];

        return day + ' ' + months[parseInt(month) - 1] + ' ' + year;
    }

    // ajax Request Here
    $(document).ready(function() {
        var skemaID;
        var event_skemaID;
        var pesertaID;

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

        // close Loading if Download Complete
        window.addEventListener('focus', function() {
            $('#cetak_sertifikat_btn').prop('disabled', true);

            var checkboxes = document.querySelectorAll('input[type="checkbox"]');
            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });

            // fetchDetailData(skemaID);
            Swal.close();
        });

        // fetch Detail Data function
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
                url: '/sertifikat/fetchPesertaData/' + skemaID,
                type: "GET",
                dataType: "json",

                success: function(response) {
                    Swal.close();

                    if(response){
                        var data_skema = response.data_skema;
                        var data_peserta = response.data_peserta;
                        var data_sertifikat = response.data_sertifikat;

                        var total_peserta = response.total_peserta;
                        var peserta_tanpa_nilai = response.data_peserta_tanpa_nilai.length;
                        var peserta_tanpa_sertifikat = response.data_peserta_tanpa_sertifikat.length;

                        event_skemaID = data_skema.id_event_skema; // update Variable

                        // Input Disabled
                        $('#nama_skema').val(data_skema.nama_skema);
                        $('#peserta_select').empty();
                        $('#event_skema_id').val(event_skemaID);

                        // Condition for select_peserta Dropdown
                        if (total_peserta != 0) {
                            if (peserta_tanpa_nilai != 0) {
                                // console.log('Nilai peserta tidak lengkap, tersisa' + peserta_tanpa_nilai)

                                Swal.fire({
                                    title: ' Nilai Peserta <span style="color: red;">Kurang '+peserta_tanpa_nilai+'</span>',
                                    html:
                                        'pada Skema <b>'+data_skema.nama_skema+'</b>',
                                    icon: 'info',
                                    footer: '<a href="{{ route('penilaian.index') }}">Tekan untuk Tambah Nilai...</a>'
                                });

                                $('#peserta_select').prop('disabled', true);
                                $('#create_tgl_terbit').prop('disabled', true);
                                $('#create_tgl_berakhir').prop('disabled', true);
                                $('#store_sertifikat_btn').prop('disabled', true);

                                $('#peserta_select').append('<option hidden disabled selected>\
                                    <span style="color: red; font-weight: bold;">Nilai peserta kurang</span>\
                                </option>');
                            } else {
                                if (peserta_tanpa_sertifikat != 0) {
                                    // console.log('Peserta Kurang' + peserta_tanpa_sertifikat)

                                    $('#create_tgl_terbit').prop('disabled', false);
                                    $('#create_tgl_berakhir').prop('disabled', false);
                                    $('#peserta_select').prop('disabled', false);
                                    $('#store_sertifikat_btn').prop('disabled', true);

                                    $('#peserta_select').append('<option hidden disabled selected>\
                                        <span style="color: green; font-weight: bold;">Sertifikat siap dibuat</span>\
                                    </option>');
                                    $('#peserta_select').append('<option value="all">Semua Peserta</option>')
                                } else {
                                    // console.log('Semua Peserta Memiliki Nilai')

                                    $('#peserta_select').prop('disabled', true);
                                    $('#create_tgl_terbit').prop('disabled', true);
                                    $('#create_tgl_berakhir').prop('disabled', true);
                                    $('#store_sertifikat_btn').prop('disabled', true);

                                    $('#peserta_select').append('<option hidden disabled selected>\
                                        <span style="color: red; font-weight: bold;">Semua Peserta telah memiliki Sertifikat</span>\
                                    </option>');
                                }
                            }
                        } else {
                            // console.log('Tidak ada peserta')
                            Swal.fire({
                                title: 'Tidak ada peserta pada <span style="color: red;">'+data_skema.nama_skema+'</span>',
                                text: 'Tambah Peserta dulu',
                                icon: 'info',
                            });

                            $('#peserta_select').prop('disabled', true);
                            $('#create_tgl_terbit').prop('disabled', true);
                            $('#create_tgl_berakhir').prop('disabled', true);
                            $('#store_sertifikat_btn').prop('disabled', true);

                            $('select[id="peserta_select"]').append('<option disabled selected>Tidak Ada Peserta</option>');
                        }

                        total_peserta !=

                        $('#peserta_select').trigger("chosen:updated");

                        // Memeriksa apakah tabel memiliki data
                        data_sertifikat == 0 ?
                            $('#checkAll').prop('disabled', true) :
                            $('#checkAll').prop('disabled', false)

                        // Table daftar peserta
                        $('#example').DataTable().destroy();
                        $('tbody').html("");

                        $.each(data_sertifikat, function(index, row) {
                            var num = index + 1;

                            var buttonAction =
                            '<li>\
                                <a href="#" class="dropdown-item text-success print_sertifikat_btn" onclick="printCertificate(' + row.id_peserta + ')"">\
                                    <i class="fa-solid fa-book-open"></i>\
                                    Lihat</a>\
                            </li>\
                            <li>\
                                <a href="#" class="dropdown-item text-info edit_sertifikat_btn" data-id="' + row.id_peserta + '">\
                                    <i class="fa-regular fa-pen-to-square"></i>\
                                    Edit</a>\
                            </li>\
                            <li>\
                            <li>\
                                <a href="#" class="dropdown-item text-danger delete_sertifikat_btn" data-id="' + row.id_peserta + '">\
                                    <i class="fa-regular fa-trash-can pe-none"></i>\
                                    Delete</a>\
                            </li>'

                            $('tbody').append(
                                '<tr>\
                                <td><input type="checkbox" name="selected_ids[]" id="selected_ids" value="'+ row.id_peserta +'"></td>\
                                <td>' + num + '</td>\
                                <td>' + row.nama_lengkap + '</td>\
                                <td>' + row.nomor_sertifikat +'</td>\
                                <td>' + formatTimestamps(row.tgl_terbit) +'</td>\
                                <td>' + row.masa_berlaku +'</td>\
                                <td>\
                                    <div class="dropdown px-3">\
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

        // Peserta Dropdown
        $('#peserta_select').on('change', function() {
            pesertaID = $(this).val();
            $('#store_sertifikat_btn').prop('disabled', false);
        });

        // Search Button -- fetch Detail Data
        $('#search_btn').on('click', function() {
            $('input[type="text"]').val('');
            $('input[type="date"]').val('');
            var checkboxes = document.querySelectorAll('input[type="checkbox"]');

            checkboxes.forEach(function(checkbox) {
                checkbox.checked = false;
            });

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Data berhasil dicari.'
            });

            fetchDetailData(skemaID);
        });

        // --- Tambahan agar data tetap muncul setelah refresh ---
        if (localStorage.getItem('event_select')) {
            $('#event_select').val(localStorage.getItem('event_select')).trigger('change');
        }
        if (localStorage.getItem('skema_select')) {
            setTimeout(function() {
                $('#skema_select').val(localStorage.getItem('skema_select')).trigger('change');
                $('#search_btn').prop('disabled', false);
                // Auto-fetch data setelah refresh jika event & skema sudah dipilih
                fetchDetailData(localStorage.getItem('skema_select'));
            }, 500);
        }

        $('#event_select').on('change', function() {
            localStorage.setItem('event_select', $(this).val());
            localStorage.removeItem('skema_select');
        });
        $('#skema_select').on('change', function() {
            localStorage.setItem('skema_select', $(this).val());
        });
        $('#search_btn').on('click', function() {
            localStorage.setItem('event_select', $('#event_select').val());
            localStorage.setItem('skema_select', $('#skema_select').val());
        });

        // Store function -- to store and update
        $(document).on('click', '#store_sertifikat_btn', function (e) {
            e.preventDefault();
            var btnIdentifier = $(this).val();
            var createdBy = $('#created_by').val();

            var tgl_terbit;
            var tgl_berakhir;

            if (btnIdentifier != 0) {   // to Create Sertifikat Data
                tgl_terbit = $('#create_tgl_terbit').val();
                tgl_berakhir = $('#create_tgl_berakhir').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '/sertifikat/storeSertifikatData',
                    type: 'POST',
                    data: {
                        option: pesertaID,
                        event_skemaID: event_skemaID,
                        tgl_terbit: tgl_terbit,
                        tgl_berakhir: tgl_berakhir,
                        createdBy: createdBy
                    },
                    dataType: "json",

                    success: function(response) {
                        $('#editSertifikatModal').modal('hide');
                        $('input[type="date"]').val('');

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Sertifikat berhasil ditambahkan.'
                        });

                        fetchDetailData(skemaID);
                    },
                    error: function(xhr, status, error) {
                        console.error('Terjadi kesalahan saat menambahkan sertifikat peserta:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Sertifikat gagal ditambahkan.'
                        });

                    }

                });
            }
            else {                      // to Update Sertifikat Data
                tgl_terbit = $('#edit_tgl_terbit').val();
                tgl_berakhir = $('#edit_tgl_berakhir').val();

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });

                $.ajax({
                    url: '/sertifikat/updateSertifikatData',
                    type: 'POST',
                    data: {
                        pesertaID: pesertaID,
                        event_skemaID: event_skemaID,
                        tgl_terbit: tgl_terbit,
                        tgl_berakhir: tgl_berakhir,
                        createdBy: createdBy
                    },
                    dataType: "json",

                    success: function(response) {
                        $('#editSertifikatModal').modal('hide');
                        $('input[type="date"]').val('');

                        Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: 'Sertifikat berhasil diperbarui.'
                        });

                        fetchDetailData(skemaID);
                    },
                    error: function(xhr, status, error) {
                        // console.error('Terjadi kesalahan saat menambahkan sertifikat peserta:', error);
                        Swal.fire({
                            icon: 'error',
                            title: 'Gagal',
                            text: 'Sertifikat gagal diperbarui.'
                        });

                    }

                });
            }

        })

        // Edit Modal Trigger
        $(document).on('click', '.edit_sertifikat_btn', function (e){
            e.preventDefault()
            pesertaID = $(this).data('id')

            $.ajax({
                url: '/sertifikat/fetchSertifikatData/' + pesertaID,
                type: "get",
                dataType: "json",

                success: function(response) {
                    var data_sertifikat_peserta = response.data_sertifikat_peserta;

                    $('#editSertifikatModal').modal('show');

                    $('#edit_nama_peserta').val(data_sertifikat_peserta.nama_lengkap);
                    $('#edit_nama_skema').val(data_sertifikat_peserta.nama_skema);

                    $('#edit_tgl_terbit').val(data_sertifikat_peserta.tgl_terbit);
                    $('#edit_tgl_berakhir').val(data_sertifikat_peserta.tgl_berakhir);

                }

            });
        });

        // Delete function
        $(document).on('click', '.delete_sertifikat_btn', function(e) {
            e.preventDefault()
            pesertaID = $(this).data('id')

            confirmDelete('Hapus Sertifikat Peserta', 'Apakah kamu yakin untuk menghapus?').then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: '/sertifikat/destroySertifikatData/' + pesertaID,
                        type: 'DELETE',
                        data: {
                            _token: '{{ csrf_token() }}',
                            pesertaID: pesertaID
                        },
                        success: function(response) {
                            console.log('Sertifikat peserta berhasil dihapus');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: 'Sertifikat peserta berhasil dihapus'
                            });

                            fetchDetailData(skemaID)
                        },
                        error: function(xhr, status, error) {
                            console.error('Terjadi kesalahan saat menghapus sertifikat peserta:', error);
                        }
                    });
                }
            });
        });



    });

    function printCertificate(id) {
        var printFrame = document.getElementById('printFrame');
        printFrame.src = '/sertifikat/showSertifikat/' +id+ '/pdf';

        printFrame.onload = function() {
            // window.frames['printFrame'].focus();
            window.frames['printFrame'].print();
        };

        Swal.fire({
            title: 'Memuat...',
            text: 'Sedang Memproses!',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });


    }

</script>
@endpush
