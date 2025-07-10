<!DOCTYPE html>
<html>

<head>
    <title>{{ $data_sertifikat_peserta->nomor_sertifikat }}</title>
    <style>
        body {
            margin: -50px;
            padding: -50px;
            background-image: url('{{ $templateBg }}');
            background-size: cover;
            font-family: Arial, sans-serif;
            text-align: center;
        }

        .signature img {
            max-width: 100px;
            max-height: 100px;
        }

        .tittle-sertif {
            margin-top: 110px;
            font-size: 22px;
            font-weight: bold;
        }

        .content-tittle {
            font-size: 16px;
            font-style: italic;
        }

        .nomor_sertif {
            font-size: 15px;
            font-weight: bold;
        }

        .keterangan {
            margin-top: 35px;
            font-size: 14px;
            font-style: normal;
        }

        .keterangan-2 {
            font-size: 14px;
            font-style: italic;
        }

        .nama_peserta {
            font-size: 22px;
            font-weight: bold;
        }

        .keterangan-3 {
            font-size: 14px;
            font-style: normal;
        }

        .keterangan-4 {
            font-size: 14px;
            font-style: italic;
        }

        .keterangan-5 {
            font-size: 14px;
            font-style: normal;
            margin-top: 35px;
        }

        .keterangan-6 {
            font-size: 14px;
            font-style: italic;
        }

        .keterangan-7 {
            font-size: 14px;
            font-style: normal;
        }

        .keterangan-8 {
            font-size: 14px;
            font-style: italic;
        }

        .ejs {
            font-size: 22px;
            font-weight: bold;
        }

        .three {
            font-size: 14px;
            font-style: oblique;
        }

        .three a {
            font-size: 14px;
            font-weight: bold;
        }

        .bg-sertif {
            background-color: white;
        }
    </style>
</head>

<body>
    <div>
        <h1 class="tittle-sertif">SERTIFIKAT UJI KOMPETENSI</h1>

        <div class="bg-sertif">
            <p class="content-tittle">CERTIFICATE OF COMPETENCY ASSESSMENT</p>
            <p class="nomor_sertif">Nomor Sertifikat: {{ $data_sertifikat_peserta->nomor_sertifikat }}</p>
            <p class="keterangan">Dengan ini menyatakan bahwa,</p>
            <p class="keterangan-2">This is to certify that</p>
            <p class="nama_peserta">{{ $data_sertifikat_peserta->nama_lengkap }}</p>
        </div>
        <p class="keterangan-3">Telah mengikuti {{ $data_sertifikat_peserta->nama_jenis_event }}</p>

        <p class="keterangan-4">has taken the competency test</p>
        <p class="keterangan-5">Pada event {{ $data_sertifikat_peserta->nama_event }}</p>
        <p class="keterangan-6">in competency of</p>
        <p class="ejs">{{ $data_sertifikat_peserta->nama_skema }}</p> {{-- Skema: --}}

        <p class="three">Nilai: <a> {{ $data_sertifikat_peserta->nilai }}</a></p>
        <p class="keterangan-7">dengan predikat</p>
        <p class="keterangan-8">with achievement level</p>
        <p class="three"><a> {{ $data_sertifikat_peserta->keterangan }}</a></p>

        <p class="three">Terbit: <a>
                {{ \Carbon\Carbon::parse($data_sertifikat_peserta->tgl_terbit)->format('d-F-Y') }}
                @if ($data_sertifikat_peserta->tgl_berakhir)
                    - {{ \Carbon\Carbon::parse($data_sertifikat_peserta->tgl_berakhir)->format('d-F-Y') }}
                @endif
                {{-- <p class="three">Berakhir: <a></a></p> --}}
                <p class="three">Masa Berlaku: <a> {{ $data_sertifikat_peserta->masa_berlaku }}</a></p>

                <table style="width: 100%;">
                    <tr>
                        @foreach ($data_penadatangan as $row2)
                            <td style="width: 50%;  text-align: center;">
                                <div>
                                    <p style="font-size: 1em; font-weight: bold;">{{ $row2->nama_ttd }}</p>
                                    <div class="signature">
                                        <img src="{{ $row2->path_ttd }}" alt="Signature">
                                    </div>
                                    <p style="font-size: 1em; text-decoration: underline;">{{ $row2->jabatan }}</p>
                                </div>
                            </td>
                        @endforeach
                    </tr>
                </table>

                <?php
                $url = config('app.url');
                $qrCodeData = $url . '/sertifikat/checkSertifikat/' . $data_sertifikat_peserta->nomor_sertifikat;
                $qrCode = QrCode::format('svg') // biarin errornya wir -- mlaku kok iki
                    ->size(80)
                    ->errorCorrection('H')
                    ->generate($qrCodeData);
                ?>
                <img src="data:image/svg+xml;base64,{{ base64_encode($qrCode) }}" alt="QR Code">
    </div>
</body>

</html>
