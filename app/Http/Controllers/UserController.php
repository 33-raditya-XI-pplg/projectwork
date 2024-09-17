<?php

namespace App\Http\Controllers;

use App\Models\User;
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
        $pengguna = User::where('level', 'Pengguna')->get();

        confirmDelete('Hapus Pengguna', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.user.index', compact('pengguna'));
    }

    public function create(User $user)
    {
        return view('admin.user.create', compact('user'));
    }

    public function store(Request $request)
    {
        if (!$request->has('status')) {
            $request->merge([
                'status' => 'Belum Verified'
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

    public function edit($id)
    {
        $pengguna = User::findOrFail($id);

        return view('admin.user.create', compact('pengguna'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);

        if (!$request->has('status')) {
            $request->merge([
                'status' => 'Belum Verified'
            ]);
        }

        if ($request->has('foto')) {
            if (!empty($id->path_foto)) {
                $foto = $request->file('foto');
                $filename = 'foto_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
                $foto->storeAs('public/foto_pengguna', $filename);
            } else {
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
