<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Event_Skema;
use App\Models\Page;
use App\Models\User;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index() {

        $page = Page::get();
        $blog = Blog::get();
        confirmDelete('Hapus Event', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.blog.index', compact('page', 'blog',));
    }

    /**
     * Show the form for creating a new resource.
     */


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {

        if (!$request->has('status')) {
            $request->merge([
                'status' => 'Draft'
            ]);
        }

        $banner = $request->file('logo');
        $name = 'banner_' . $request->judul. '.' .$banner->getClientOriginalExtension();
        $stored = $banner->storeAs('public/banner-blog', $name);

        $request->merge([
            'path_banner' => Storage::url($stored)
        ]);

        Blog::create($request->all());

        Alert::success('Berhasil Tersimpan!', 'Data berhasil diperbarui.');

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     */


    /**
     * Show the form for editing the specified resource.
     */


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        // Validate the incoming data
        $validatedData = $request->validate([
            'page_id' => 'required|exists:tb_page,id_page', // Ensure page_id exists in the tb_page table
            'judul' => 'required|string|max:255',
            'slug' => 'required|string|max:255',
            'body' => 'required|string',
            'status' => 'nullable|string',
            'logo' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
        ]);

        // Find the blog entry by ID
        $blog = Blog::findOrFail($id);

        // Debugging: Log incoming request data
        Log::info('Update Request Data: ', $request->all());

        // Handle file upload if a new logo is provided
        if ($request->hasFile('logo')) {
            // Delete the old logo if it exists
            if ($blog->logo && Storage::disk('public')->exists($blog->logo)) {
                Storage::disk('public')->delete($blog->logo);
            }

            // Store the new logo and update path
            $logoPath = $request->file('logo')->store('logos', 'public');
            $validatedData['logo'] = $logoPath;
        }

        // Debugging: Log the validated data and blog before update
        Log::info('Validated Data: ', $validatedData);
        Log::info('Current Blog Data: ', $blog->toArray());

        // Update the blog entry with validated data
        $blog->update($validatedData);

        // Debugging: Log the updated blog data
        Log::info('Updated Blog Data: ', $blog->toArray());

        // Redirect back with a success message
        return redirect()->route('blog.index')->with('success', 'Blog post updated successfully.');
    }









    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id) {
        $blog = Blog::find($id);

        if ($blog) {
            $bannerPath = public_path($blog->path_banner);


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

            // Delete the blog entry from the database
            $blog->delete();
            toast('Blog terhapus!', 'success');
        } else {
            Log::error("Blog not found with ID: " . $id);
            toast('Blog not found!', 'error');
        }

        return redirect()->back();
    }


}
