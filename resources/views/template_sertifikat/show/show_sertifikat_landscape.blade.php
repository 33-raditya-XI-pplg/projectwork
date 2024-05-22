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

        .page-break {
            page-break-after: always;
        }
        .page-break:last-child {
            page-break-after: avoid;
        }
        .signature img {
            max-width: 100px;
            max-height: 100px;
        }
        .tittle{
            margin-top:50px;
            font-size:22px;
            font-weight: bold;
        }
        .nomor-sertif{
            font-size: 14px;
            font-weight: bold;
        }
        .nama{
            font-size: 22px;
            font-weight: bold;
        }
        .ket-1{
            font-size:14px;
            font-style: normal;
        }
        .ket-1 a{
            font-size:14px;
            font-weight: bold;
        }
        .ket-2{
            font-size:14px;
            font-style: normal;
        }
        .ket-2 a{
            font-size:14px;
            font-weight: bold;
        }
        .ket-0{
            font-size:12px;
            font-style: normal;
        }
        .ket-00{
            font-size:12px;
            font-style: italic;
        }
    </style>
</head>
<body>
    <div>
        <h1 class="tittle">SERTIFIKAT UJI KOMPETENSI</h1>

        <p class="nomor-sertif">Nomor Sertifikat: {{ $data_sertifikat_peserta->nomor_sertifikat }}</p>

        <p class="nama">{{ $data_sertifikat_peserta->nama_lengkap }}</p>
        <p class="ket-0">Telah mengikuti Uji Kompetensi Keahlian</p>
        <p class="ket-00">has taken the competency test</p>
        <p class="ket-1">Event: <a>{{ $data_sertifikat_peserta->nama_event }}</a></p>
        <p class="ket-1">Jenis Event: <a>{{ $data_sertifikat_peserta->nama_jenis_event }}</a></p>

        <p class="ket-1">Skema: <a>{{ $data_sertifikat_peserta->nama_skema }}</a></p>

        <p class="ket-2">Nilai: <a>{{ $data_sertifikat_peserta->nilai }}</a></p>
        <p class="ket-2">Keterangan: <a>{{ $data_sertifikat_peserta->keterangan }}</a></p>

        <p class="ket-2">Terbit: <a>{{ \Carbon\Carbon::parse($data_sertifikat_peserta->tgl_terbit)->format('d-F-Y') }}</a></p>
        <p class="ket-2">Berakhir: <a>{{ \Carbon\Carbon::parse($data_sertifikat_peserta->tgl_berakhir)->format('d-F-Y') }}</a></p>
        <p class="ket-2">Masa Berlaku: <a>{{ $data_sertifikat_peserta->masa_berlaku }}</a></p>

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
            $qrCodeData = $data_sertifikat_peserta->nomor_sertifikat;
            $qrCode = QrCode::format('svg') // biarin errornya wir -- mlaku kok iki
                    ->size(80)
                    ->errorCorrection('H')
                    ->generate($qrCodeData);
        ?>
        <img src="data:image/svg+xml;base64,{{ base64_encode($qrCode) }}" alt="QR Code">
    </div>

</body>
</html>
