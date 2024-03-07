<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;


class EventController extends Controller
{
    public function index() {

        confirmDelete('Hapus Event', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.event.index');
    }

    public function store(Request $request) {

        Alert::success('Berhasil Tersimpan!', 'Data berhasil diperbarui.');

        return redirect()->back();
    }

    public function update($id) {
        Alert::success('Berhasil Tersimpan!', 'Data berhasil diubah.');

        return redirect()->back();
    }

    public function destroy() {

        toast('Event terhapus!','success');
        return redirect()->back();
    }
}
