<?php

namespace App\Http\Controllers;

use App\Models\Ttd;
use App\Models\Instansi;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class SignatureController extends Controller
{
    public function index() {
        $tanda_tangan = Ttd::with('ttdInstansi')->get();
        $instansi = Instansi::all();

        confirmDelete('Hapus Tanda Tangan', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.tandatangan.index', compact('tanda_tangan', 'instansi'));
    }

    public function store(Request $request) {

        if (!$request->has('status')) {
            $request->merge([
            'status' => 'Nonaktif'
        ]);
        }

        $foto = $request->file('foto_ttd');
        $filename = 'ttd_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
        $stored = $foto->storeAs('public/ttd', $filename);

        $request->merge([
            'path_ttd' => Storage::url($stored)
        ]);

        Ttd::create($request->all());

        Alert::success('Berhasil Tersimpan!', 'Data berhasil ditambahkan.');
        return redirect()->back();
    }
    public function update(Request $request, $id)
    {
        if (!$request->has('status')) {
            $request->merge([
                'status' => 'Nonaktif'
            ]);
        }

        if ($request->has('foto_ttd')) {
            $foto = $request->file('foto_ttd');
            $filename = 'ttd_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
            $foto->storeAs('public/ttd', $filename);
        }

        $tanda_tangan = Ttd::find($id);
        $tanda_tangan->update($request->all());
        Alert::success('Berhasil Tersimpan!', 'Data berhasil diperbarui.');

        return redirect()->back();
    }

    public function destroy($id)
    {
        $foto = Ttd::find($id)->path_ttd;
        $checkChildID = DB::table('tb_penandatangan')
                    ->where('ttd_id', $id)->count();

        if ($checkChildID > 0) {
            Alert::error('Gagal Menghapus!', 'Tidak dapat menghapus karena data masih digunakan.');
            return redirect()->back();
        }
        
        unlink(public_path($foto));
        Ttd::destroy($id);
        toast('Tanda Tangan berhasil dihapus.', 'success');

        return redirect()->back();
    }
}
