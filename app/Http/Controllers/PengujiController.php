<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Instansi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class PengujiController extends Controller
{
    public function index()
    {
        $penguji = User::where('level', 'Penguji')
            ->with('userInstansi')->get();
        // $instansi = Instansi::all();
        $institutions = DB::table('tb_instansi')->pluck('nama_instansi', 'id_instansi');
        $regencies = DB::table('regencies')->pluck('name', 'id');
        $Title = 'Master Data';
        $subtitle = 'Penguji';
        confirmDelete('Hapus Penguji', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.penguji.index', compact('penguji', 'institutions', 'regencies', 'Title', 'subtitle'));
    }

    public function store(Request $request)
    {

        $request->validate([
            'email' => 'required|email|unique:tb_user,email|regex:/^.+@gmail\.com$/',
        ], [
            'email.required' => 'Email harus diisi.',
            'email.email' => 'Silakan masukan alamat email yang valid.',
            'email.unique' => 'Email sudah terdaftar.',
            'email.regex' => 'Hanya alamat gmail yang diperboleh kan .',
        ]);

        // dd($request);
        if (!$request->has('status')) {
            $request->merge([
                'status' => 'Nonaktif'
            ]);
        }

        $data = $request->all();
        if ($request->hasFile('path_foto')) {
            $foto = $request->file('path_foto');
            $filename = 'foto_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
            $storedPath = $foto->storeAs('public/foto_penguji', $filename);
            Storage::url($storedPath);
            $data = $request->except(['path_foto']);
            $data['path_foto'] = "/storage/foto_penguji/$filename";
        }


        User::create($data);

        Alert::success('Berhasil Tersimpan!', 'Data berhasil ditambahkan.');
        return redirect()->back();
    }
    public function update(Request $request, $id)
    {
        // dd($request);
        $user = User::find($id);

        if (!$request->has('status')) {
            $request->merge([
                'status' => 'Nonaktif'
            ]);
        }
        $data = $request->all();

        if ($request->hasFile('path_foto')) {
            if ($user->path_foto) {
                $oldPhotoPath = str_replace('/storage', 'public', $user->path_foto);
                if (Storage::exists($oldPhotoPath)) {
                    Storage::delete($oldPhotoPath);
                }
            }
            $foto = $request->file('path_foto');
            $filename = 'foto_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
            $storedPath = $foto->storeAs('public/foto_pengguji', $filename);
            Storage::url($storedPath);
            $data = $request->except(['path_foto']);
            $data['path_foto'] = "/storage/foto_pengguji/$filename";
        }

        $user->update($data);
        Alert::success('Berhasil Tersimpan!', 'Data berhasil diperbarui.');

        return redirect()->back();
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->level == 'Penguji') {
            $checkChildID = DB::table('tb_menguji')
                ->where('user_id', $id)
                ->count();

            if ($checkChildID > 0) {
                Alert::error('Gagal Menghapus!', 'Tidak dapat menghapus karena data masih digunakan.');
                return redirect()->back();
            }
        }

        if (!empty($user->path_foto)) {
            if (file_exists(public_path($user->path_foto))) {
                unlink(public_path($user->path_foto));
                $user->delete();
            } else {
                $user->delete();
            }
        } else {
            $user->delete();
        }

        toast('User berhasil dihapus.', 'success');
        return redirect()->back();
    }
}
