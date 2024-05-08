<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate</title>
    <style>
        /* Style for the certificate */
        .certificate {
            background-image: url('{{ public_path('assets/img/dummy/bg/template_piagam_1.png') }}');
            width: 100%;
            height: 100%;
            margin: auto;
            background-size: cover;
            position: relative;
            color: #000;
            font-family: Arial, sans-serif;
            text-align: center;
        }
        .content {
            position: absolute;
            top: 300px; /* Sesuaikan dengan jarak content dari atas */
            width: 100%;
        }
        .signature img {
            width: 100%;
            max-width: 100px; /* Sesuaikan dengan lebar maksimum tanda tangan */
        }
        h1 {
            font-size: 36px;
            margin-bottom: 20px;
        }
        p {
            font-size: 24px;
            margin-bottom: 10px;
        }
        .page-break {
            page-break-after: always;
        }
        .page-break:last-child {
            page-break-after: avoid;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <div class="content">
            <h1 style="font-size: 1em; font-weight: bold;">Certificate of Completion</h1>
            <p style="font-size: 1em; font-weight: bold;">{{ $data_sertifikat_peserta->nama_event }}</p>
            <p style="font-size: 1em;">{{ $data_sertifikat_peserta->nomor_sertifikat }}</p>

            <h2 style="font-size: 1em; font-weight: bold;">{{ $data_sertifikat_peserta->nama_skema }}</h2>
            <p style="font-size: 1em;">has successfully completed the course</p>

            <h3 style="font-size: 1em; font-weight: bold;">{{ $data_sertifikat_peserta->nama_lengkap }}</h3>
            <p style="font-size: 1em;">{{ $data_sertifikat_peserta->keterangan }}</p>

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
</body>
</html>
