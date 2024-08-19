<?php

namespace App\Http\Controllers;

use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

use App\Models\Page;

class VideoController extends Controller
{
    /**
     * Menampilkan form untuk mengunggah video baru.
     *
     * @return \Illuminate\View\View
     *  public function index()

     */
    public function index()
    {

        $pages = Page::all();


        $videos = Galeri::where('kategori', 'video')->get();

        return view('admin.galeri.indexvideo', compact('videos', 'pages'));
    }



    /**
     * Menyimpan video baru ke dalam database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'page_id' => 'required|integer',
            'kategori' => 'required|in:partner,klien,gambar,video',
            'path_file' => 'nullable|url',
            'deskripsi' => 'required|string|max:255',
        ]);


        $videoId = $this->extractYoutubeId($request->input('path_file'));

        if (!$videoId) {
            return redirect()->back()->withErrors(['path_file' => 'Link YouTube tidak valid.']);
        }


        $galeri = new Galeri();
        $galeri->nama = $request->input('nama');
        $galeri->page_id = $request->input('page_id');
        $galeri->kategori = $request->input('kategori');
        $galeri->path_file = $request->input('path_file');
        $galeri->deskripsi = $request->input('deskripsi');
        $galeri->created_by = Auth::id();

        $galeri->save();


        return redirect()->route('video.index')->with('success', 'Video berhasil diunggah.');
    }

    /**
     * Menampilkan daftar video.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $pages = Page::all();
        $videos = Galeri::where('kategori', 'video')->get();
        return view('admin.galeri.create_video', compact('videos', 'pages'));
    }



    /**
     * Menampilkan detail dari video tertentu.
     *
     * @param  int  $id
     * @return \Illuminate\View\View
     */
    public function show($id)
    {
        $video = Galeri::findOrFail($id);
        return view('videos.show', compact('video'));
    }

    /**
     * Ekstrak YouTube video ID dari URL.
     *
     * @param  string $url
     * @return string|null
     */
    private function extractYoutubeId($url)
    {

        preg_match("/(?:https?:\/\/)?(?:www\.)?youtube\.com\/(?:watch\?v=|embed\/|v\/|.+?v=|.+?\/v\/|)([a-zA-Z0-9_-]{11})/i", $url, $matches);
        return $matches[1] ?? null;
    }
    public function edit($id)
    {
        $video = Galeri::findOrFail($id);
        return response()->json($video);
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'kategori' => 'required|string|in:partner,klien,gambar,video',
            'path_file' => 'required|url',
            'deskripsi' => 'required|string',
        ]);

        $video = Galeri::findOrFail($id);
        $video->update([
            'nama' => $request->input('nama'),
            'kategori' => $request->input('kategori'),
            'path_file' => $request->input('path_file'),
            'deskripsi' => $request->input('deskripsi'),
        ]);

        return redirect()->route('video.index')->with('success', 'Video updated successfully!');
    }

public function destroy($id)
{

    $video = Galeri::findOrFail($id);


    $video->delete();


    return redirect()->route('video.index')->with('success', 'Video berhasil dihapus.');
}


}
