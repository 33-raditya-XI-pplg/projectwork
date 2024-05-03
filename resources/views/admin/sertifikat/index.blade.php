@extends('layouts.panel.index')
@section('title', 'Sertifikat')
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
                                        <option hidden disabled selected>Kosong wir</option>
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
                                    <input type="text" class="form-control" id="nama_skema" placeholder="kosong" disabled>
                                </div>
                                <div class="mb-3">
                                    <label for="create_tgl_berakhir" class="form-label">Tanggal Berakhir</label>
                                    <input type="date" class="form-control" id="create_tgl_berakhir" disabled>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                <button type="submit" id="store_sertifikat_btn" class="btn btn-secondary rounded-3" value="1" disabled>Tambah</button>

            </div>
        </div>
    </div>

    <div class="container mt-2">
        <div class="bg-white rounded-4 px-3 py-3 mb-3 shadow-lg">
            <div class="card-header">
                <table id="example" class="table">
                    <thead class="fw-normal">
                        <th scope="col">No</th>
                        <th scope="col">Nama Perserta</th>
                        <th scope="col">Nomor Sertifikat</th>
                        <th scope="col">Tanggal Terbit</th>
                        <th scope="col">Masa Berlaku</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </thead>
                    <tbody class="" style="vertical-align: middle">
                        <!-- AJAX Response Here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('script')
<script>
    $(".chosen-select").chosen()

    $(document).ready(function() {
        var skemaID;
        var event_skemaID;
        var pesertaID;

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
                url: '/sertifikat/fetchPesertaData/' + skemaID,
                type: "GET",
                dataType: "json",
                
                success: function(response) {
                    Swal.close();
                    if(response){
                        var data_peserta = response.data_peserta;
                        var data_skema = response.data_skema;
                        var data_sertifikat = response.data_sertifikat;

                        event_skemaID = data_skema.id_event_skema;
                        
                        // Input Disabled 
                        $('#nama_skema').val(data_skema.nama_skema);

                        $('#create_tgl_terbit').prop('disabled', false);
                        $('#create_tgl_berakhir').prop('disabled', false);
                        $('#peserta_select').prop('disabled', false);

                        $('#peserta_select').empty();
                        $('#peserta_select').append('<option hidden disabled selected>Pilih Peserta</option>'); 
                        
                        $.each(data_peserta, function(key, row){
                            $('select[id="peserta_select"]').append('<option value="'+ row.id_peserta +'">' + row.nama_lengkap+ '</option>');
                        });

                        $('#peserta_select').trigger("chosen:updated");

                        // Table daftar peserta
                        $('#example').DataTable().destroy();
                        $('tbody').html("");

                        $.each(data_sertifikat, function(index, row) {
                            var num = index + 1;
                            $('tbody').append(
                                '<tr>\
                                <td>' + num + '</td>\
                                <td>' + row.nama_lengkap + '</td>\
                                <td>' + row.nomor_sertifikat +'</td>\
                                <td>' + row.tgl_terbit +'</td>\
                                <td>' + row.masa_berlaku +'</td>\
                                <td><a href="" class="btn btn-sm btn-secondary rounded">Cetak Sertifikat</a></td>\
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
            // $('input[type="text"]').val('');
            // $('input[type="date"]').val('');

            Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: 'Data berhasil dicari.'
            });
            
            fetchDetailData(skemaID);
        
        });

    // Store function -- to store and update
    $(document).on('click', '#store_sertifikat_btn', function (e) {
            e.preventDefault();
            var btnIdentifier = $(this).val();
            var createdBy = $('#created_by').val();

            var tgl_terbit;
            var tgl_berakhir;

            if (btnIdentifier != 0) {
                tgl_terbit = $('#create_tgl_terbit').val();
                tgl_berakhir = $('#create_tgl_berakhir').val();
            } 
            else {
                tgl_terbit = $('#edit_tgl_terbit').val();
                tgl_berakhir = $('#edit_tgl_berakhir').val();
       
            }

            const formData = {
                    pesertaID: $('#pesertaID').val(),
                    event_skemaID: $('#event_skemaID').val(),
                    tgl_terbit: $('#tgl_terbit').val(),
                    tgl_berakhir: $('#tgl_berakhir').val(),
                };

            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });

            $.ajax({
                url: '/sertifikat/storeSertifikatData',
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
                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil',
                        text: 'Nilai berhasil ditambahkan.'
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
        })
    })

</script>
@endpush