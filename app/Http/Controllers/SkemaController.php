<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;

use App\Models\Skema;
use App\Models\Sub_Skema;

class SkemaController extends Controller
{
    public function index() {
        $data = Skema::get();

        confirmDelete('Hapus Skema', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.skema.index', compact('data'));
    }

    public function create() {
        return view('admin.skema.create');
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        
        try {
            $icon = $request->file('icon');
            $filename = 'icon_' . $request->nama_skema . '.' . $icon->getClientOriginalExtension();
            $stored = $icon->storeAs('public/icon_skema', $filename);

            $skema = Skema::create([
                'nama_skema' => $request->nama_skema,
                'has_sub_skema' => $request->has('sub_skema') ? true : false,
                'status' => $request->has('status') ? $request->status : 'Nonaktif',
                'path_icon' => Storage::url($stored),
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

        return view('admin.skema.edit', compact('skema', 'sub_skema'));
    }

    public function update(Request $request, $id)
    {
        DB::beginTransaction();
        try {
            if ($request->has('icon')) {
                $icon = $request->file('icon');
                $filename = 'icon_' . $request->nama_skema . '.' . $icon->getClientOriginalExtension();

                $icon->storeAs('public/icon_skema', $filename);
            }

            // Update Skema
            $skema = Skema::findOrFail($id);
            $skemaData = [
                'nama_skema' => $request->nama_skema,
                'has_sub_skema' => $request->has('sub_skema') ? true : false,
                'status' => $request->has('status') ? $request->status : 'Nonaktif',
                'updated_by' => Auth::user()->id_user,
            ];
            $skema->update($skemaData);
            
            $existingSubSkemaIds = $request->input('sub_skema_ids', []);

            Sub_Skema::where('skema_id', $skema->id_skema)
                ->whereNotIn('id_sub_skema', $existingSubSkemaIds)
                ->delete();            
            
            if (!empty($request->sub_skema)) {
                foreach ($request->sub_skema as $subSkemaId => $subSkemaValue) {    
                    // if (!empty($subSkemaValue) && Sub_Skema::where('id_sub_skema', !$subSkemaId)
                    //     ->whereIn('skema_id', $skema->id_skema)) {
                    if (!empty($subSkemaValue) && !Sub_Skema::where('id_sub_skema', $subSkemaId)
                        ->whereIn('skema_id', [$skema->id_skema])->exists()) {
                    
                        Sub_Skema::create([
                            'skema_id' => $skema->id_skema,
                            'judul_sub' => $subSkemaValue,
                            'created_by' => Auth::user()->id_user,
                        ]);
                    } 
                    elseif (!empty($request->sub_skema) && Sub_Skema::where('id_sub_skema', $subSkemaId)
                        ->whereIn('skema_id', [$skema->id_skema])) {

                        $subSkema = Sub_Skema::findOrFail($subSkemaId);
                        $subSkema->update([
                            'skema_id' => $skema->id_skema,
                            'judul_sub' => $subSkemaValue,
                            'updated_by' => Auth::user()->id_user,
                        ]);
                    }

                } // End Foreach
            }
            elseif (empty($request->sub_skema)) {
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


    public function destroy(Skema $skema)
    {
        // BUG : Somehow path_foto not exists
        // quick fix : let-say path_foto can't be manually deleted on public_path
        // if (!empty($user->path_foto) && Storage::exists($user->path_foto)) {
        //     Storage::delete($user->path_foto);
        // }
        if (!empty($skema->path_icon)) {
            unlink(public_path($skema->path_icon));
            $skema->delete();
        }
        $skema->delete();

        toast('Skema berhasil dihapus.', 'success');

        return redirect()->route('skema.index');
    }
}
