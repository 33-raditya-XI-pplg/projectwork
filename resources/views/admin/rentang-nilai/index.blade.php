@extends('layouts.panel.index')
@section('title', 'Rentang Nilai')
@section('content')
<div class="bg-white rounded-4 px-3 py-3 mb-5 shadow-lg">
    <a href="#" class="btn btn-primary rounded mb-3" data-bs-toggle="modal" data-bs-target="#panduanPengisianModal">Panduan</a>

    <table id="example" class="table">
        <thead class="fw-normal">
            <th>No</th>
            <th scope="col ">Nama</th>
            <th scope="col">Inisial</th>
            <th scope="col">Keterangan</th>
            <th scope="col">Rentang Atas</th>
            <th scope="col">Rentang Bawah</th>
            <th scope="col">Aksi</th>
        </thead>
        <tbody class="" style="vertical-align: middle">
            @foreach ($rentang as $row)
                <?php 
                    if ($row->keterangan_rentang_nilai === "Sangat Kompeten" || $row->keterangan_rentang_nilai === "Cukup Kompeten") {
                        $color = 'color: green; font-weight: bold;';
                    } 
                    elseif ($row->keterangan_rentang_nilai === "Kurang Kompeten" || $row->keterangan_rentang_nilai === "Tidak Kompeten") {
                        $color = 'color: red; font-weight: normal;';
                    } else {
                        $color = 'color: black; font-weight: normal;';
                    }
                ?>
                
                <tr>
                    <th scope="row">{{ $loop->index + 1 }}</th>
                    <td>{{ $row->nama_konversi_nilai }}</td>
                    <td>{{ $row->inisial_rentang_nilai }}</td>
                    <td style="{{ $color }}">{{ $row->keterangan_rentang_nilai }}</td>
                    <td>{{ $row->rentang_atas }}</td>
                    <td>{{ $row->rentang_bawah }}</td>
                    <td>
                        <div class="dropdown">
                            <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="fa-solid fa-bars"></i>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                <li><a class="dropdown-item text-info" href="#" data-bs-toggle="modal"
                                        data-bs-target="#edit{{ $row->id_rentang_nilai }}"><i
                                            class="fa-regular fa-pen-to-square"></i> Edit</a></li>
                                <li><a href="{{ route('rentang-nilai.destroy', $row->id_rentang_nilai) }}" class="dropdown-item text-danger"
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


<!-- Panduan Pengisian Modal -->
<div class="modal fade" id="panduanPengisianModal" tabindex="-1" aria-labelledby="panduanPengisianModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">

        <div class="modal-header">
            <h5 class="modal-title" id="rentangNilaiModalLabel">Panduan Pengisian Rentang Nilai</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <p>Harap perhatikan panduan berikut untuk mengisi rentang nilai:</p>
            <ul>
                <li>Nama konversi harus sama untuk setiap rentang nilai yang dibuat.</li>
                <li>Setiap rentang nilai harus memiliki batas atas dan batas bawah.</li>
                <li>Batas atas dan batas bawah setiap rentang nilai tidak boleh sama.</li>
            </ul><br>

            <p>Berikut contohnya</p>
            <table class="table table-hover">
                <thead class="table-primary">
                    <th>No</th>
                    <th scope="col">Nama konversi</th>
                    <th scope="col">Inisial</th>
                    <th scope="col">Keterangan</th>
                    <th scope="col">Rentang Atas</th>
                    <th scope="col">Rentang Bawah</th>
                </thead>
                <tbody>
                    <tr>
                        <th scope="row">1</th>
                        <td>konversi_abcd</td>
                        <td>A</td>
                        <td><span style="color: green; font-weight: bold;">Sangat Kompeten</span></td>
                        <td>100</td>
                        <td>94</td>
                    </tr>        
                    <tr>
                        <th scope="row">2</th>
                        <td>konversi_abcd</td>
                        <td>B</td>
                        <td><span style="color: green; font-weight: bold;">Cukup Kompeten</span></td>
                        <td>93</td>
                        <td>84</td>
                    </tr>   
                    <tr>
                        <th scope="row">3</th>
                        <td>konversi_abcd</td>
                        <td>C</td>
                        <td><span style="color: red; font-weight: bold;">Kurang Kompeten</span></td>
                        <td>83</td>
                        <td>74</td>
                    </tr>   
                    <tr>
                        <th scope="row">4</th>
                        <td>konversi_abcd</td>
                        <td>D</td>
                        <td><span style="color: red; font-weight: bold;">Tidak Kompeten</span></td>
                        <td>73</td>
                        <td>0</td>
                    </tr>   
                </tbody>
            </table>

            <p><span style="color: red; font-weight: bold;">note</span></p>
            <ul>
                <li>Hanya keterangan nilai yang sama persis pada contoh yang dapat berubah warna.</li>
                <li><p>apabila keterangan tidak sama seperti contoh, maka akan berwarna hitam</p></li>
            </ul>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Tutup</button>
        </div>

    </div>
  </div>
