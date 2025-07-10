<!DOCTYPE html>
<html>
<head>
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
    </style>
</head>
<body>
        @foreach ($data_sertifikat_peserta as $index => $row)
            <div class="{{ $index + 1 < count($data_sertifikat_peserta) ? 'page-break' : '' }}">
                <h1 style="padding-top: 320px">Sertifikat</h1>

                <p>Nomor Sertifikat: {{ $row->nomor_sertifikat }}</p>

                <p>Nama Peserta: {{ $row->nama_lengkap }}</p>
                <p>Event: {{ $row->nama_event }}</p>
                <p>Jenis Event: {{ $row->nama_jenis_event }}</p>

                <p>Skema: {{ $row->nama_skema }}</p>

                <p>Nilai: {{ $row->nilai }}</p>
                <p>Keterangan: {{ $row->keterangan }}</p>

                <p>Terbit: {{ \Carbon\Carbon::parse($row->tgl_terbit)->format('d-F-Y') }}</p>
                <p>Berakhir: {{ \Carbon\Carbon::parse($row->tgl_berakhir)->format('d-F-Y') }}</p>
                <p>Masa Berlaku: {{ $row->masa_berlaku }}</p>

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
                    $qrCodeData = $url . '/sertifikat/checkSertifikat/'. $row->nomor_sertifikat;
                    $qrCode = QrCode::format('svg') // biarin errornya wir -- mlaku kok iki
                            ->size(80)
                            ->errorCorrection('H')
                            ->generate($qrCodeData);
                ?>
                <img src="data:image/svg+xml;base64,{{ base64_encode($qrCode) }}" alt="QR Code">
            </div>
        @endforeach

</body>
</html>
