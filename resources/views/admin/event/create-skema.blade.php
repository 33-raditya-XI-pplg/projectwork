@extends('layouts.panel.index')
@section('title', 'Kegiatan')
@section('content')
<div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
  @if ($errors->any())
            <div class="alert alert-danger justify-content-center align-items-center py-2">
                <i class="fa-solid fa-triangle-exclamation me-2"></i>Kolom tidak boleh kosong
            </div>
        @endif
    <form action="{{ route('event-skema.store', $id) }}" method="POST">
      @csrf
        <div class="mb-3">
          <input type="hidden" name="event_id" value="{{ request()->route('event') }}">
          <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">
          <label for="exampleInputEmail1" class="form-label">Pilih Skema</label>
          <select class="form-select js-example-basic-single" name="skema_id" data-placeholder="Open this select menu" required>
            <option value="" selected></option>
            @foreach ($skema as $list)
            <option value="{{ $list->id_skema }}">{{ $list->nama_skema }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Background Sertifikat</label>
          <select class="form-select js-example-basic-single" name="background_id" required data-placeholder="Open this select menu">
            <option value="" selected></option>
            @foreach ($bg as $list)
            <option value="{{ $list->id_background }}">{{ $list->nama_bg }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Tanda Tangan Sertifikat</label>
          <select class="form-select chosen-select" name="ttd_id[]" multiple>
            @foreach ($ttd as $list)
            <option value="{{ $list->id_ttd }}">{{ $list->nama_ttd }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Penguji</label>
          <select class="form-select chosen-select" name="user_id[]" multiple>
            @foreach ($penguji as $list)
            <option value="{{ $list->id_user }}">{{ $list->nama_lengkap }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Rentang Nilai</label>
          <select class="form-select js-example-basic-single" name="nama_konversi_nilai" data-placeholder="Open this select menu" required>
            <option value="" selected></option>
            @foreach ($rn as $list)
                <option value="{{ $list }}">{{ $list }}</option>
            @endforeach
        </select>
        </div>
        <div class="mb-3 d-flex justify-content-between">
          <a class="btn btn-danger rounded" href="{{ route('event.rincian', $id) }}">Kembali</a>
        <button type="submit" class="btn btn-primary rounded">Simpan</button>
      </form>
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

    $(".chosen-select").chosen()
  </script>
@endpush