</div>

{{-- insert --}}
<div class="modal modal-lg fade" id="add" tabindex="-1" aria-labelledby="add" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient text-white">
                <h5 class="modal-title" id="exampleModalLabel">Tambah</h5>
                <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">

                {{-- form --}}
                <div class="container">

                    <form action="{{ route('rentang-nilai.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="created_by" value="{{ Auth::user()->id_user }}">
                        <div class="mb-3">
                            <label for="nama_konversi_nilai" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama_konversi_nilai" id="nama_konversi_nilai"
                                required>
                        </div>

                        <div class="row">
                            <div class="mb-3">
                                <label for="inisial_rentang_nilai" class="form-label">Inisial</label>
                                <input type="text" class="form-control" name="inisial_rentang_nilai" id="inisial_rentang_nilai"
                                required>
                            </div>
                            <div class="mb-3">
                                <label for="keterangan_rentang_nilai" class="form-label">Keterangan</label>
                                <textarea class="form-control" name="keterangan_rentang_nilai" id="keterangan_rentang_nilai" rows="2"></textarea>
                                {{-- <input type="text" class="form-control" name="keterangan_rentang_nilai" id="keterangan_rentang_nilai"
                                required> --}}
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="rentang_atas" class="form-label">Rentang Atas</label>
                                    <input type="number" class="form-control" name="rentang_atas" id="rentang_atas" required>
                                </div>
                            </div>                         
                            <div class="col">
                                <div class="mb-3">
                                    <label for="rentang_bawah" class="form-label">Rentang Bawah</label>
                                    <input type="number" class="form-control" name="rentang_bawah" id="rentang_bawah" required>
                                </div>
                            </div>
                            
                        </div>
                                
                </div>
                {{-- end form --}}

            </div>
            <div class="modal-footer justify-end mx-3">
                <div>
                    <button type="button" class="btn btn-danger rounded-3" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-success rounded-3 text-white">Simpan</button>
                </div>
            </div>
            </form>
        </div>
    </div>
</div>

{{-- edit --}}
@foreach ( $rentang as $row)
    

<div class="modal modal-lg fade" id="edit{{ $row->id_rentang_nilai }}" tabindex="-1" aria-labelledby="add" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header bg-primary-gradient text-white">
                <h5 class="modal-title" id="exampleModalLabel">Tambah</h5>
                <button type="button" class="btn-close btn-close-white me-2" data-bs-dismiss="modal"
                    aria-label="Close"></button>
            </div>
            <div class="modal-body">

                {{-- form --}}
                <div class="container">

                    <form action="{{ route('rentang-nilai.update', $row->id_rentang_nilai) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <input type="hidden" name="updated_by" value="{{ Auth::user()->id_user }}">
                        <div class="mb-3">
                            <label for="nama_konversi_nilai" class="form-label">Nama</label>
                            <input type="text" class="form-control" name="nama_konversi_nilai" id="nama_konversi_nilai"
                                required value="{{ $row->nama_konversi_nilai}}">
                        </div>

                        <div class="row">
                         
                                <div class="mb-3">
                                    <label for="inisial_rentang_nilai" class="form-label">Inisial</label>
                                    <input type="text" class="form-control" name="inisial_rentang_nilai" id="inisial_rentang_nilai"
                                        required value="{{ $row->inisial_rentang_nilai}}">
                                </div>                            
                                <div class="mb-3">
                                    <label for="keterangan_rentang_nilai" class="form-label">Keterangan</label>
                                    <textarea class="form-control" name="keterangan_rentang_nilai" id="keterangan_rentang_nilai" rows="2">{{ $row->keterangan_rentang_nilai }}</textarea>
                                    {{-- <input type="text" class="form-control" name="keterangan_rentang_nilai" id="keterangan_rentang_nilai"
                                        required value="{{ $row->keterangan_rentang_nilai}}"> --}}
                                </div>

                            <div class="col">                                                    
                                <div class="mb-3">
                                    <label for="rentang_atas" class="form-label">Rentang Atas</label>
                                    <input type="number" class="form-control" name="rentang_atas" id="rentang_atas" value="{{ $row->rentang_atas}}" required>
                                </div>
                            </div>
                            <div class="col">
                                <div class="mb-3">
                                    <label for="rentang_bawah" class="form-label">Rentang Bawah</label>
                                    <input type="number" class="form-control" name="rentang_bawah" id="rentang_bawah" required value="{{ $row->rentang_bawah}}">
                                </div>
                            </div>
                            
                        </div>
                        
                </div>
                {{-- end form --}}

            </div>

            <div class="modal-footer justify-end mx-3">
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

@endsection