@extends('layouts.panel.index')
@section('title', 'Laporan Perkembangan')

@section('content')
<div class="container mt-4">
    <div class="bg-white rounded-4 p-4 shadow-lg">
        <!-- Info Peserta dan Event -->
        <div class="mb-4">
            <div class="border-start border-5 border-primary rounded-3 p-3 bg-light shadow-sm">
                <h4 class="mb-1 fw-bold text-primary">{{ $detail['nama_lengkap'] }}</h4>
                <p class="mb-0 text-muted">
                    <span class="me-3"><i class="bi bi-calendar-event-fill"></i> <strong>Event:</strong> {{ $detail['nama_event'] }}</span>
                    <span><i class="bi bi-diagram-3-fill"></i> <strong>Skema:</strong> {{ $detail['nama_skema'] }}</span>
                </p>
            </div>
        </div>

        <!-- Perkembangan Card -->
        <div class="row g-4">
            @if ($detail['perkembangan'])
            <div class="col-md-12">
                <div class="card shadow-sm border-0">
                    <span><i class="bi bi-graph-up-arrow"></i> Laporan Tanggal: {{ \Carbon\Carbon::parse($detail['perkembangan']->tanggal_penilaian)->format('d M Y') }}</span>
                    
                    <div class="card-body">
                        <h6 class="fw-bold text-secondary mb-2">Pengalaman Anak</h6>
                        <p class="text-muted">{!! $detail['perkembangan']->pengalaman_anak !!}</p>


                        <h6 class="fw-bold text-secondary mb-3">Kemampuan Dasar</h6>
                        @if (!empty($detail['kemampuan_dasar']))
                                @foreach ($detail['kemampuan_dasar'] as $kd)
                                        <div class=" me-auto mb-3 " class="text-muted">
                                            {{ $kd->kemampuan }}
                                            <em>({{ $kd->keterangan }})</em>
                                            {{-- @if ($kd->keterangan)
                                            @endif --}}
                                        </div>
                                @endforeach
                        @else
                            <p class="text-muted"><em>Tidak ada data kemampuan dasar.</em></p>
                        @endif

                        <h6 class="fw-bold text-secondary mb-2">Peralatan Penunjang</h6>
                        <p class="text-muted">{!! $detail['perkembangan']->peralatan_penunjang !!}</p>

                        <h6 class="fw-bold text-secondary mb-2">Saran</h6>
                        <p class="text-muted">{!! $detail['perkembangan']->saran !!}</p>
                    </div>
                </div>
            </div>
            @else
            <div class="col-12">
                <div class="alert alert-secondary text-center">
                    <i class="bi bi-info-circle-fill me-2"></i> Belum ada laporan perkembangan.
                </div>
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
