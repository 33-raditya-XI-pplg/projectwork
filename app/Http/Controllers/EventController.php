<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Instansi;
use App\Models\Tempat;
use App\Models\Jenis_Event as JenisEvt;
use App\Models\Event;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class EventController extends Controller
{
    public function index() {

        $instansi = Instansi::get();
        $tempat = Tempat::get();
        $jenisEvt = JenisEvt::get();
        $evt = Event::get();
        $evt_draft = Event::where('status', 'Draft')->get();
        $evt_pub = Event::where('status', 'Publish')->get();
        $evt_live = Event::where('status', 'Berlangsung')->get();
        $evt_end = Event::where('status', 'Selesai')->get();
        confirmDelete('Hapus Event', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.event.index', compact('instansi', 'tempat', 'jenisEvt', 'evt', 'evt_draft', 'evt_pub', 'evt_live', 'evt_end'));
    }

    public function store(Request $request) {

        if (!$request->has('status')) {
            $request->merge([
                'status' => 'Draft'
            ]);
        }

        $banner = $request->file('logo');
        $name = 'banner_' . $request->nama_event. '.' .$banner->getClientOriginalExtension();
        $stored = $banner->storeAs('public/banner-evt', $name);

        $request->merge([
            'path_banner' => Storage::url($stored)
        ]);

        Event::create($request->all());

        Alert::success('Berhasil Tersimpan!', 'Data berhasil diperbarui.');

        return redirect()->back();
    }

    public function update(Request $request, $id) {
        $evt = Event::find($id);
        if (!$request->has('status')) {
            $request->merge([
                'status' => 'Draft'
            ]);
        }
        if ($request->has('logo')) {
            $banner = $request->file('logo');
            $name  = 'banner_'. $request->nama_event. '.' .$banner->getClientOriginalExtension();
            unlink(public_path(Event::find($id)->path_banner)); //hapus file

            $stored = $banner->storeAs('public/banner-evt', $name); //simpan

            $request->merge([
                'path_banner' => Storage::url($stored) //input path
            ]);
        }
        // dd($request->all());
        $evt->update($request->all());
        Alert::success('Berhasil Tersimpan!', 'Data berhasil diubah.');

        return redirect()->back();
    }

    public function destroy($id) {
        $banner = Event::find($id)->path_banner;
        unlink(public_path($banner));
        Event::destroy($id);
        toast('Event terhapus!','success');
        return redirect()->back();
    }
}
