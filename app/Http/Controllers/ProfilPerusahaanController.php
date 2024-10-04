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
    public function index()
    {

        $page = Page::get();
        $profil = Profil_Perusahaan::get();
        $Title = 'Management';
        $subtitle = 'Profile Perusahaan';
        confirmDelete('Hapus Profil', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.profile_perusahaan.index', compact('page', 'profil', 'Title', 'subtitle'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'page_id' => 'required|exists:tb_page,id_page',
            'tentang_kami' => 'required|string',
            'path_struktur_organisasi' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'visi' => 'required|string',
            'misi' => 'required|string',
            'sejarah' => 'required|string',
            'status' => 'nullable|boolean',
        ]);

        // Sanitize fields
        $data['tentang_kami'] = strip_tags($data['tentang_kami']);
        $data['visi'] = strip_tags($data['visi']);
        $data['misi'] = strip_tags($data['misi']);
        $data['sejarah'] = strip_tags($data['sejarah']);
        $data['status'] = $request->has('status') ? true : false;


        if ($request->hasFile('path_struktur_organisasi')) {
            $imagePath = $request->file('path_struktur_organisasi')->store('struktur_organisasi', 'public');
            $data['path_struktur_organisasi'] = $imagePath;
        }

        Profil_Perusahaan::create($data);

        Alert::success('Success', 'Profil Perusahaan berhasil ditambahkan!');
        return redirect()->route('profil.index');
    }

    public function update(Request $request, $id)
    {
        $profil = Profil_Perusahaan::findOrFail($id);

        $data = $request->validate([
            'page_id' => 'required|exists:tb_page,id_page',
            'tentang_kami' => 'required|string',
            'path_struktur_organisasi' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'visi' => 'required|string',
            'misi' => 'required|string',
            'sejarah' => 'required|string',
            'status' => 'nullable|boolean',
        ]);


        $data['tentang_kami'] = strip_tags($data['tentang_kami']);
        $data['visi'] = strip_tags($data['visi']);
        $data['misi'] = strip_tags($data['misi']);
        $data['sejarah'] = strip_tags($data['sejarah']);
        $data['status'] = $request->has('status') ? true : false;


        if ($request->hasFile('path_struktur_organisasi')) {

            if ($profil->path_struktur_organisasi) {
                Storage::disk('public')->delete($profil->path_struktur_organisasi);
            }

            $imagePath = $request->file('path_struktur_organisasi')->store('struktur_organisasi', 'public');
            $data['path_struktur_organisasi'] = $imagePath;
        }

        $profil->update($data);

        Alert::success('Success', 'Profil Perusahaan berhasil diperbarui!');
        return redirect()->route('profil.index');
    }






    public function rincian($id)
    {
        // Mengambil data berdasarkan id
        $profil = Profil_Perusahaan::findOrFail($id);
    
        // Kirim data profil ke view 'rincian'
        return view('admin.profile_perusahaan.rincian', compact('profil'));
    }
    




    public function destroy($id)
    {
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
            Alert::success('Berhasil Menghapus!', 'Profil terhapus!');
        } else {
            Log::error("Profil not found with ID: " . $id);
            Alert::error('Gagal Menghapus!', 'Profil not found!');
        }

        return redirect()->back();
    }
}
