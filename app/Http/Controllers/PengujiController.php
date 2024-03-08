<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class PengujiController extends Controller
{
    public function index() {
        confirmDelete('Hapus Penguji', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.penguji.index');

    }

    public function store() {
        Alert::success('Berhasil Tersimpan!', 'Data berhasil ditambahkan.');
        return redirect()->back();
    }

    public function update() {

        Alert::success('Berhasil Tersimpan!', 'Data berhasil diperbarui.');
        return redirect()->back();

    }

    public function destroy() {
        toast('Penguji Terhapus', 'success');
        return redirect()->back();

    }
}
