<!DOCTYPE html>
<html>
<head>
    <style>
        body {
            margin: 50px;
            padding: 50px;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .content {
            position: relative;
            z-index: 1;
            color: #fff;
            padding: 20px;
        }
        .signature img {
            max-width: 100px; 
            max-height: 100px;
        }
    </style>
</head>
<body>
    <div>
        <h1 style="padding-top: 50px">Sertifikat</h1>

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

        <img src="data:image/svg+xml;base64,{{ base64_encode($qrCode) }}" alt="QR Code">
    </div>
</body>
</html>
