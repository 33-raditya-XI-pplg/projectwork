@extends('layouts.panel.index')
@section('title', 'Kegiatan')
@section('content')

    <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Skema</label>
                <input type="text" class="form-control" name="nama_event" id="nama_event"
                value="{{ \App\Models\Skema::find($evtSkema->skema_id)->nama_skema }}" readonly>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Background</label>
                <input type="text" class="form-control" name="nama_event" id="nama_event"
                value="{{ \App\Models\Background::find($evtSkema->background_id)->nama_bg }}" readonly>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Tanda Tangan</label>
                <input type="text" class="form-control" name="nama_event" id="nama_event"
                value="{{ \App\Models\Ttd::find($ttd)->pluck('nama_ttd')->implode(', ') }}" readonly>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Penguji</label>
                <input type="text" class="form-control" name="nama_event" id="nama_event"
                value="{{ \App\Models\User::find($penguji)->pluck('nama_lengkap')->implode(', ') }}" readonly>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Rentang Nilai</label>
                <input type="text" class="form-control" name="nama_event" id="nama_event"
                value="N/A" readonly>
            </div>
            
    </div>

    <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
        <div class="mb-2 mx-2">
            <div class="d-flex justify-content-between">
              <span class="h3 fw-bold">Daftar Peserta</span>
              <div>
                <a class="btn btn-danger rounded" href="{{ route('event.rincian', $evt) }}">< Back</a>
                <a class="btn btn-primary rounded" href="{{ route('event-skema.add', [$evt, $evtSkema->id_event_skema]) }}"><i class="fa-solid fa-user-plus text-white"></i></a>
              </div>
            </div>
          </div>
        <table id="example" class="table table-borderless">
            <thead>
                <th>No</th>
                <th class="w-100 text-center">Nama</th>
                <th>Aksi</th>
            </thead>
            <tbody>
                @for ($i = 0; $i < 6; $i++)
                    <tr>
                        <td>{{ $i }}</td>
                        <td class="text-center">Dedy Sutrisno</td>
                        <td><a href="#" data-confirm-delete="true"><i class="fa-solid fa-user-minus text-danger pe-none"></i></a></td>
                    </tr>
                @endfor
            </tbody>
        </table>
    </div>

@endsection
