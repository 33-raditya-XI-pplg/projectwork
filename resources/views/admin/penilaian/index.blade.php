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
            <!-- <button type="submit" id="search_button"class="btn btn-secondary rounded-3 w-25 mx-1">Submit</button> -->

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
                                {{-- kanan --}}
                                @if (!empty($data_event_skema))
                                    @foreach ($data_event_skema as $row)
                                    <div class="row">
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="nama_ttd" class="form-label">Nama Event</label>
                                                <input type="text" class="form-control" id="nama_event" placeholder="kosong" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="jabatan" class="form-label">Tanggal Mulai</label>
                                                <input type="date" class="form-control" id="tgl_mulai" disabled>
                                            </div>
                                            <div class="form-check form-switch mb-3">
                                                <label class="form-check-label" for="flexSwitchCheckDefault">Status</label>
                                                <input class="form-check-input" type="checkbox" id="status" disabled {{ $row->status ? 'checked' : '' }}>
                                            </div>
                                        </div>
                                        <div class="col-6">
                                            <div class="mb-3">
                                                <label for="instansi" class="form-label">Jenis Event</label>
                                                <input type="text" class="form-control" id="jenis_event" placeholder="kosong" disabled>
                                            </div>
                                            <div class="mb-3">
                                                <label for="nik" class="form-label">Tanggal Selesai</label>
                                                <input type="date" class="form-control" id="tgl_selesai" disabled>
                                            </div>
                                        </div>
                                    </div>   
                                    @endforeach     
                                @else
                                <div class="row">
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="nama_ttd" class="form-label">Nama Event</label>
                                            <input type="text" class="form-control" id="nama_event" placeholder="kosong" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="jabatan" class="form-label">Tanggal Mulai</label>
                                            <input type="date" class="form-control" id="tgl_mulai" disabled>
                                        </div>
                                        <div class="form-check form-switch mb-3">
                                            <label class="form-check-label" for="flexSwitchCheckDefault">Status</label>
                                            <input class="form-check-input" type="checkbox" id="status" disabled>
                                        </div>
                                    </div>
                                    <div class="col-6">
                                        <div class="mb-3">
                                            <label for="instansi" class="form-label">Jenis Event</label>
                                            <input type="text" class="form-control" id="jenis_event" placeholder="kosong" disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label for="nik" class="form-label">Tanggal Selesai</label>
                                            <input type="date" class="form-control" id="tgl_selesai" disabled>
                                        </div>
                                    </div>
                                </div>   
                                @endif                  
                                    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="bg-white rounded-4 px-3 py-3 mb-3 shadow-lg">
                <table id="example" class="table">
                    <thead class="fw-normal">
                        <th scope="col">Nama Perserta</th>
                        <th scope="col">Nilai Peserta</th>
                        <th scope="col">Tanggal</th>
                        <th scope="col" class="text-center">Aksi</th>
                    </thead>
                    <tbody class="" style="vertical-align: middle">
                        @if (!empty($data_daftar_peserta))
                            @foreach ($data_daftar_peserta as $row)
                                <tr>
                                    <td>{{ $row->nama_lengkap }}</td>
                                    <td>Nilai Peserta</td>
                                    <td>Tanggal</td>
                                    <td class="text-center">
                                        <a href="{{route('penilaian.create')}}" class="btn btn-sm btn-secondary rounded">+ Input Nilai</a>
                                    </td>
                                </tr>
                            @endforeach
                        @else
                            <!-- Kosong -->
                        @endif
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
        $('#event_select').on('change', function() {
            var eventID = $(this).val();

            if(eventID) {
                $.ajax({
                    url: '/admin/penilaian/getEventData/'+eventID,
                    type: "GET",
                    data : {"_token":"{{ csrf_token() }}"},
                    dataType: "json",

                    success:function(data) {
                        
                        if(data){
                            $('#skema_select').empty();
                            $('#skema_select').append('<option hidden>Pilih Skema</option>'); 
                            $.each(data, function(key, row){
                                $('select[id="skema_select"]').append('<option value="'+ row.id_skema +'">' + row.nama_skema+ '</option>');
                            });
                            
                        }
                        else{
                            $('#skema_select').empty();
                        }
                    }
                });
            }
            else{
                $('#skema_select').empty();
            }
        });
    });
</script>
@endpush