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
    </style>
</head>
<body>
    <div>
        <h1 style="padding-top: 320px">Sertifikat</h1>

        <p>Nomor Sertifikat: {{ $data_sertifikat_peserta->nomor_sertifikat }}</p>

        <p>Nama Peserta: {{ $data_sertifikat_peserta->nama_lengkap }}</p>
        <p>Event: {{ $data_sertifikat_peserta->nama_event }}</p>
        <p>Jenis Event: {{ $data_sertifikat_peserta->nama_jenis_event }}</p>

        <p>Skema: {{ $data_sertifikat_peserta->nama_skema }}</p>

        <p>Nilai: {{ $data_sertifikat_peserta->nilai }}</p>
        <p>Keterangan: {{ $data_sertifikat_peserta->keterangan }}</p>

        <p>Terbit: {{ \Carbon\Carbon::parse($data_sertifikat_peserta->tgl_terbit)->format('d-F-Y') }}</p>
        <p>Berakhir: {{ \Carbon\Carbon::parse($data_sertifikat_peserta->tgl_berakhir)->format('d-F-Y') }}</p>
        <p>Masa Berlaku: {{ $data_sertifikat_peserta->masa_berlaku }}</p>
        
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
            $qrCodeData = 'http://127.0.0.1:8000/sertifikat/checkSertifikat/'. $data_sertifikat_peserta->nomor_sertifikat;  
            $qrCode = QrCode::format('svg') // biarin errornya wir -- mlaku kok iki
                    ->size(80)
                    ->errorCorrection('H')
                    ->generate($qrCodeData);
        ?>
        <img src="data:image/svg+xml;base64,{{ base64_encode($qrCode) }}" alt="QR Code">
    </div>
</body>
</html>
