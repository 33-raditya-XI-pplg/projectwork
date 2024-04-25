@extends('layouts.panel.index')
@section('title', 'Kegiatan')
@section('content')
<div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
    <form action="{{ route('event-skema.store') }}" method="POST">
      @csrf
        <div class="mb-3">
          <input type="hidden" name="event_id" value="{{ request()->route('event') }}">
          <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">
          <label for="exampleInputEmail1" class="form-label">Skema</label>
          <select class="form-select chosen-select" name="skema_id"">
            <option selected>Open this select menu</option>
            @foreach ($skema as $list)
            <option value="{{ $list->id_skema }}">{{ $list->nama_skema }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Background</label>
          <select class="form-select chosen-select" name="background_id">
            <option selected>Open this select menu</option>
            @foreach ($bg as $list)
            <option value="{{ $list->id_background }}">{{ $list->nama_bg }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Tanda Tangan</label>
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
          <select class="form-select chosen-select" name="nama_konversi_nilai">
            <option selected>Open this select menu</option>
            @foreach ($rn as $list)
            <option >{{ $list }}</option>
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
    $(".chosen-select").chosen()
  </script>
@endpush