<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Instansi;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class PengujiController extends Controller
{
    public function index() {
        $penguji = User::where('level', 'Penguji')
            ->with('userInstansi')->get();
        $instansi = Instansi::all();

        confirmDelete('Hapus Penguji', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.penguji.index', compact('penguji', 'instansi'));
    }

    public function store(Request $request) {

        if (!$request->has('status')) {
            $request->merge([
            'status' => 'Nonaktif'
        ]);
        }

        $foto = $request->file('foto');
        $filename = 'foto_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
        $stored = $foto->storeAs('public/foto_penguji', $filename);

        $request->merge([
            'path_foto' => Storage::url($stored)
        ]);

        User::create($request->all());

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

        if ($request->has('foto')) {
            $foto = $request->file('foto');
            $filename = 'foto_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
            $foto->storeAs('public/foto_penguji', $filename);
        }

        $user = User::find($id);
        $user->update($request->all());
        Alert::success('Berhasil Tersimpan!', 'Data berhasil diperbarui.');

        return redirect()->back();
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        // BUG : Somehow path_foto not exists
        // quick fix : let-say path_foto can't be manually deleted on public_path
        // if (!empty($user->path_foto) && Storage::exists($user->path_foto)) {
        //     Storage::delete($user->path_foto);
        // }
        if (!empty($user->path_foto)) {
            unlink(public_path($user->path_foto));
            $user->delete();
        }
        $user->delete();
        
        toast('User berhasil dihapus.', 'success');
        return redirect()->back();
    }
}
