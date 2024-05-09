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
            max-width: 100px; /* Ukuran maksimum untuk tanda tangan */
            max-height: 100px; /* Tinggi maksimum untuk tanda tangan */
        }
        /* Add your certificate styling here */
    </style>
</head>
<body>
        @foreach ($data_sertifikat_peserta as $index => $row)
            <div class="{{ $index + 1 < count($data_sertifikat_peserta) ? 'page-break' : '' }}">
                <h1 style="padding-top: 50px">Sertifikat</h1>

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
                        @foreach ($data_penadatangan as $row)
                            <td style="width: 50%;  text-align: center;">
                                <div>
                                    <p style="font-size: 1em; font-weight: bold;">{{ $row->nama_ttd }}</p>
                                    <div class="signature">
                                        <img src="{{ $row->path_ttd }}" alt="Signature">
                                    </div>
                                    <p style="font-size: 1em; text-decoration: underline;">{{ $row->jabatan }}</p>
                                </div>
                            </td>
                        @endforeach
                    </tr>
                </table>
            </div>
        @endforeach

</body>
</html>
