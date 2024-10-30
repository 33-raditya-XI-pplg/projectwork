<?php

namespace App\Http\Controllers\User;

use App\Models\Page;
use App\Models\Testimoni;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Controller;

class TestimoniUserController extends Controller
{

    public function index()
    {

        $testimoni = Testimoni::where('id_user', auth::id())->get();
        $users = User::where('level', 'Pengguna')->get();
        $page = Page::all();
        $Title = 'Management';
        $subtitle = 'Testimoni';
        return view('user.testimoni.index', compact('testimoni', 'page', 'Title'));
    }

    public function store(Request $request)
    {
        // Log incoming data for debugging
        \Log::info('Incoming Request Data:', $request->all());

        $request->validate([
            'page_id' => 'required|integer',
            'id_user' => 'required|exists:tb_user,id_user',
            'email' => 'required|email|max:255',
            'tanggal' => 'required|date',
            'rating' => 'required|integer|min:1|max:5',
            'isi_testimoni' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'nullable|boolean',
            'created_by' => 'required|integer',
        ]);

        // Gather form data and sanitize isi_testimoni
        $data = $request->all();
        $data['isi_testimoni'] = $request->isi_testimoni ? strip_tags($request->isi_testimoni) : '';
        $data['status'] = $request->has('status');

        // Process file upload
        if ($request->hasFile('photo')) {
            $foto = $request->file('photo');
            $filename = 'foto_' . time() . '.' . $foto->getClientOriginalExtension();
            $storedPath = $foto->storeAs('public/testimoni_photos', $filename);
            $data['photo'] = "/storage/testimoni_photos/$filename";
        }


        Testimoni::create($data);
        Alert::success('Berhasil Tersimpan!', 'Data berhasil disimpan.');

        return redirect()->back();
    }

    public function show(string $id)
    {
        $testimoni = Testimoni::with('user')->findOrFail($id);
        $Title = 'Management';
        $subtitle = 'Detail Testimoni';
        return view('user.testimoni.show', compact('testimoni', 'Title', 'subtitle'));
    }

    public function update(Request $request, string $id)
    {
        $testimoni = Testimoni::findOrFail($id);

        $request->validate([
            'page_id' => 'required|integer',
            'email' => 'required|email|max:255',
            'tanggal' => 'required|date',
            'rating' => 'required|integer|min:1|max:5',
            'isi_testimoni' => 'required|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status' => 'nullable|boolean',
            'updated_by' => 'required|integer',
        ]);


        $data = $request->all();
        $data['status'] = $request->has('status') ? true : false;
        $data['isi_testimoni'] = preg_replace('/<p[^>]*>(.*?)<\/p>/i', '$1', $request->isi_testimoni);

        if ($request->hasFile('photo')) {
            if ($testimoni->path_foto) {
                $oldPhotoPath = str_replace('/storage', 'public', $testimoni->photo);
                if (Storage::exists($oldPhotoPath)) {
                    Storage::delete($oldPhotoPath);
                }
            }
            $foto = $request->file('photo');
            $filename = 'foto_' . time() . '.' . $foto->getClientOriginalExtension();
            $storedPath = $foto->storeAs('public/testimoni_photos', $filename);
            Storage::url($storedPath);
            $data = $request->except(['photo']);
            $data['photo'] = "/storage/testimoni_photos/$filename";
        }

        $testimoni->update($data);

        Alert::success('Berhasil Diperbarui!', 'Data berhasil diperbarui.');

        return redirect()->back();
    }

    public function destroy(Testimoni $testimoni, $id)
    {
        // dd("metode destroy dipanggil", $testimoni);
        $testimoni = Testimoni::find($id);
        if ($testimoni) {
            $testimoni->delete();
            return redirect()->route('testimoni-user.index')
                ->with('success', 'Testimoni berhasil dihapus.');
        } else {
            return redirect()->route('testimoni-user.index')
                ->with('success', 'Testimoni eror tidak bisa dikirim');
        }
    }

    public function getEmail($id_user)
    {
        // Assuming you have a `users` table with `nama_lengkap` and `email`
        $user = User::where('id_user', $id_user)->first();

        if ($user) {
            return response()->json(['email' => $user->email]);
        }

        return response()->json(['email' => null], 404);
    }
}
