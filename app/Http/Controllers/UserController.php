<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

use App\Models\User;
use App\Models\Instansi;

class UserController extends Controller
{
    public function index() {
        $pengguna = User::where('level', 'Pengguna')
            ->with('userInstansi')->get();
        $instansi = Instansi::all();

        confirmDelete('Hapus Pengguna', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.user.index', compact('pengguna','instansi'));
    }

    public function create() {
        return view('admin.user.create');
    }

    public function store(Request $request) {
        if (!$request->has('status')) {
            $request->merge([
            'status' => 'Tidak Aktif'
        ]);
        }

        $foto = $request->file('foto');
        $filename = 'foto_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
        $stored = $foto->storeAs('public/foto_pengguna', $filename);

        $request->merge([
            'path_foto' => Storage::url($stored)
        ]);

        User::create($request->all());

        Alert::success('Berhasil Tersimpan!', 'Data berhasil ditambahkan.');
        return redirect()->route('user.index');
    }

    public function edit($id) {
        $user = User::findOrFail($id);

        return view('admin.user.edit', compact('user'));
    }

    public function update(Request $request, $id) {
        if (!$request->has('status')) {
            $request->merge([
               'status' => 'Tidak Aktif'
            ]);
         }
        
        if ($request->has('foto')) {
            $foto = $request->file('foto');
            $filename = 'foto_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
            $foto->storeAs('public/foto_pengguna', $filename);
        }

        $user = User::find($id);
        $user->update($request->all());

        Alert::success('Berhasil Tersimpan!', 'Data berhasil diperbarui.');
        return redirect()->route('user.index');
    }

    public function destroy($id) {
        User::destroy($id);
        toast('Pengguna terhapus!','success');
        return redirect()->back();
    }
}
