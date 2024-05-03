<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\User\NilaiController;

class UserController extends Controller
{
    public function index() {
        $pengguna = User::where('level', 'Pengguna')->get();

        confirmDelete('Hapus Pengguna', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.user.index', compact('pengguna'));
    }

    public function create(User $user) {
        return view('admin.user.create', compact('user'));
    }

    public function store(Request $request) {
        dd($request);
        if (!$request->has('status')) {
            $request->merge([
            'status' => 'Nonaktif'
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
        $pengguna = User::findOrFail($id);

        return view('admin.user.create', compact('pengguna'));
    }

    public function update(Request $request, $id) {
        $user = User::find($id);

        if (!$request->has('status')) {
            $request->merge([
               'status' => 'Tidak Aktif'
            ]);
         }

         if ($request->has('foto')) {
            if (!empty($id->path_foto)) {
                $foto = $request->file('foto');
                $filename = 'foto_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
                $foto->storeAs('public/foto_pengguna', $filename);
            }
            else {
                $foto = $request->file('foto');
                $filename = 'foto_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
                $stored = $foto->storeAs('public/foto_pengguna', $filename);

                $request->merge([
                    'path_foto' => Storage::url($stored)
                ]);
            }

        }

        $user->update($request->all());

        Alert::success('Berhasil Tersimpan!', 'Data berhasil diperbarui.');
        return redirect()->route('user.index');
    }

    public function destroy($id) {
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

        toast('Pengguna terhapus!','success');
        return redirect()->back();
    }
}
