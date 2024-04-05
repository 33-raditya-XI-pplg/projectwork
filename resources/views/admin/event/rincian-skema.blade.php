@extends('layouts.panel.index')
@section('title', 'Kegiatan')
@section('content')

    <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Skema</label>
                <input type="text" class="form-control" name="nama_event" id="nama_event"
                value="Skema-01" readonly>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Background</label>
                <input type="text" class="form-control" name="nama_event" id="nama_event"
                value="BG-01" readonly>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Tanda Tangan</label>
                <input type="text" class="form-control" name="nama_event" id="nama_event"
                value="TTD Hendra" readonly>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Penguji</label>
                <input type="text" class="form-control" name="nama_event" id="nama_event"
                value="Andri Setiawan" readonly>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Rentang Nilai</label>
                <input type="text" class="form-control" name="nama_event" id="nama_event"
                value="KNV-02" readonly>
            </div>
            
    </div>

    <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
        <table id="example" class="table">
            <thead>
                <th>No</th>
                <th class="w-100 text-center">Daftar Peserta</th>
            </thead>
            <tbody>
                @for ($i = 0; $i < 10; $i++)
                    <tr>
                        <td>{{ $i }}</td>
                        <td class="text-center">Dedy Sutrisno</td>
                    </tr>
                @endfor
            </tbody>
        </table>
        <div class="mt-3 d-grid px-2">
            <button type="submit" class="btn btn-primary rounded">Simpan</button>
        </div>
    </div>

@endsection
