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
        // Validate the request data
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

        // Handle the photo upload
        $photoPath = null;
        if ($request->hasFile('photo')) {
            // Store the photo in the 'testimoni_photos' directory
            $photoPath = $request->file('photo')->store('testimoni_photos', 'public');
        }

        // Create a new Testimoni entry
        Testimoni::create([
            'page_id' => $request->page_id,
            'nama' => $request->nama,
            'email' => $request->email,
            'tanggal' => $request->tanggal,
            'rating' => $request->rating,
            'isi_testimoni' => $request->isi_testimoni,
            'photo' => $photoPath,
            'status' => $request->status, // Use the status field from request
            'created_by' => $request->created_by,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Testimoni created successfully.'
        ]);
    }




    public function update(Request $request, Testimoni $testimoni)
    {
        // Validasi hanya untuk status dan updated_by
        $request->validate([
            'status' => 'nullable|boolean',
            'updated_by' => 'required|integer',
        ]);

        // Handle the photo upload
        if ($request->hasFile('photo')) {
            // Delete the old photo if it exists
            if ($testimoni->photo) {
                Storage::disk('public')->delete($testimoni->photo);
            }

            // Store the new photo and update the path
            $photoPath = $request->file('photo')->store('testimoni_photos', 'public');
            $testimoni->photo = $photoPath;
        }

        // Update only the status field
        $testimoni->update([
            'status' => $request->status,
            'updated_by' => $request->updated_by,
            // No need to include other fields
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
