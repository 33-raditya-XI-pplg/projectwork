<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Shared\Date;

class UsersImport implements ToModel, WithStartRow, WithMultipleSheets
{
    public function sheets(): array
    {
        return [
            'PENGGUNA' => $this
        ];
    }

    public function startRow(): int
    {
        return 5;
    }

    /**
     * @param array $row
     *
     * @return User|null
     */
    public function model(array $row)
    {

        $data = [
            'instansi_id' => intval($row[0]),
            'nama_lengkap' => $row[1],
            'jenis_kelamin' => $row[2],
            'no_telp' => $row[3],
            'nomor_induk' => intval($row[4]),
            'tempat_lahir' => $row[5],
            'tgl_lahir' => Date::excelToDateTimeObject($row[6])->format('Y-m-d'),
            'alamat' => $row[7],
            'alamat_kota' => $row[8],
            'email' => $row[9],
            'password' => 'user123',
            'level' => 'pengguna',
            'status' => 'Aktif'

        ];

        // dd($data);
        return new User($data);
    }
}