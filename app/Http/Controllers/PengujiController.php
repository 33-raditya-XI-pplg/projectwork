<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Instansi;
use App\Models\Page;
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

        foreach ($penguji as $user) {
            $user->isProfileComplete = !empty($user->nama_lengkap) &&
                !empty($user->alamat) &&
                !empty($user->nomor_induk) &&
                !empty($user->alamat_kota) &&
                // !empty($user->penguji) &&
                // !empty($user->jabatan_penguji) &&
                !empty($user->no_telp) &&
                !empty($user->email) &&
                !empty($user->pengalaman) &&
                !empty($user->keahlian);
        }
        // $instansi = Instansi::all();
        $page = Page::all();
        $institutions = DB::table('tb_instansi')->pluck('nama_instansi', 'id_instansi');
        $regencies = DB::table('regencies')->pluck('name', 'id');
        $isProfileComplete = !empty($user->nama_lengkap) && !empty($user->alamat) && !empty($user->jenis_kelamin)
            && !empty($user->tgl_lahir) && !empty($user->tempat_lahir) && !empty($user->nomor_induk) && !empty($user->nomor_induk)
            && !empty($user->alamat_kota) && !empty($user->penguji) && !empty($user->type_penguji);
        $Title = 'Master Data';
        $subtitle = 'Mentor';
        confirmDelete('Hapus Penguji', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.penguji.index', compact('penguji', 'page', 'institutions', 'regencies', 'Title', 'subtitle'));
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
                'status' => 'Belum Verified'
            ]);
        }

        dd($request->all());
        ;
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
                'status' => 'Belum Verified'
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

    public function show($id)
    {
        $penguji = User::findOrFail($id);
        $Title = 'Management';
        $subtitle = 'Detail Testimoni';
        return view('admin.penguji.show', compact('penguji', 'Title', 'subtitle'));

        // Simpan foto baru
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->level == 'Penguji') {
            $checkChildID = DB::table('tb_menguji')
                ->count();

            if ($checkChildID > 0) {
                Alert::error('Gagal Menghapus!', 'Tidak dapat menghapus karena data masih digunakan.');
                return redirect()->back();
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
    public function updateStatus(Request $request, $id)
    {
        $user = User::find($id);
        if (empty($user->nomor_induk) || empty($user->nama_lengkap) || empty($user->alamat) || empty($user->alamat_kota) || empty($user->email) || empty($user->keahlian) || empty($user->pengalaman) || empty($user->no_telp) || empty($user->jabatan_penguji)) {
            return response()->json([
                'message' => 'Profile pengguna belum lengkap. Tidak dapat Memverifikasi Pengguna'
            ], 400);
        }
        $user->status = $request->status;
        $user->save();


        return response()->json([
            'message' => 'Status pengguna berhasil diperbarui menjadi ' . $request->status
        ]);
    }
}
