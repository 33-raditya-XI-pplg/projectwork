@extends('layouts.panel.index')
@section('title', 'Kegiatan')
@section('content')

<style>


.select2-container--default{
    text-align: center;
}
.btn i{
    font-size: 12px;
}
.btn small{
    font-size: 12px;
}
.btn-sm{
    padding: 2px 4px;
    font-size: 14px; 
    line-height: 1;
}
</style>

    <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
        @if ($errors->any())
            <div class="alert alert-danger justify-content-center align-items-center py-2">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>Harap pilih peserta event.
            </div>
        @endif
        <div class="d-flex align-items-center mb-4">
            <a class="btn btn-danger btn-sm rounded me-3" href="{{ route('event-skema.show', [$evt, $skema]) }}"><i
                    class="fa-solid fa-angles-left"></i><small class="fw-bold">Kembali</small></a>
            <select id="instansi" class="form-select mb-4 mx-3 js-example-basic-single" data-placeholder="Pilih Instansi">
                <option class="text-center" selected></option>
                @foreach ($instansi as $list)
                    <option class="text-center" value="{{ $list->id_instansi }}">{{ $list->nama_instansi }}</option>
                @endforeach
            </select>
            <a class="btn btn-primary btn-sm rounded pe-none ms-3" id="show-peserta" href="javascript:void(0)"><i
                    class="fa-solid fa-magnifying-glass"></i><small class="fw-bold">Cari</small></a>
        </div>
        <form action="{{ route('event-skema.store-student', [$evt, $skema]) }}" method="POST">
            @csrf
            <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">
            <table id="peserta" class="table rounded">
                <thead>
                    <th style="width: 5%;"><input id="selectAll" class="form-check-input" type="checkbox"></th>
                    <th class="">Nama Peserta</th>
                    <th class="">Email</th>
                    <th class="text-center">Jenis Kelamin</th>
                </thead>
                <tbody>

                </tbody>
            </table>
            <div class="d-grid mt-4 mx-2">
                <button id="save" type="submit" class="btn btn-primary rounded mx-3" disabled>Simpan Peserta</button>
            </div>
        </form>
    </div>

@endsection
@push('script')
    <script>
   
        var table = $('#peserta').DataTable();
        // search peserta
        $(document).ready(function() {
            $('.js-example-basic-single').each(function(){
                var placeholder = $(this).data('placeholder');
                
                $(this).select2({
                placeholder:placeholder,
                allowClear:true,
                minimumResultsForSearch: Infinity
                });
            });
            $('#instansi').on('change', function() {
                if (!isNaN($(this).val())) {
                    $('#show-peserta').removeClass('pe-none');
                } else {
                    $('#show-peserta').addClass('pe-none')
                };
            })

            $('#show-peserta').on('click', function() {
                var instansi = $('#instansi').val();
                var skema = {{ Js::from($skema) }};
                url = "{{ route('getPeserta', [':instansi', ':skema']) }}"
                      .replace(':instansi', instansi).replace(':skema', skema);


                $.get(url, function(data) {
                    table.clear().draw();

                    $.each(data, function(index, peserta) {
                        table.row.add([
                            '<input class="form-check-input peserta" type="checkbox" name="user_id[]" value="' +
                            peserta.id_user + '" '+ (peserta.exist ? 'checked' : '') +'>',
                            peserta.nama_lengkap,
                            peserta.email,
                            peserta.jenis_kelamin
                        ]).draw(false);
                    });
                });
                $('#save').prop('disabled', false);
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
