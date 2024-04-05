@extends('layouts.panel.index')
@section('title', 'Kegiatan')
@section('content')
<div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
    <form>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Skema</label>
          <select class="form-select chosen-select" aria-label="Default select example" multiple>
            <option selected>Open this select menu</option>
            @foreach ($skema as $list)
            <option value="{{ $list->id_skema }}">{{ $list->nama_skema }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Background</label>
          <select class="form-select chosen-select" aria-label="Default select example">
            <option selected>Open this select menu</option>
            @foreach ($bg as $list)
            <option value="{{ $list->id_skema }}">{{ $list->nama_skema }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Tanda Tangan</label>
          <select class="form-select chosen-select" aria-label="Default select example" multiple>
            <option selected>Open this select menu</option>
            @foreach ($ttd as $list)
            <option value="{{ $list->id_background }}">{{ $list->nama_bg }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Penguji</label>
          <select class="form-select chosen-select" aria-label="Default select example" multiple>
            <option selected>Open this select menu</option>
            @foreach ($rn as $list)
            <option value="0">Pak Citra</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Rentang Nilai</label>
          <select class="form-select chosen-select" aria-label="Default select example">
            <option selected>Open this select menu</option>
            @foreach ($rn as $list)
            <option value="{{ $list->id_rentang_nilai }}">{{ $list->nama_konversi_nilai }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3 d-flex justify-content-end">
        <button type="submit" class="btn btn-primary rounded">Simpan</button>
      </form>
</div>
@endsection

@push('script')
  <script>
    $(".chosen-select").chosen()
  </script>
@endpush