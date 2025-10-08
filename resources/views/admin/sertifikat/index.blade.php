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
                                    <label for="create_tgl_berakhir" class="form-label">Tanggal Berakhir (Opsional)</label>
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
                    <label for="edit_tgl_berakhir" class="form-label">Tanggal Berakhir </label>
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
        // ================== 1. INISIALISASI PLUGIN ==================
        $('.js-example-basic-single').each(function() {
            var placeholder = $(this).data('placeholder');
            $(this).select2({
                placeholder: placeholder,
                allowClear: true,
                theme: "bootstrap-5" // Menambahkan theme agar konsisten
            });
        });

        // Menambahkan placeholder dinamis saat select2 dibuka
        $('.js-example-basic-single').on('select2:open', function(e) {
            const elementId = $(this).attr('id');
            let placeholderText = 'Cari...';
            if (elementId === 'event_select') {
                placeholderText = 'Cari Event...';
            } else if (elementId === 'skema_select') {
                placeholderText = 'Cari Skema...';
            } else if (elementId === 'peserta_select') {
                placeholderText = 'Cari Peserta...';
            }
            // Penyesuaian selector untuk tema bootstrap-5
            $('.select2-search__field[aria-controls="select2-' + elementId + '-results"]').attr('placeholder', placeholderText);
        });

        // ================== DEKLARASI VARIABEL ==================
        var skemaID;
        var eventID;
        var pesertaID;
        var event_skemaID;

        // ================== FUNGSI-FUNGSI HELPER ==================
        function confirmDelete(title, text) {
            return Swal.fire({
                title: title, text: text, icon: 'warning',
                showCancelButton: true, confirmButtonText: 'Ya, hapus', cancelButtonText: 'Batal'
            });
        }

        function submitForm() {
            Swal.fire({
                title: 'Memproses...', text: 'Sedang membuat file PDF!',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });
            $('#export-form').submit();
        }

        // Make this function global so inline onclick handlers can call it
        window.printCertificate = function(id) {
            Swal.fire({
                title: 'Memuat Pratinjau...', text: 'Sedang memproses sertifikat!',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            var printFrame = document.getElementById('printFrame');
            printFrame.src = `/sertifikat/showSertifikat/${id}/pdf`;
            printFrame.onload = function() {
                // Swal ditutup oleh event listener 'focus'
                this.contentWindow.print();
            };
        };

        function formatTimestamps(dateString) {
            if (!dateString) return '-';
            let date = new Date(dateString);
            let day = String(date.getDate()).padStart(2, '0');
            let monthIndex = date.getMonth();
            let year = date.getFullYear();
            var months = ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'];
            return `${day} ${months[monthIndex]} ${year}`;
        }

        // ================== FUNGSI UTAMA (FETCH DATA & RENDER) ==================
        function fetchDetailData(selectedSkemaID) {
            Swal.fire({
                title: 'Memuat...', text: 'Sedang mengambil data sertifikat!',
                allowOutsideClick: false,
                didOpen: () => { Swal.showLoading(); }
            });

            $.ajax({
                url: `/sertifikat/fetchPesertaData/${selectedSkemaID}/${eventID}`,
                type: "GET",
                dataType: "json",
                success: function(response) {
                    if (!response) {
                        Swal.fire('Error', 'Tidak ada respons dari server.', 'error');
                        return;
                    }

                    const { data_skema, data_peserta_tanpa_sertifikat, data_sertifikat, total_peserta, data_peserta_tanpa_nilai } = response;
                    const peserta_tanpa_nilai_count = data_peserta_tanpa_nilai.length;
                    const peserta_tanpa_sertifikat_count = data_peserta_tanpa_sertifikat.length;

                    event_skemaID = data_skema.id_event_skema;
                    $('#nama_skema').val(data_skema.nama_skema);
                    $('#event_skema_id').val(event_skemaID);

                    // Atur Dropdown Peserta
                    const $pesertaSelect = $('#peserta_select');
                    const $createInputs = $('#create_tgl_terbit, #create_tgl_berakhir');
                    const $storeBtn = $('#store_sertifikat_btn[value="1"]');

                    $pesertaSelect.empty().append('<option></option>'); // Reset
                    $createInputs.prop('disabled', true);
                    $storeBtn.prop('disabled', true);

                    if (total_peserta === 0) {
                        Swal.fire('Informasi', `Tidak ada peserta pada skema <b>${data_skema.nama_skema}</b>.`, 'info');
                        $pesertaSelect.prop('disabled', true);
                    } else if (peserta_tanpa_nilai_count > 0) {
                        Swal.fire({
                            title: `Nilai Peserta Kurang (${peserta_tanpa_nilai_count})`,
                            html: `pada Skema <b>${data_skema.nama_skema}</b>`,
                            icon: 'warning',
                            footer: '<a href="{{ route("penilaian.index") }}">Lengkapi nilai sekarang...</a>'
                        });
                        $pesertaSelect.prop('disabled', true);
                    } else if (peserta_tanpa_sertifikat_count > 0) {
                        $pesertaSelect.prop('disabled', false);
                        $createInputs.prop('disabled', false);
                        $pesertaSelect.append('<option value="all">Buatkan Untuk Semua Peserta</option>');
                        $.each(data_peserta_tanpa_sertifikat, function(key, peserta) {
                            $pesertaSelect.append(`<option value="${peserta.id_peserta}">${peserta.nama_lengkap}</option>`);
                        });
                    } else {
                        // Tidak perlu sweetalert jika semua sudah punya sertifikat, cukup disable form
                        $pesertaSelect.prop('disabled', true);
                    }
                    $pesertaSelect.trigger('change');

                    // Render Tabel Sertifikat
                    if ($.fn.DataTable.isDataTable('#example')) {
                        $('#example').DataTable().destroy();
                    }
                    $('#example tbody').html("");
                    $('#checkAll').prop('disabled', data_sertifikat.length === 0);

                    $.each(data_sertifikat, function(index, row) {
                        const num = index + 1;
                        const masaBerlaku = row.masa_berlaku || '-';
                        const buttonAction = `
                            <button type="button" class="btn btn-success btn-sm me-1 text-white rounded mb-1 print_sertifikat_btn" data-id="${row.id_peserta}"><i class="fa-solid fa-print"></i> Lihat</button>
                            <button type="button" class="btn btn-info btn-sm edit_sertifikat_btn me-1 text-white rounded mb-1" data-id="${row.id_peserta}"><i class="fa-regular fa-pen-to-square"></i> Edit</button>
                            <button type="button" class="btn btn-danger btn-sm delete_sertifikat_btn rounded mb-1" data-id="${row.id_peserta}"><i class="fa-regular fa-trash-can"></i> Delete</button>`;

                        $('#example tbody').append(`
                            <tr>
                                <td><input type="checkbox" name="selected_ids[]" class="sertifikat_checkbox" value="${row.id_peserta}"></td>
                                <td>${num}</td>
                                <td>${row.nama_lengkap}</td>
                                <td>${row.nomor_sertifikat}</td>
                                <td>${formatTimestamps(row.tgl_terbit)}</td>
                                <td>${masaBerlaku}</td>
                                <td class="text-center">${buttonAction}</td>
                            </tr>`);
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
                            $.each(response.data, (key, row) => $('#skema_select').append(`<option value="${row.id_skema}">${row.nama_skema}</option>`));
                        }
                        $('#skema_select').prop('disabled', false);
                        Swal.close();
                    },
                    error: () => Swal.fire('Error', 'Gagal memuat data skema.', 'error')
                });
            }
        });

        $('#skema_select').on('change', function() {
            skemaID = $(this).val();
            $('#search_btn').prop('disabled', !skemaID);
        });

        $('#peserta_select').on('change', function() {
            pesertaID = $(this).val();
            $('#store_sertifikat_btn[value="1"]').prop('disabled', !pesertaID);
        });

        $('#search_btn').on('click', function() {
            if (skemaID && eventID) {
                $('input[type="date"], input[type="text"]').val('');
                $('.sertifikat_checkbox, #checkAll').prop('checked', false);
                $('#cetak_sertifikat_btn').prop('disabled', true);
                fetchDetailData(skemaID);
            } else {
                Swal.fire('Peringatan', 'Silakan pilih event dan skema terlebih dahulu!', 'warning');
            }
        });

        $(document).on('click', '#store_sertifikat_btn', function(e) {
            e.preventDefault();
            const btnIdentifier = $(this).val();
            const createdBy = $('#created_by').val();
            const isUpdate = btnIdentifier == 0;

            const data = {
                event_skemaID: event_skemaID,
                tgl_terbit: isUpdate ? $('#edit_tgl_terbit').val() : $('#create_tgl_terbit').val(),
                tgl_berakhir: isUpdate ? $('#edit_tgl_berakhir').val() : $('#create_tgl_berakhir').val(),
                createdBy: createdBy
            };

            if (isUpdate) {
                data.pesertaID = pesertaID;
            } else {
                data.option = pesertaID;
            }

            const url = isUpdate ? '/sertifikat/updateSertifikatData' : '/sertifikat/storeSertifikatData';
            const successMsg = `Sertifikat berhasil ${isUpdate ? 'diperbarui' : 'ditambahkan'}.`;
            const errorMsg = `Sertifikat gagal ${isUpdate ? 'diperbarui' : 'ditambahkan'}.`;

            $.ajax({
                url: url, type: 'POST',
                headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                data: data,
                success: function() {
                    $('#editSertifikatModal').modal('hide');
                    $('input[type="date"]').val('');
                    Swal.fire('Berhasil', successMsg, 'success');
                    fetchDetailData(skemaID);
                },
                error: () => Swal.fire('Gagal', errorMsg, 'error')
            });
        });

        $(document).on('click', '.edit_sertifikat_btn', function(e) {
            e.preventDefault();
            pesertaID = $(this).data('id');
            $.ajax({
                url: `/sertifikat/fetchSertifikatData/${pesertaID}`,
                type: "GET", dataType: "json",
                success: function(response) {
                    const data = response.data_sertifikat_peserta;
                    $('#edit_nama_peserta').val(data.nama_lengkap);
                    $('#edit_nama_skema').val(data.nama_skema);
                    $('#edit_tgl_terbit').val(data.tgl_terbit);
                    $('#edit_tgl_berakhir').val(data.tgl_berakhir);
                    $('#editSertifikatModal').modal('show');
                }
            });
        });

        $(document).on('click', '.delete_sertifikat_btn', function(e) {
            e.preventDefault();
            pesertaID = $(this).data('id');
            confirmDelete('Hapus Sertifikat', 'Anda yakin ingin menghapus sertifikat peserta ini?').then((result) => {
                if (result.isConfirmed) {
                    $.ajax({
                        url: `/sertifikat/destroySertifikatData/${pesertaID}`,
                        type: 'DELETE',
                        headers: { 'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content') },
                        success: function() {
                            Swal.fire('Berhasil', 'Sertifikat peserta berhasil dihapus.', 'success');
                            fetchDetailData(skemaID);
                        },
                        error: () => Swal.fire('Gagal', 'Terjadi kesalahan saat menghapus.', 'error')
                    });
                }
            });
        });

        // Delegated handler for printing certificate (replaces inline onclick)
        $(document).on('click', '.print_sertifikat_btn', function(e) {
            e.preventDefault();
            const id = $(this).data('id');
            if (id) window.printCertificate(id);
        });

        // Event handler untuk checkbox
        $('#checkAll').on('click', function() {
            $('.sertifikat_checkbox').prop('checked', this.checked).trigger('change');
        });

        $(document).on('change', '.sertifikat_checkbox', function() {
            const anyChecked = $('.sertifikat_checkbox:checked').length > 0;
            $('#cetak_sertifikat_btn').prop('disabled', !anyChecked);
        });

        // Event listener untuk menutup swal loading setelah cetak
        window.addEventListener('focus', function() {
            if (Swal.isVisible() && Swal.isLoading()) {
                Swal.close();
            }
        });
    });
</script>
@endpush
