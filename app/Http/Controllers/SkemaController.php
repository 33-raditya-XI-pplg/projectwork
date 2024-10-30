<?php

namespace App\Http\Controllers;

use App\Models\Event_Skema;
use App\Models\Nilai_Peserta;
use App\Models\Page;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

use App\Models\Skema;
use App\Models\Sub_Skema;

class SkemaController extends Controller
{
    public function index()
    {
        $data = Skema::get();
        $page = Page::all();
        $Title = 'Master Data';
        $subtitle = 'Skema';

        confirmDelete('Hapus Skema', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.skema.index', compact('data', 'page', 'Title', 'subtitle'));
    }

    public function create()
    {

        $Title = 'Master Data';
        $subtitle = 'Skema-create';
        $page = Page::all();
        return view('admin.skema.create', compact('Title', 'page', 'subtitle'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            if ($request->has('path_icon')) {
                $icon = $request->file('path_icon');
                $filename = 'icon_' . $request->nama_skema . '.' . $icon->getClientOriginalExtension();
                $stored = $icon->storeAs('storage/icon_skema', $filename);

                $request->merge([
                    'path_icon' => Storage::url($stored)
                ]);
            }

            // dd($request->files);
            $skema = Skema::create([
                'page_id' => $request->page_id,
                'nama_skema' => $request->nama_skema,
                'has_sub_skema' => $request->has('sub_skema') ? true : false,
                'status' => $request->has('status') ? $request->status : 'Nonaktif',
                'path_icon' => $stored,
                'created_by' => Auth::user()->id_user,
            ]);


            if (!empty($request->sub_skema)) {
                foreach ($request->sub_skema as $nama_sub_skema) {
                    Sub_Skema::create([
                        'skema_id' => $skema->id_skema,
                        'judul_sub' => $nama_sub_skema,
                        'created_by' => Auth::user()->id_user,
                    ]);
                }
            }

            DB::commit();

            Alert::success('Berhasil Tersimpan!', 'Data berhasil ditambahkan.');
            return redirect()->route('skema.index');
        } catch (\Exception $e) {
            DB::rollback();

            Alert::error('Gagal Tersimpan!', 'Data gagal ditambahkan.' . $e->getMessage());
            return redirect()->route('skema.index');
        }
    }

    public function edit(Skema $skema)
    {
        $sub_skema = Sub_Skema::where('skema_id', $skema->id_skema)->get();
        $page = Page::all();
        $Title = 'Master Data';
        $subtitle = 'Skema-edit';

        return view('admin.skema.edit', compact('skema', 'page', 'sub_skema', 'Title', 'subtitle'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {

            $skema = Skema::findOrFail($id);

            if ($request->hasFile('path_icon')) {
                $icon = $request->file('path_icon');
                $filename = 'icon_' . $request->nama_skema . '.' . $icon->getClientOriginalExtension();
                $stored = $icon->storeAs('public/icon_skema', $filename);

                $path_icon = Storage::url($stored); // Mendapatkan URL untuk penyimpanan
            } else {
                $path_icon = $skema->path_icon; // Gunakan path ikon yang sudah ada
            }

            // Update Skema
            $skema = Skema::findOrFail($id);
            $skemaData = [
                'page_id' => $request->page_id,
                'nama_skema' => $request->nama_skema,
                'has_sub_skema' => $request->has('sub_skema') ? true : false,
                'status' => $request->has('status') ? $request->status : 'Nonaktif',
                'path_icon' => $path_icon,
                'updated_by' => Auth::user()->id_user,
            ];
            $skema->update($skemaData);


            $existingSubSkemaIds = $request->input('sub_skema_ids', []);

            $checkChildID1 = Event_Skema::where('skema_id', $skema->id_skema)->count();

            $checkChildID2 = DB::table('tb_nilai_peserta')
                ->join('tb_event_skema', 'tb_nilai_peserta.event_skema_id', '=', 'tb_event_skema.id_event_skema')
                ->join('tb_event', 'tb_event_skema.event_id', '=', 'tb_event.id_event')
                ->where('skema_id', $skema->id_skema)
                ->whereNotNull('sub_skema_id')
                ->exists();

            if ($checkChildID1 > 0 || $checkChildID2 > 0) {
                Alert::error('Gagal mengubah!', 'Tidak dapat mengubah karena data masih digunakan.');
                return redirect()->back();
            }
            if ($checkChildID2 == 1) {
                Alert::error('Gagal mengubah!', 'Tidak dapat mengubah karena data masih digunakan.');
                return redirect()->back();
            }

            Sub_Skema::where('skema_id', $skema->id_skema)
                ->whereNotIn('id_sub_skema', $existingSubSkemaIds)
                ->delete();

            if (!empty($request->sub_skema)) {
                foreach ($request->sub_skema as $subSkemaId => $subSkemaValue) {
                    if (
                        !empty($subSkemaValue) && !Sub_Skema::where('id_sub_skema', $subSkemaId)
                            ->whereIn('skema_id', [$skema->id_skema])->exists()
                    ) {

                        Sub_Skema::create([
                            'skema_id' => $skema->id_skema,
                            'judul_sub' => $subSkemaValue,
                            'created_by' => Auth::user()->id_user,
                        ]);
                    } elseif (
                        !empty($request->sub_skema) && Sub_Skema::where('id_sub_skema', $subSkemaId)
                            ->whereIn('skema_id', [$skema->id_skema])
                    ) {

                        $subSkema = Sub_Skema::findOrFail($subSkemaId);
                        $subSkema->update([
                            'skema_id' => $skema->id_skema,
                            'judul_sub' => $subSkemaValue,
                            'updated_by' => Auth::user()->id_user,
                        ]);
                    }

                } // End Foreach
            } elseif (empty($request->sub_skema)) {
                Sub_Skema::where('skema_id', $skema->id_skema)->delete();
            }


            DB::commit();
            Alert::success('Berhasil Diperbarui!', 'Data berhasil diperbarui.');
            return redirect()->route('skema.index');
        } catch (\Exception $e) {
            DB::rollback();
            Alert::error('Gagal Diperbarui!', 'Data gagal diperbarui. ' . $e->getMessage());
            return redirect()->route('skema.index');
        }
    }

    public function show($id)
    {
        $skema = Skema::findOrFail($id);
        $Title = 'Management';
        $subtitle = 'Detail Tempat';
        $sub_skema = Sub_Skema::where('skema_id', $skema->id_skema)->get();
        return view('admin.skema.show', compact('skema', 'sub_skema', 'Title', 'subtitle'));
    }
    public function destroy(Skema $skema)
    {
        $checkChildID = Event_Skema::where('skema_id', $skema->id_skema)->count();

        if ($checkChildID > 0) {
            Alert::error('Gagal Menghapus!', 'Tidak dapat menghapus karena data masih digunakan.');
            return redirect()->back();
        }

        if (!empty($skema->path_foto)) {
            if (file_exists(public_path($skema->path_foto))) {
                unlink(public_path($skema->path_foto));
                $skema->delete();
            } else {
                $skema->delete();
            }
        } else {
            $skema->delete();
        }

        toast('Skema berhasil dihapus.', 'success');

        return redirect()->route('skema.index');
    }

    // ==== API ====
    public function indexApi()
    {
        $data = Skema::get();

        return response()->json([
            'success' => true,
            'message' => 'Data skema berhasil diambil.',
            'data' => $data
        ]);
    }

}
