<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class UserController extends Controller
{
    public function index() {

        confirmDelete('Hapus Event', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.user.index');
    }

    public function store(Request $request) {
        Alert::success('Berhasil Tersimpan!', 'Data berhasil ditambahkan.');

        return redirect()->back();
    }

    public function update($id) {
        Alert::success('Berhasil Tersimpan!', 'Data berhasil diperbarui.');

        return redirect()->back();
    }

    public function destroy($id) {

        toast('Pengguna terhapus!','success');
        return redirect()->back();
    }
}
