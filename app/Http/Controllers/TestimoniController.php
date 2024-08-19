<?php

namespace App\Http\Controllers;

use App\Models\Page;
use App\Models\Testimoni;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class TestimoniController extends Controller
{
    public function index()
    {
        $testimoni = Testimoni::all();
        $page = Page::all();
        $testimonials = Testimoni::where('status', 1)->orderBy('tanggal', 'desc')->get();
        return view('admin.testimoni.index', compact('testimoni', 'page', 'testimonials'));
    }



    public function store(Request $request)
{

    $request->validate([
        'page_id' => 'required|integer',
        'nama' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'tanggal' => 'required|date',
        'rating' => 'required|integer|min:1|max:5',
        'isi_testimoni' => 'required|string',
        'photo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        'status' => 'nullable|boolean',
        'created_by' => 'required|integer',
    ]);


    $photoPath = null;
    if ($request->hasFile('photo')) {

        $photoPath = $request->file('photo')->store('testimoni_photos', 'public');
    }


    $cleanIsiTestimoni = preg_replace('/<p[^>]*>(.*?)<\/p>/i', '$1', $request->isi_testimoni);

    try {
        // Buat entri Testimoni baru
        Testimoni::create([
            'page_id' => $request->page_id,
            'nama' => $request->nama,
            'email' => $request->email,
            'tanggal' => $request->tanggal,
            'rating' => $request->rating,
            'isi_testimoni' => $cleanIsiTestimoni,
            'photo' => $photoPath,
            'status' => $request->has('status') ? true : false,
            'created_by' => $request->created_by,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Testimoni berhasil dibuat.'
        ]);
    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Gagal membuat testimoni.',
            'error' => $e->getMessage()
        ], 500);
    }
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

}
