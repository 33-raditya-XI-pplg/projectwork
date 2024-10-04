<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;
use App\Models\Instansi;
use App\Models\Tempat;
use App\Models\Jenis_Event as JenisEvt;
use App\Models\Event;
use App\Models\Page;
use App\Models\Event_Skema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Carbon;

class EventController extends Controller
{
    public function index()
    {

        $instansi = Instansi::get();
        $tempat = Tempat::get();
        $jenisEvt = JenisEvt::get();
        $page = Page::get();

        $evt = Event::get();
        $today = Carbon::today();
        foreach ($evt as $event) {
            if ($today->lt($event->tgl_mulai)) {
                $event->status = 'Publish';
            } elseif ($today->gte($event->tgl_berakhir)) {
                $event->status = 'Selesai';
            } else {
                $event->status = 'Berlangsung';
            }
            $event->save();
        }

        $evt_draft = Event::where('status', 'Draft')->get();
        $evt_pub = Event::where('status', 'Publish')->get();
        $evt_live = Event::where('status', 'Berlangsung')->get();
        $evt_end = Event::where('status', 'Selesai')->get();
        $Title = 'Event';
        confirmDelete('Hapus Event', 'Apakah kamu yakin untuk menghapus?');
        return view('admin.event.index', compact('instansi', 'tempat', 'page', 'jenisEvt', 'evt', 'evt_draft', 'evt_pub', 'evt_live', 'evt_end', 'Title'));
    }

    public function show($id)
    {
        $evt = Event::find($id);

        $skema = Event_Skema::where('event_id', $evt->id_event)->get();
        $Title = 'Rincian';
        $subtitle = 'Event';

        confirmDelete('Hapus Skema', 'Apakah kamu yakin untuk menghapus?');


        return view('admin.event.rincian-evt', compact('evt', 'skema', 'id', 'Title', 'subtitle'));
    }


    public function store(Request $request)
    {
        // if (!$request->has('status')) {
        //     $request->merge([
        //         'status' => 'Draft'
        //     ]);
        // }

        $status = $request->has('status') ? 'Publish' : 'Draft';

        if ($status === 'Publish') {

            $today = carbon::today();
            $tgl_mulai = carbon::parse($request->tgl_mulai);
            $tgl_berakhir = carbon::parse($request->tgl_berakhir);

            if ($today->lt($tgl_mulai)) {
                $status = 'Publish';
            } elseif ($today->between($tgl_mulai, $tgl_berakhir)) {
                $status = 'Berlangsung';
            } else {
                $status = 'Selesai';
            }
        }

        $request->merge([
            'status' => $status
        ]);

        $data = $request->all();
        if ($request->hasFile('path_banner')) {
            $banner = $request->file('path_banner');
            $filename = 'banner_' . $request->nama_event . '.' . $banner->getClientOriginalExtension();
            $storedPath = $banner->storeAs('public/banner-evt', $filename);
            Storage::url($storedPath);
            $data = $request->except(['path_banner']);
            $data['path_banner'] = "/storage/banner-evt/$filename";
        }

        Event::create($data);

        Alert::success('Berhasil Tersimpan!', 'Data berhasil diperbarui.');

        return redirect()->back();
    }

    public function update(Request $request, $id)
    {
        // if (!$request->has('status')) {
        //     $request->merge([
        //         'status' => 'Draft'
        //     ]);
        // }
        $evt = Event::find($id);

        if ($request->has('logo')) {
            $banner = $request->file('logo');
            $name = 'banner_' . $request->nama_event . '.' . $banner->getClientOriginalExtension();
            unlink(public_path(Event::find($id)->path_banner));

            $stored = $banner->storeAs('public/banner-evt', $name);

            $request->merge([
                'path_banner' => Storage::url($stored)
            ]);
        }

        $status = $request->has('status') ? 'Publish' : 'Draft';

        if ($status === 'Publish') {

            $today = carbon::today();
            $tgl_mulai = carbon::parse($request->tgl_mulai);
            $tgl_berakhir = carbon::parse($request->tgl_berakhir);

            if ($today->lt($tgl_mulai)) {
                $status = 'Publish';
            } elseif ($today->between($tgl_mulai, $tgl_berakhir)) {
                $status = 'Berlangsung';
            } else {
                $status = 'Selesai';
            }
        }

        $request->merge([
            'status' => $status
        ]);

        $data = $request->all();

        if ($request->hasFile('path_banner')) {
            if ($evt->path_banner) {
                $oldPhotoPath = str_replace('/storage', 'public', $evt->path_foto);
                if (Storage::exists($oldPhotoPath)) {
                    Storage::delete($oldPhotoPath);
                }
            }
            $banner = $request->file('path_banner');
            $filename = 'foto_' . $request->nama_event . '.' . $banner->getClientOriginalExtension();
            $storedPath = $banner->storeAs('public/banner-evt', $filename);
            Storage::url($storedPath);
            $data = $request->except(['path_banner']);
            $data['path_banner'] = "/storage/banner-evt/$filename";
        }

        $evt->update($data);
        Alert::success('Berhasil Tersimpan!', 'Data berhasil diubah.');

        return redirect()->back();
    }

    public function destroy($id)
    {
        $event = Event::find($id);
        if ($event) {
            $bannerPath = public_path($event->path_banner);

            if (file_exists($bannerPath)) {
                unlink($bannerPath);
            }
            Event::destroy($id);
            toast('Event terhapus!', 'success');
        } else {
            toast('Event tidak ditemukan!', 'error');
        }

        return redirect()->back();
    }
}
