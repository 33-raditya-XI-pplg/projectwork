<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Rentang_Nilai as Rentang;
class RentangNilaiController extends Controller
{
    public function index() {

        $rentang = Rentang::get();
        confirmDelete('Hapus', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.rentang-nilai.index', compact('rentang'));
    }

    public function store(Request $request) {

        Rentang::create($request->all());
        
        Alert::success('Berhasil', 'Data berhasil ditambahkan.');
        return redirect()->back();
    }

    public function update(Request $request, $id) {

        $rentang = Rentang::find($id);
        $rentang->update($request->all());
        
        Alert::success('Berhasil', 'Data berhasil diubah.');
        return redirect()->back();
    }

    public function destroy($id) {

        Rentang::destroy($id);

        Alert::success('Berhasil', 'Data berhasil dihapus.');
        return redirect()->back();
    }
}
