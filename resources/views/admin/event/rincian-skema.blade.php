@extends('layouts.panel.index')
@section('title', 'Kegiatan')
@section('content')

    <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Skema</label>
                <select class="form-select" aria-label="Default select example" readonly>
                    <option selected>Skema 1</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Background</label>
                <select class="form-select" aria-label="Default select example" readonly>
                    <option selected>Background 1</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Tanda Tangan</label>
                <select class="form-select" aria-label="Default select example" readonly>
                    <option selected>Tanda Tangan 1</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Penguji</label>
                <select class="form-select" aria-label="Default select example" readonly>
                    <option selected>Penguji 1</option>
                </select>
            </div>
            <div class="mb-3">
                <label for="exampleInputEmail1" class="form-label">Rentang Nilai</label>
                <select class="form-select" aria-label="Default select example" readonly>
                    <option selected>Rentang Nilai 1</option>
                </select>
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
