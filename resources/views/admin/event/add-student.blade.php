@extends('layouts.panel.index')
@section('title', 'Kegiatan')
@section('content')


    <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
        <div class="d-flex align-items-center mb-4">
            <a class="btn btn-danger rounded" href="{{ route('event-skema.show', [$evt, $skema]) }}"><i class="fa-solid fa-angles-left"></i><small class="fw-bold">Kembali</small></a>
            <select id="instansi" class="form-select mb-4 mx-3">
                <option class="text-center" selected>Select Instansi</option>
                @foreach ($instansi as $list)
                <option class="text-center" value="{{ $list->id_instansi }}">{{ $list->nama_instansi }}</option>
                @endforeach
            </select>
            <a class="btn btn-primary rounded pe-none px-4" id="show-peserta" href="javascript:void(0)"><i class="fa-solid fa-magnifying-glass"></i><small class="fw-bold">Cari</small></a>
        </div>
        
        <table id="peserta" class="table rounded">
            <thead>
                <th style="width: 5%;"><input id="selectAll" class="form-check-input" type="checkbox"></th>
                <th class="">Nama Peserta</th>
                <th class="">Email</th>
                <th class="">Jenis Kelamin</th>
            </thead>
            <tbody>

            </tbody>
        </table>
        <div class="d-grid mt-4 mx-2">
            <a class="btn btn-primary rounded" href="#">Simpan Peserta</a>
        </div>
    </div>

@endsection
@push('script')
    <script>
        var table = $('#peserta').DataTable();
        // search peserta
        $(document).ready(function() {
            $('#instansi').on('change', function() {
                if (!isNaN($(this).val())) {
                    $('#show-peserta').removeClass('pe-none');
                } else {
                    $('#show-peserta').addClass('pe-none')
                };
            })

            $('#show-peserta').on('click', function() {
            var id = $('#instansi').val();
            url = "{{ route('getPeserta', ':id') }}";
            dataPeserta = url.replace(':id', id)

            $.get(dataPeserta, function (data) {
                table.clear().draw();

                $.each(data, function(index, peserta) {
                    table.row.add([
                        '<input class="form-check-input peserta" type="checkbox" value="' +peserta.id_user+ '">',
                        peserta.nama_lengkap,
                        peserta.email,
                        peserta.jenis_kelamin
                    ]).draw(false);
                });
            });
        });
        })

        // checkbox all
        $('#selectAll').on('change', function() {
            if (this.checked) {
                $('.peserta').prop('checked', true);
            } else {
                $('.peserta').prop('checked', false);
            }
        })
    </script>
@endpush
