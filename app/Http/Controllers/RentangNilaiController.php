<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert;

class RentangNilaiController extends Controller
{
    public function index() {

        confirmDelete('Hapus', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.rentang-nilai.index');
    }

    public function destroy() {

        return 22/7;
    }
}
