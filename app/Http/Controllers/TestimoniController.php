<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Testimoni;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Facades\Storage;

class TestimoniController extends Controller
{
    public function index()
    {
        $testimoni = Testimoni::with('user')->get();
        $page = Page::all();
        $testimonials = Testimoni::where('status', 1)->orderBy('tanggal', 'desc')->get();
        $users = User::where('level', 'Pengguna')->get();
        $Title = 'Management';
        $subtitle = 'Testimoni';
        return view('admin.testimoni.index', compact('testimoni', 'users', 'page', 'testimonials', 'Title', 'subtitle'));
    }



    public function store(Request $request)
    {
        // Debug untuk melihat semua input yang diterima
        // dd($request->all());

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
        $data = $request->all();
        $data['isi_testimoni'] = $request->isi_testimoni ? strip_tags($request->isi_testimoni) : '';
        $data['status'] = $request->has('status');

        $photoPath = null;
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


    public function update(Request $request, Testimoni $testimoni)
    {

        $request->validate([
            'status' => 'nullable|boolean',
            'updated_by' => 'required|integer',
        ]);


        if ($request->hasFile('photo')) {

            if ($testimoni->photo) {
                Storage::disk('public')->delete($testimoni->photo);
            }


            $photoPath = $request->file('photo')->store('testimoni_photos', 'public');
            $testimoni->photo = $photoPath;
        }


        $testimoni->update([
            'status' => $request->status,
            'updated_by' => $request->updated_by,

        ]);

        return redirect()->route('testimoni.index')
            ->with('success', 'Testimoni updated successfully.');
    }


    public function show($id)
    {
        $testimoni = Testimoni::with('user')->findOrFail($id);
        $Title = 'Management';
        $subtitle = 'Detail Testimoni';
        return view('admin.testimoni.show', compact('testimoni', 'Title', 'subtitle'));
    }


    public function destroy(Testimoni $testimoni)
    {
        $testimoni->delete();

        return redirect()->route('testimoni.index')
            ->with('success', 'Testimoni deleted successfully.');
    }

    // Uncomment and implement if needed
    /*
    public function create()
    {
        $page = Page::all();
        return view('admin.testimoni.create', compact('page'));
    }

    public function edit(Testimoni $testimoni)
    {
        $page = Page::all();
        return view('admin.testimoni.edit', compact('testimoni', 'page'));
    }

    public function show(Testimoni $testimoni)
    {
        return view('admin.testimoni.show', compact('testimoni'));
    }
    */
    public function fetchTestimonials()
    {
        $testimonials = Testimoni::where('status_publikasi', 1)->orderBy('tanggal', 'desc')->get();
        return response()->json([
            'testimonials' => $testimonials
        ]);
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
