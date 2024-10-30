@extends('layouts.panel.index')
@section('title', 'Tempat')
@section('content')
<style>
    .select2-close-mask{
        z-index: 2099 !important;
    }
    .select2-dropdown{
        z-index: 3091 !important;
    }
</style>

        <div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
            <table id="example" class="table">
                <thead class="fw-normal">
                    <th>No</th>
                    <th>Page Id</th>
                    <th scope="col">Nama Tempat</th>
                    <th scope="col">No. Telp</th>
                    <th scope="col">Alamat</th>
                    <th scope="col">Kota</th>
                    <th scope="col">Maps</th>
                    <th scope="col">Aksi</th>
                </thead>
                <tbody class="" style="vertical-align: middle">
                    @foreach ($tempat as $row)
                        <tr>
                            <th scope="row">{{ $loop->index + 1 }}</th>
                            <td>{{ \App\Models\Page::find($row->page_id)->nama_page ?? '- '}}</td>
                            <td>{{ $row->nama_tempat }}</td>
                            <td>{{ $row->no_telp }}</td>
                            <td>{{ $row->alamat }}</td>
                            {{-- @forEach($regencies as $id=>$name)
                            @endforeach --}}
                            <td>{{ $row->alamat_kota ?? '-'  }}</td>
                            <td><a class="btn btn-outline-success btn-sm rounded" href="{{ $row->link_maps }}" target="blank">
                                Link <i class="fa-solid fa-arrow-up-right-from-square"></i>
                                </a>
                            </td>
                            <td>
                                <div class="dropdown">
                                    <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                        id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="fa-solid fa-bars"></i>
                                    </a>
                                    <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                        <li><a class="dropdown-item text-black" href="{{ route('tempat.show', $row->id_tempat) }}">
                                            <i class="fa-solid fa-code pe-none"></i> Rincian</a>
                                        </li>
                                        <li><a class="dropdown-item text-info" href="#" data-bs-toggle="modal"
                                                data-bs-target="#edit{{ $row->id_tempat }}"><i
                                                    class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                        <li><a href="{{ route('tempat.destroy', $row->id_tempat) }}" class="dropdown-item text-danger"
                                                data-confirm-delete="true"><i class="fa-regular fa-trash-can pe-none"></i>
                                                Delete</a>
                                        </li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <!-- insert -->
        <div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="add" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header bg-primary-gradient text-white">
                            <h5 class="modal-title" id="exampleModalLabel">Tambah tempat</h5>
                            <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                                aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <form action="{{ route('tempat.store') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="created_by" value="{{ Auth::user()->id_tempat }}">
                            {{-- form --}}
                            <div class="container">
                                <div class="row">
                                    <div class="mb-3">
                                        <label name="page_id" for="form-label">Page Id</label>
                                        <select class="form-select js-example-basic-single" name="page_id" aria-label="Default select example" data-placeholder="Pilih Page" required>
                                        <option disabled selected></option>
                                        @foreach ($page as $row)
                                        <option value="{{ $row->id_page }}" >{{ $row->nama_page }}</option>
                                        @endforeach
                                        </select>
                                    </div>
                                    <div class="col">
                                        {{-- kanan --}}                                                                
                                            <div class="mb-3">
                                                <label for="nama_tempat" class="form-label">Nama tempat</label>
                                                <input type="text" class="form-control" name="nama_tempat" id="nama_tempat"
                                                    required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="alamat" class="form-label">Alamat</label>
                                                <textarea class="form-control" id="alamat" name="alamat" rows="2" required></textarea>
                                            </div>
                                    </div>
                                    <div class="col">
                                        {{-- kiri --}}
                                        <div class="mb-3">
                                                <label for="no_telp" class="form-label">No. telp</label>
                                                <input type="number" class="form-control" name="no_telp" id="no_telp" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="alamat_kota_{{ $row->id_tempat }}" class="form-label">Kota</label>
                                                <select class="form-select js-example-basic-single" name="alamat_kota" id="alamat_kota_{{ $row->id_tempat }}" data-placeholder="Pilih Kota" required>
                                                    <option value="" disabled selected></option> 
                                                    @foreach ($regencies as $id => $name)
                                                        <option value="{{ $name }}" {{ old('alamat_kota', $row->alamat_kota) == $name ? 'selected' : '' }}>{{ $name }}</option>
                                                    @endforeach
                                                </select>
                                                @error('alamat_kota')
                                                    <div class="text-danger">{{ $message }}</div>
                                                @enderror
                                            </div>
                                    </div>
                                    <div class="form-group mb-5">
                                        <label for="link_maps">Link Maps</label>
                                        <textarea class="form-control mt-2" id="link_maps" name="link_maps" rows="3"></textarea>
                                    </div>
                                </div>
                            </div>
                            {{-- end form --}}

                        </div>
                        <div class="modal-footer justify-content-between mx-3">
                            <div class="form-check form-switch mb-3" display="none">
                                <!-- <label for="status" class="me-3">Status</label>
                                <input class="form-check-input" type="checkbox" role="switch" id="status"
                                    name="status" value="Aktif"> -->
                            </div>
                            <div>
                                <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-success rounded-3 text-white">Simpan</button>
                            </div>
                        </div>
                        </form>
                    </div>
                </div>
        </div>

        <!-- edit -->
        @foreach ($tempat as $row)        
        <div class="modal modal-lg fade" id="edit{{ $row->id_tempat }}" tabindex="-1" aria-labelledby="add"
            aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-primary-gradient text-white">
                        <h5 class="modal-title" id="edit_tempat">Edit Tempat</h5>
                        <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                            aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form action="{{ route('tempat.update', $row->id_tempat) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <input type="hidden" name="updated_by" value="{{ Auth::user()->id_tempat }}">
                        {{-- form --}}
                        <div class="container">
                            <div class="row">
                                <div class="mb-3">
                                    <label for="page_id" class="form-label">Page Id</label>
                                    <select class="form-select js-example-basic-single" name="page_id" aria-label="Default select example" data-placeholder="Pilih Page id"
                                            required>
                                            @foreach ($page as $set)
                                            <option value="{{ $set->id_page }}" {{ $set->id_page == $row->page_id ? 'selected' : '' }}>{{ $set->nama_page }}</option>
                                            @endforeach
                                        </select>
                                </div>
                                <div class="col">
                                    {{-- kanan --}}             
                                        <div class="mb-3">
                                            <label for="nama_tempat" class="form-label">Nama tempat</label>
                                            <input type="text" class="form-control" name="nama_tempat" id="nama_tempat"
                                                required value="{{ $row->nama_tempat }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat" class="form-label">Alamat</label>
                                            <textarea class="form-control" id="alamat" name="alamat" rows="2" required>{{ $row->alamat }}</textarea>
                                        </div>
                                </div>
                                <div class="col">
                                    {{-- kiri --}}
                                    <div class="mb-3">
                                            <label for="no_telp" class="form-label">No. telp</label>
                                            <input type="number" class="form-control" name="no_telp" id="no_telp" required
                                            value="{{ $row->no_telp }}">
                                        </div>
                                        <div class="mb-3">
                                            <label for="alamat_kota_{{ $row->id_tempat }}" class="form-label">Kota</label>
                                            <select class="form-select js-example-basic-single" name="alamat_kota" id="alamat_kota_{{ $row->id_tempat }}" data-placeholder="Pilih Kota" required>
                                                <option value="" disabled selected></option> 
                                                @foreach ($regencies as $id => $name)
                                                    <option value="{{ $name }}" {{ old('alamat_kota', $row->alamat_kota) == $name ? 'selected' : '' }}>{{ $name }}</option>
                                                @endforeach
                                            </select>
                                            @error('alamat_kota')
                                                <div class="text-danger">{{ $message }}</div>
                                            @enderror
                                        </div>
                                </div>
                                <div class="form-group mb-5">
                                    <label for="link_maps">Link Maps</label>
                                    <textarea class="form-control mt-2" id="link_maps" name="link_maps" rows="3">{{ $row->link_maps }}</textarea>
                                </div>
                            </div>
                        </div>
                        {{-- end form --}}

                    </div>
                    <div class="modal-footer justify-content-between mx-3">
                        <div class="form-check form-switch mb-3" display="none">
                            <!-- <label for="status" class="me-3">Status</label>
                            <input class="form-check-input" type="checkbox" role="switch" id="status"
                                name="status" value="Aktif" {{ $row->status == 'Aktif' ? 'checked' : '' }}> -->
                        </div>
                        <div>
                            <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-success rounded-3 text-white">Simpan</button>
                        </div>
                    </div>
                    </form>
                </div>
            </div>
        </div>
        @endforeach
    <!-- Include CSS Select2 -->
    {{-- <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/css/select2.min.css" rel="stylesheet" />

    <!-- Include JS Select2 -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.13/js/select2.min.js"></script>
    <script>
  $(document).ready(function() {
        $('.js-single').each(function() {
            var placeholder = $(this).data('placeholder'); 
            
            $(this).select2({
                placeholder: placeholder, 
                allowClear: true,
                minimumResultsForSearch: Infinity 
            });
        });    
    
    @foreach($tempat as $row)
        $('#alamat_kota_{{ $row->id_tempat }}').select2({
            allowClear: true
        });
    @endforeach
});
    </script> --}}
@endsection

