<?php
namespace App\Http\Controllers;
use App\Models\Blog;
use Illuminate\Http\Request;
use App\Models\Page;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class PageController extends Controller
{

    public function index()
    {
        $pages = Page::all();
        return view('admin.page.index', compact('pages'));
    }


    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'nama_page' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'pindah_halaman' => 'required|string|max:255'
        ]);

        try {
            // Sanitize the 'deskripsi' field by stripping HTML tags
            $sanitizedDeskripsi = strip_tags($request->deskripsi);

            // Create a new Page entry
            Page::create([
                'nama_page' => $request->nama_page,
                'deskripsi' => $sanitizedDeskripsi,
                'pindah_halaman' => $request->pindah_halaman,
                'created_by' => Auth::id(),
                'updated_by' => Auth::id(),
            ]);

            return Redirect::route('page.index')->with('success', 'Page created successfully.');
        } catch (\Exception $e) {
            return Redirect::route('page.index')->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }




    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_page' => 'required|string|max:255',
            'deskripsi' => 'required|string',
            'pindah_halaman' => 'required|string|max:255'
        ]);

        $page = Page::findOrFail($id);
        $page->update($request->all());

        return redirect()->route('page.index')->with('success', 'Page updated successfully.');
    }





public function edit($id)
{
    $page = Page::findOrFail($id);
    return view('admin.page.edit', compact('page'));
}




public function destroy($id)
{
    $page = Page::findOrFail($id);

    // Initialize an empty array to hold messages
    $messages = [];

    // Check each relationship and add a message if it's in use
    if ($page->partners()->exists()) {
        $messages[] = 'Page ini masih digunakan di halaman Partner.';
    }
    if ($page->pageGaleri()->exists()) {
        $messages[] = 'Page ini masih digunakan di halaman Galeri.';
    }
    if ($page->pageProfil()->exists()) {
        $messages[] = 'Page ini masih digunakan di halaman Profil.';
    }
    if ($page->pageFaq()->exists()) {
        $messages[] = 'Page ini masih digunakan di halaman FAQ.';
    }
    if ($page->pageBlog()->exists()) {
        $messages[] = 'Page ini masih digunakan di halaman Blog.';
    }
    if ($page->profilPerusahaan()->exists()) {
        $messages[] = 'Page ini masih digunakan di halaman Profil Perusahaan.';
    }

    if ($page->sliders()->exists()) {
        $messages[] = 'Page ini masih digunakan di halaman Slider.';
    }

    if ($page->testimoni()->exists()) {
        $messages[] = 'Page ini masih digunakan di halaman Testimoni.';
    }

    if ($page->faqs()->exists()) {
        $messages[] = 'Page ini masih digunakan di halaman FAQ.';
    }

    // If there are any messages, return the first one
    if (!empty($messages)) {
        $errorMessage = implode(' ', $messages);
        return redirect()->back()->with('error', $errorMessage);
    }

    // Handle related records in tb_galeri
    if ($page->pageGaleri()->exists()) {
        // Optionally, you can choose to delete or detach related records
        $page->pageGaleri()->delete(); // Or use detach if you just want to disassociate
    }

    // Handle related records in tb_profil_perusahaan
    if ($page->profilPerusahaan()->exists()) {
        // Optionally, you can choose to delete or detach related records
        $page->profilPerusahaan()->delete(); // Or use detach if you just want to disassociate
    }

    if ($page->sliders()->exists()) {
        // Optionally, you can choose to delete or detach related records
        $page->sliders()->delete(); // Or use detach if you just want to disassociate
    }

    if ($page->testimoni()->exists()) {
        // Optionally, you can choose to delete or detach related records
        $page->testimoni()->delete(); // Or use detach if you just want to disassociate
    }

    if ($page->faqs()->exists()) {
        $page->faqs()->delete(); // Or use detach if you just want to disassociate
    }

    // If not associated, delete the page
    $page->delete();

    return redirect()->back()->with('success', 'Page berhasil dihapus.');
}




}
