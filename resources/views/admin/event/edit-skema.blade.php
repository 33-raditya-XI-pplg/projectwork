@extends('layouts.panel.index')
@section('title', 'Kegiatan')
@section('content')
<div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
    <form action="{{ route('event-skema.update', [$evt, $id]) }}" method="POST">
      @csrf
      @method('PUT')
        <div class="mb-3">
          <input type="hidden" name="updated_by" value="{{ Auth::user()->id_user }}">
          <label for="exampleInputEmail1" class="form-label">Skema</label>
          <select class="form-select js-example-basic-single" name="skema_id" data-placeholder="Open this select menu">
            <option selected></option>
            @foreach ($skema as $list)
            <option value="{{ $list->id_skema }}" {{ $list->id_skema == $evtSkema->skema_id ? 'selected' : '' }}>{{ $list->nama_skema }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Background</label>
          <select class="form-select js-example-basic-single" name="background_id" data-placeholder="Open this select menu">
            <option selected></option>
            @foreach ($bg as $list)
            <option value="{{ $list->id_background }}" {{ $list->id_background == $evtSkema->background_id ? 'selected' : '' }}>{{ $list->nama_bg }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Tanda Tangan</label>
          <select class="form-select chosen-select" name="ttd_id[]" multiple>
            @foreach ($ttd as $list)
            <option value="{{ $list->id_ttd }}" {{ in_array($list->id_ttd, $ttd_id) ? 'selected' : '' }}>{{ $list->nama_ttd }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Penguji</label>
          <select class="form-select chosen-select" name="user_id[]" multiple>
            @foreach ($penguji as $list)
            <option value="{{ $list->id_user }}" {{ in_array($list->id_user, $penguji_id) ? 'selected' : '' }}>{{ $list->nama_lengkap }}</option>
            @endforeach
          </select>
        </div>
        <div class="mb-3">
          <label for="exampleInputEmail1" class="form-label">Rentang Nilai</label>
          <select class="form-select js-example-basic-single" name="nama_konversi_nilai" data-placeholder="Open this select menu" required>
            @foreach ($rn as $list)
            <option value="{{ $list }}" 
            {{ in_array($list, $rn_id) ? 'selected' : '' }}>
            {{ $list }}
             </option>
            @endforeach
        </select>
        </div>
        <div class="mb-3 d-flex justify-content-between">
        <a class="btn btn-danger rounded" href="{{ route('event.rincian', $evt) }}">Kembali</a>
        <button type="submit" class="btn btn-primary rounded">Update</button>
      </form>

</div>
@endsection

@push('script')
  <script>   
    $(document).ready(function(){
      $('.js-example-basic-single').each(function(){
        var placeholder = $(this).data('placeholder');
        
        $(this).select2({
          placeholder:placeholder,
          allowClear:true,
          minimumResultsForSearch: Infinity
        });
      });
    });
 
    $(".chosen-select").chosen()
  </script>
@endpush