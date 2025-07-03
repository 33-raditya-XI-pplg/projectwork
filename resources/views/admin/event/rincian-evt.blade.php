@extends('layouts.panel.index')
@section('title', 'Kegiatan')
@section('content')
    <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
        <div class="card">
            <div class="card-body">
                <div class="row">
                    <div class="col">
                        {{-- kanan --}}

                        <div class="mb-3">
                            <label for="nama_event" class="form-label">Nama Event</label>
                            <input type="hidden" name="event_id" value="{{ request()->route('event') }}">
                            <input type="text" class="form-control" name="nama_event" id="nama_event"
                                value="{{ $evt->nama_event }}" disabled readonly>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal_mulai" class="form-label">Tanggal Event</label>
                            <input type="date" class="form-control" name="tgl_mulai" id="tanggal_mulai"
                                placeholder="DD/MM/YYYY" value="{{ $evt->tgl_mulai }}" disabled readonly>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_event_id" class="form-label">Jenis Event</label>
                            <select class="form-select" name="jenis_event_id" aria-label="Default select example" disabled readonly>
                                <option selected>{{ \App\Models\Jenis_Event::find($evt->jenis_event_id)->nama_jenis_event }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tempat_id" class="form-label">Tempat</label>
                            <select class="form-select" name="tempat_id" aria-label="Default select example" disabled readonly>
                                <option selected>{{ \App\Models\Tempat::find($evt->tempat_id)->nama_tempat }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="col">
                        {{-- kiri --}}
                        <div class="mb-3">
                            <label for="instansi_id" class="form-label">Nama Instansi</label>
                            <select class="form-select" name="instansi_id" aria-label="Default select example" disabled readonly>
                                <option selected>{{ \App\Models\Instansi::find($evt->instansi_id)->nama_instansi }}</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tgl_berakhir" class="form-label">Tanggal Berakhir</label>
                            <input type="date" class="form-control" id="tgl_berakhir" name="tgl_berakhir"
                                placeholder="DD/MM/YYYY" value="{{ $evt->tgl_berakhir }}" disabled readonly>
                        </div>
                        <label for="biaya_regis" class="form-label">Biaya</label>
                        <div class="input-group mb-3">
                            <span class="input-group-text">Rp</span>
                            <input type="number" class="form-control"
                                aria-label="Dollar amount (with dot and two decimal places)" name="biaya_regis"
                                value="{{ $evt->biaya_regis }}" disabled readonly>
                        </div>
                        <div class="mb-3">
                            <label for="visibilitas" class="form-label">Visibilitas</label>
                            <select class="form-select text-capitalize" name="visibilitas"
                                aria-label="Default select example" disabled readonly>
                                <option class="text-capitalize" selected>{{ $evt->visibilitas }}</option>
                            </select>
                        </div>
                    </div>
                    <div class="mb-3">
                        <label for="page_id" class="form-label">Page Id</label>
                        <select class="form-select" name="page_id" aria-label="Default select example" disabled readonly>
                            {{-- <option selected>{{ \App\Models\Instansi::find($evt->instansi_id)->nama_instansi }}</option> --}}
                            <option  selected>{{ \App\Models\Page::find($evt->page_id)->nama_page ?? 'Nama halaman tidak ditemukan '}}</option>
                        </select>
                    </div>
                    <span for="logo" class="form-label">Banner</span>
                    <div class="mb-3 text-center">
                        <img src="{{ $evt->path_banner }}" height="200" alt="logo">
                    </div>
                    <div class="mb-3">
                        <label for="deskripsi" class="form-label">Deskripsi</label>
                        <textarea class="form-control ck-editor  " id="deskripsi-edit" name="deskripsi" rows="4" disabled readonly>{{ $evt->deskripsi }}</textarea>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
        <div class="d-flex mb-2 me-3 justify-content-end">
            <a class="btn btn-danger rounded me-2" href="{{ route('event.index') }}">< Back</a>
            <a class="btn btn-primary rounded " href="{{ route('event-skema.create', $evt->id_event)}}">Tambah [+]</a>
        </div>
        <table id="example" class="table">
            <thead>
                <th>No</th>
                <th class="w-75" scope="col">Skema</th>
                <th scope="col">Aksi</th>
            </thead>
            <tbody>
                @foreach ($skema as $list)
                    <tr>
                        <th scope="row">{{ $loop->index + 1 }}</th>
                             <td>{{ \App\Models\Skema::find($list->skema_id)->nama_skema }}</td>
                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-2">
                                <a href="{{ route('event-skema.show', [$evt->id_event, $list->id_event_skema]) }}"
                                    class="btn btn-primary btn-sm rounded text-white d-flex align-items-center gap-1">
                                    <i class="fa-solid fa-code" style="font-size: 0.75rem; color: white;"></i>
                                    <span>Rincian</span>
                                </a>

                                <a href="{{ route('event-skema.edit', [$evt->id_event, $list->id_event_skema]) }}"
                                    class="btn btn-info btn-sm rounded text-white d-flex align-items-center gap-1">
                                    <i class="fa-regular fa-pen-to-square" style="font-size: 0.75rem; color: white;"></i>
                                    <span>Edit</span>
                                </a>

                                <form id="deleteForm-{{ $evt->id_event }}-{{ $list->skema_id }}"
                                    action="{{ route('event-skema.delete', [$evt->id_event, $list->skema_id]) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm rounded text-white d-flex align-items-center gap-1"
                                        onclick="confirmDelete('{{ $evt->id_event }}-{{ $list->skema_id }}')">
                                        <i class="fa-regular fa-trash-can" style="font-size: 0.75rem; color: white;"></i>
                                        <span>Delete</span>
                                    </button>
                                </form>
                            </div>

                            <script>
                                function confirmDelete(id) {
                                    Swal.fire({
                                        title: 'Are you sure?',
                                        text: "You won't be able to revert this!",
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Yes, delete it!',
                                        cancelButtonText: 'Cancel'
                                    }).then((result) => {
                                        if (result.isConfirmed) {
                                            document.getElementById('deleteForm-' + id).submit();
                                        }
                                    });
                                }
                            </script>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
@endsection
