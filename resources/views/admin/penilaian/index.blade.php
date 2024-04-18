@extends('layouts.panel.index')
@section('title', 'Penilaian')
@section('content')


<div class="container mt-4">
    <div class="bg-white rounded-4 px-3 py-4 mb-3 shadow-lg">
        <div class="card-title mb-3 fw-semibold" style="font-size:18px">Pilih Event & Skema</div>

        <div class="d-flex flex-row mx-2">
        <div class="card-header me-2 w-100 mx-1">
                <select id="event_select" name="event_select" class="form-select w-100 btn btn-secondary py-2 w-100 rounded-3 text-white">
                    <option disabled selected>Pilih Event</option>
                    @foreach ($event as $row)
                        <option value="{{ $row->id_event }}">{{ $row->nama_event }}</option>
                    @endforeach                        
                </select>
            </div>
            <div class="card-header me-2 w-100 mx-1 ">
                <select id="skema_select" name="skema_select" class="form-select w-100 btn btn-secondary text-white py-2 w-100 rounded-3">
                    <option hidden>Pilih Event Dahulu</option>
                    
                </select>
            </div>
            <button id="search_btn" class="btn btn-secondary rounded-3 w-25 mx-1">Submit</button>

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
                                                <input type="date" class="form-control" id="tgl_mulai" disabled>
                                            </div>
                                            <div class="form-check form-switch mb-3">
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
                                                <label for="tempat_skema" class="form-label">Tempat</label>
                                                <input type="text" class="form-control" id="tempat_skema" placeholder="kosong" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                                                <input type="date" class="form-control" id="tgl_selesai" disabled>
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
                        <th>No</th>
                        <th scope="col">Nama Perserta</th>
                        <th scope="col">Nilai Peserta</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </thead>
                    <tbody id="list_peserta" style="vertical-align: middle">
                        <!-- AJAX Response Here -->
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
            
@endsection

@push('script')
<script>
    $(document).ready(function() {
        var eventID;

        $('#event_select').on('change', function() {
            eventID = $(this).val();

            if(eventID) {
                $.ajax({
                    url: '/penilaian/getEventData/'+eventID,
                    type: "GET",
                    data : {"_token":"{{ csrf_token() }}"},
                    dataType: "json",

                    success:function(response) {
                        if(response){
                            var data = response.data;

                            $('#skema_select').empty();
                            $('#skema_select').append('<option hidden>Pilih Skema</option>'); 

                            $.each(data, function(key, row){
                                $('select[id="skema_select"]').append('<option value="'+ row.id_skema +'">' + row.nama_skema+ '</option>');
                            });
                    
                        }
                    }
                });
            }

        });

        $('#skema_select').on('change', function() {
            var skemaID = $(this).val();

            $('#search_btn').on('click', function() {
                clearInputField();

                $.ajax({
                    url: '/penilaian/getSkemaData/'+skemaID,
                    type: "GET",
                    data : {"_token":"{{ csrf_token() }}"},
                    dataType: "json",
                    
                    success:function(response) {
                        if(response){
                            var data_skema = response.data_skema[0];
                            var data_peserta = response.data_peserta;
                            
                            // Input Disabled 
                            $('#nama_event').val(data_skema.nama_event);
                            $('#jenis_event').val(data_skema.nama_jenis_event);

                            $('#nama_skema').val(data_skema.nama_skema);
                            $('#tempat_skema').val(data_skema.nama_tempat);

                            $('#tgl_mulai').val(data_skema.tgl_mulai);
                            $('#tgl_selesai').val(data_skema.tgl_berakhir);

                            if (data_skema.status === "Aktif") {
                                $('#status').prop('checked', true);
                            } else {
                                $('#status').prop('checked', false);
                            }

                            // Table daftar peserta
                            $('tbody').empty();
                            $.each(data_peserta, function(index, row) {
                                var num = index + 1;
                                // $('$#list_peserta').append(
                                //     '<tr>' +
                                //     '<td>' + num + '</td>' +
                                //     '<td>' + row.nama_lengkap + '</td>' +
                                //     '<td>' + row.id_event_skema + '</td>' +
                                //     '<td>' + data_skema.tgl_mulai + '</td>' +
                                //     '</tr>'
                                // );
                                $('tbody').append(
                                    '<tr>\
                                    <td>' + num + '</td>\
                                    <td>' + row.nama_lengkap + '</td>\
                                    <td>' + row.id_event_skema + '</td>\
                                    <td>' + data_skema.tgl_mulai + '</td>\
                                    <td><button class="btn btn-primary btn-sm rounded">Edit</button>\
                                    <button class="btn btn-danger btn-sm rounded">Delete</button></td>\
                                    </tr>'
                                );
                            });

                        }
                    }
                    
                });
            
            });
        });

        // // Optional: Handler untuk tombol edit dan delete
        // $('#list_peserta').on('click', '.edit-btn', function() {
        //     var id = $(this).data('id');
        //     console.log('Edit ID: ' + id);
        //     // Tambahkan logika edit di sini
        // });

        // $('#list_peserta').on('click', '.delete-btn', function() {
        //     var id = $(this).data('id');
        //     console.log('Delete ID: ' + id);
        //     // Tambahkan logika delete di sini
        // });

        function clearInputField() {
            $('input[type="text"]').val('');
            $('input[type="checkbox"]').prop('checked', false);
        }

    });

</script>
@endpush