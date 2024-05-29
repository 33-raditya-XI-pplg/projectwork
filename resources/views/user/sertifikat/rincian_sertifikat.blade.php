@extends('layouts.panel.index')
@section('title', 'Rincian Sertifikat')


@section('title', 'Rincian Sertifikat')
@push('style')
    <style>
        h5 {
            font-weight: 300;
        }
        #img-rincian{
            width: 400px;
            height: 300px;
        }
    </style>
@endpush
@section('content')
    <div class="row">
        <div class="col-xl-12 col-lg-12 col-md-12 col-12">
            <div class="card mb-5">
                <div class="card-body">
                    <h4 class="card-title">Rincian Event</h4>
                    <img id="img-rincian" src="{{ $banner }}" class="img-fluid mx-auto d-block" alt="Banner Event">
                    <hr>
                    <br>
                    <p class="mt-2 mb-4">{{ $data_event->deskripsi }}</p>
                    <div class="row">
                        <div class="mb-4 col-6">
                            <h6 class="fs-5 ls-2">Event</h6>
                            <p class="mb-0">{{ $data_event->nama_event }}</p>
                        </div>
                        <div class="mb-4 col-6">
                            <h6 class="fs-5 ls-2">TUK</h6>
                            <p class="mb-0">{{ $data_event->nama_tempat }}</p>
                        </div>
                        <div class="col-6">
                            <h6 class="fs-5 ls-2">Tanggal Mulai</h6>
                            <p class="mb-0">{{ $data_event->tgl_mulai }}</p>
                        </div>
                        <div class="col-6">
                            <h6 class="fs-5 ls-2">Tanggal Berakhir</h6>
                            <p class="mb-0">{{ $data_event->tgl_berakhir }}</p>
                        </div>
                    </div>
                    <div class="back mt-4 mb-3">
                        <a href="{{ route('sertifikat-user.index') }}" class="btn btn-primary rounded">Kembali</a>
                    </div>
                </div>
            </div>

            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Daftar Skema</h4>
                    <table id="example" class="table">
                        <thead class="fw-normal">
                            <th scope="col" width="5%">No</th>
                            <th scope="col" width="20%">Skema</th>
                            <th scope="col" width="20%">Status Sertifikat</th>
                            <th scope="col" width="20%">Nilai <span style="color: grey; font-size: 15px;">avg</span></th>
                            <th scope="col" width="20%">Keterangan</th>
                            <th scope="col" width="8%" class="text-center">Aksi</th>
                        </thead>

                        <tbody class="table-responsive" style="vertical-align: middle">
                            @php $num = 1 @endphp
                            @foreach ($data_gabungan as $row)
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
                                    <td>{{ $num++ }}</td>
                                    <td>{{ $row->nama_skema }}</td>
                                    @if ($row->memiliki_sertifikat)
                                        <td><button type="button" class="btn rounded-3 btn-outline-success fw-bold" disabled>Dapat Dicetak</button></td>
                                        <td>{{ $row->avg_nilai }}</td>
                                        <td style="{{ $color }}">{{ $row->keterangan_rentang_nilai }}</td>
                                        <td class="text-center">
                                            <div class="dropdown">
                                                <a href="#" class="dropdown-toggle btn btn-primary btn-sm rounded-3"
                                                    id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                    <i class="fa-solid fa-bars"></i>
                                                </a>
                                                <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton1">
                                                    <li><a href="{{ route('cetak-sertifikat.cetak', $row->id_event_skema) }}" class="dropdown-item text-primary">
                                                        <i class="fa fa-print"></i> Cetak</a>
                                                    </li>
                                                    <li><a href="{{ route('sertifikat.rincian-skema', $row->id_event_skema) }}" class="dropdown-item text-secondary">
                                                        <i class="fa fa-info"></i> Rincian</a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </td>

                                    @else
                                        <td><button type="button" class="btn rounded-3 btn-outline-danger fw-bold" disabled>Belum Siap</button></td>
                                        <td>-</td>
                                        <td>-</td>
                                        <td class="text-center">
                                            <a href="{{ route('sertifikat.rincian-skema', $row->id_event_skema) }}" class="btn btn-secondary btn-sm rounded">
                                                <i class="fa fa-info"></i> Rincian</a>
                                        </td>
                                    @endif
                                    
                                </tr>
                            @endforeach
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection

@push('script')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var button = document.getElementById('tambahBtn');
            button.style.display = 'none';
        });
    </script>
@endpush