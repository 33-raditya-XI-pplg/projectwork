<?php

namespace App\Imports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;

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
        // validasi
        $messages = [
            '0.integer' => 'Nomer harus berupa angka.',
            '4.integer' => 'NIK :input tidak valid.',
            '6.integer' => 'Tanggal lahir :input tidak valid.',
            '9.email' => 'Email :input tidak valid.',
            '9.unique' => 'Email :input sudah pernah digunakan.',
        ];

        $validator = Validator::make($row, [
            0 => 'integer',
            1 => 'string',
            2 => 'string',
            3 => 'string',
            4 => 'integer',
            5 => 'string',
            6 => 'integer',
            7 => 'string',
            8 => 'string',
            9 => 'email|unique:tb_user,email'
        ], $messages);

        if ($validator->fails()) {
            Alert::error('Error', $validator->errors()->all());
            return null;
        }

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

        return new User($data);
    }
}