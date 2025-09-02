<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Page;
use App\Imports\UsersImport;
use Illuminate\Http\Request;

use App\Imports\FirstSheetImport;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Controllers\User\NilaiController;

class UserController extends Controller
{
    public function index()
    {
        $pengguna = User::where('level', 'Pengguna')->get()->map(function ($user) {
            //logika lengkapi profile    
            $user->isProfileComplete = !empty($user->nama_lengkap) && !empty($user->alamat) && !empty($user->jenis_kelamin)
                && !empty($user->tgl_lahir) && !empty($user->tempat_lahir) && !empty($user->nomor_induk)
                && !empty($user->alamat_kota) && !empty($user->nama_sekolah) && !empty($user->jurusan)
                && !empty($user->jenjang) && !empty($user->tahun_lulus);
            return $user;
        });
        $page = Page::all();
        $Title = 'Master Data';
        $subtitle = 'Pengguna';
        return view('admin.user.index', compact('pengguna', 'page', 'Title', 'subtitle'));
    }

    public function create(User $user)
    {
        $institutions = DB::table('tb_instansi')->pluck('nama_instansi', 'id_instansi');
        // $regencies = DB::table('regencies')->pluck('name', 'id');
        $Title = 'Master Data';
        $subtitle = 'Pengguna create';
        return view('admin.user.create', compact('user', 'institutions', /*'regencies',*/ 'Title', 'subtitle'));
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


        if (!$request->has('status')) {
            $request->merge([
                'status' => 'Belum Verified'
            ]);
        }


        $nama_sekolah = DB::table('tb_instansi')
            ->where('id_instansi', $request->instansi_id)
            ->value('nama_instansi');

        $data = $request->all();
        $data['nama_sekolah'] = $nama_sekolah;

        if ($request->hasFile('path_foto')) {
            $foto = $request->file('path_foto');
            $filename = 'foto_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
            $storedPath = $foto->storeAs('public/foto_pengguna', $filename);
            Storage::url($storedPath);
            $data = $request->except(['path_foto']);
            $data['path_foto'] = "/storage/foto_pengguna/$filename";
        }
        // dd($data);
        User::create($data);

        Alert::success('Berhasil Tersimpan!', 'Data berhasil ditambahkan.');
        return redirect()->route('user.index');
    }

    public function edit($id)
    {
        $pengguna = User::findOrFail($id);
        $institutions = DB::table('tb_instansi')->pluck('nama_instansi', 'id_instansi');
        $regencies = DB::table('regencies')->pluck('name', 'id');

        $Title = 'Master Data';
        $subtitle = 'Pengguna edit';
        return view('admin.user.create', compact('pengguna', 'institutions', 'regencies', 'Title', 'subtitle'));
    }

    public function update(Request $request, $id)
    {

        $user = User::find($id);

        if (!$request->has('status')) {
            $request->merge(['status' => 'Belum Verified']);
        }


        $nama_sekolah = DB::table('tb_instansi')
            ->where('id_instansi', $request->instansi_id)
            ->value('nama_instansi');

        $data = $request->all();
        $data['nama_sekolah'] = $nama_sekolah;

        if ($request->hasFile('path_foto')) {
            if ($user->path_foto) {
                $oldPhotoPath = str_replace('/storage', 'public', $user->path_foto);
                if (Storage::exists($oldPhotoPath)) {
                    Storage::delete($oldPhotoPath);
                }
            }
            $foto = $request->file('path_foto');
            $filename = 'foto_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
            $storedPath = $foto->storeAs('public/foto_pengguna', $filename);
            Storage::url($storedPath);
            $data = $request->except(['path_foto']);
            $data['path_foto'] = "/storage/foto_pengguna/$filename";
        }

        $user->update($data);

        Alert::success('Berhasil Tersimpan!', 'Data berhasil diperbarui.');
        return redirect()->route('user.index');
    }

    public function show($id)
    {
        $pengguna = User::findOrFail($id);
        $Title = 'Management';
        $subtitle = 'Detail Pengguna';
        return view('admin.user.show', compact('pengguna', 'Title', 'subtitle'));
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->level == 'Pengguna') {
            $checkChildID = DB::table('tb_peserta')
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

        toast('Pengguna terhapus!', 'success');
        return redirect()->back();
    }

    public function import(Request $request)
    {
        Excel::import(new UsersImport, $request->file('data-peserta'));

        return redirect()->route('user.index')->with('success', 'All good!');
    }

    public function updateStatus(Request $request, $id)
    {
        $user = User::find($id);
        if (empty($user->nomor_induk) || empty($user->tgl_lahir) || empty($user->tempat_lahir)) {
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
