<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Profil;
use App\Models\Profil_Perusahaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class ProfilPerusahaanController extends Controller
{
    public function index() {

        $page = Page::get();
        $profil = Profil_Perusahaan::get();
        confirmDelete('Hapus Profil', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.profile_perusahaan.index', compact('page', 'profil',));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'page_id' => 'required|exists:tb_page,id_page',
            'tentang_kami' => 'required|string',
            'path_struktur_organisasi' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // Validasi tambahan untuk tipe dan ukuran file
            'visi' => 'required|string',
            'misi' => 'required|string',
            'sejarah' => 'required|string',
            'status' => 'nullable|string',
        ]);

        if ($request->hasFile('path_struktur_organisasi')) {
            $imagePath = $request->file('path_struktur_organisasi')->store('struktur_organisasi', 'public');
            $data['path_struktur_organisasi'] = $imagePath;
        }

        Profil_Perusahaan::create($data);
        return redirect()->route('profil.index')->with('success', 'Data berhasil disimpan');
    }




    public function update(Request $request, $id)
    {
        $profil = Profil_Perusahaan::findOrFail($id);

        $data = $request->validate([
            'page_id' => 'required|exists:tb_page,id_page',
            'tentang_kami' => 'required|string',
            'path_struktur_organisasi' => 'nullable|image',
            'visi' => 'required|string',
            'misi' => 'required|string',
            'sejarah' => 'required|string',
            'status' => 'nullable|string',
        ]);

        if ($request->hasFile('path_struktur_organisasi')) {

            if ($profil->path_struktur_organisasi) {
                Storage::disk('public')->delete($profil->path_struktur_organisasi);
            }

            $imagePath = $request->file('path_struktur_organisasi')->store('struktur_organisasi', 'public');
            $data['path_struktur_organisasi'] = $imagePath;
        }

        $profil->update($data);
        return redirect()->route('profil.index');
    }










    public function destroy($id) {
        $profil = Profil_Perusahaan::find($id);

        if ($profil) {
            $bannerPath = public_path($profil->path_banner);


            if (is_file($bannerPath)) {
                try {

                    if (unlink($bannerPath)) {
                        Log::info("Successfully deleted file: " . $bannerPath);
                    } else {
                        Log::error("Failed to delete file: " . $bannerPath);
                    }
                } catch (\Exception $e) {
                    Log::error("Exception while deleting file: " . $bannerPath . " - " . $e->getMessage());
                }
            } else {
                Log::warning("Path is not a file or does not exist: " . $bannerPath);
            }


            $profil->delete();
            toast('Profil terhapus!', 'success');
        } else {
            Log::error("Blog not found with ID: " . $id);
            toast('Profil not found!', 'error');
        }

        return redirect()->back();
    }
}
