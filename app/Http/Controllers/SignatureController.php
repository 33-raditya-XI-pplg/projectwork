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
    public function index()
    {
        $tanda_tangan = Ttd::with('ttdInstansi')->get();
        // $instansi = Instansi::all();
        $institutions = DB::table('tb_instansi')->pluck('nama_instansi', 'id_instansi');
        $Title = 'Master Data';
        $subtitle = 'Penandatangan';
        confirmDelete('Hapus Tanda Tangan', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.tandatangan.index', compact('tanda_tangan', 'institutions', 'Title', 'subtitle'));
    }

    public function store(Request $request)
    {

        if (!$request->has('status')) {
            $request->merge([
                'status' => 'Nonaktif'
            ]);
        }

        $data = $request->all();
        if ($request->hasFile('path_ttd')) {
            $foto = $request->file('path_ttd');
            $filename = 'ttd_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
            $storedPath = $foto->storeAs('public/ttd', $filename);
            Storage::url($storedPath);
            $data = $request->except(['path_ttd']);
            $data['path_ttd'] = "/storage/ttd/$filename";
        }

        Ttd::create($data);

        Alert::success('Berhasil Tersimpan!', 'Data berhasil ditambahkan.');
        return redirect()->back();
    }
    public function update(Request $request, $id)
    {
        $tanda_tangan = Ttd::find($id);
        if (!$request->has('status')) {
            $request->merge([
                'status' => 'Nonaktif'
            ]);
        }
        $data = $request->all();
        if ($request->hasFile('path_ttd')) {
            if ($tanda_tangan->path_ttd) {
                $oldPhotoPath = str_replace('/storage', 'public', $tanda_tangan->path_ttd);
                if (Storage::exists($oldPhotoPath)) {
                    Storage::delete($oldPhotoPath);
                }
            }
            $foto = $request->file('path_ttd');
            $filename = 'ttd_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
            $storedPath = $foto->storeAs('public/ttd', $filename);
            Storage::url($storedPath);
            $data = $request->except(['path_ttd']);
            $data['path_ttd'] = "/storage/ttd/$filename";
        }


        $tanda_tangan->update($data);
        Alert::success('Berhasil Tersimpan!', 'Data berhasil diperbarui.');

        return redirect()->back();
    }

    public function destroy($id)
    {
        $ttd = Ttd::find($id);
        $checkChildID = DB::table('tb_penandatangan')
            ->where('ttd_id', $id)->count();

        if ($checkChildID > 0) {
            Alert::error('Gagal Menghapus!', 'Tidak dapat menghapus karena data masih digunakan.');
            return redirect()->back();
        }

        if (!empty($ttd->path_ttd)) {
            if (file_exists(public_path($ttd->path_ttd))) {
                unlink(public_path($ttd->path_ttd));
                $ttd->delete();
            } else {
                $ttd->delete();
            }
        } else {
            $ttd->delete();
        }

        toast('Tanda Tangan berhasil dihapus.', 'success');

        return redirect()->back();
    }
}
