@extends('layouts.panel.index')
@section('title', 'Kegiatan')
@section('content')

    <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Skema</label>
                <input type="text" class="form-control" name="nama_event" id="nama_event"
                value="{{ \App\Models\Skema::find($evtSkema->skema_id)->nama_skema }}" disabled readonly>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Background</label>
                <input type="text" class="form-control" name="nama_event" id="nama_event"
                value="{{ \App\Models\Background::find($evtSkema->background_id)->nama_bg }}" disabled readonly>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Tanda Tangan</label>
                <input type="text" class="form-control" name="nama_event" id="nama_event"
                value="{{ $ttd->implode(', ') }}" disabled readonly>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Penguji</label>
                <input type="text" class="form-control" name="nama_event" id="nama_event"
                value="{{ $penguji->implode(', ') }}" disabled readonly>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Rentang Nilai</label>
                <input type="text" class="form-control" name="nama_event" id="nama_event"
                value="{{ $rn->implode(', ') }}" disabled readonly>
            </div>

    </div>

    <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
        <div class="mb-2 mx-2">
            <div class="d-flex justify-content-between">
              <span class="h3 fw-bold">Daftar Peserta</span>
              <div>
                <a class="btn btn-danger rounded" href="{{ route('event.rincian', $evt) }}">Hapus Peserta</a>
                <a class="btn btn-primary rounded" href="{{ route('event-skema.add', [$evt, $evtSkema->id_event_skema]) }}">Tambah Peserta<i class=" text-white"></i></a>
              </div>
            </div>
          </div>
        <table id="example" class="table table-borderless">
            <thead>
                <th style="width: 5%">No</th>
                <th class="w-50 text-center">Nama</th>
                <th class="text-center">Jenis Kelamin</th>
                <th style="width: 5%">Aksi</th>
            </thead>
            <tbody>
                @foreach ($peserta as $list)
                    <tr>
                        <td>{{ $loop->index +1}}</td>
                        <td >{{ $list->nama_lengkap }}</td>
                        <td class="text-capitalize text-center">{{ $list->jenis_kelamin }}</td>
                        <td><a href="{{ route('event-skema.delete-student', [$evtSkema, $list->id_user]) }}" data-confirm-delete="true" class="btn btn-danger text-white rounded">Hapus<i class="text-danger pe-none"></i></a></td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

@endsection
