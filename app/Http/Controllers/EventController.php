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

        $page = Page::where('status', 1)->get();
        $allPages = Page::where('status', 1)->get();

        $evt = Event::get();
        $today = Carbon::today();
        $todayString = $today->format('Y-m-d');

        foreach ($evt as $event) {
            if ($event->status !== 'Draft') {
                $tglMulai = $event->tgl_mulai;
                $tglBerakhir = $event->tgl_berakhir;

                // Konversi ke string format Y-m-d jika perlu
                if ($tglMulai instanceof Carbon) {
                    $tglMulai = $tglMulai->format('Y-m-d');
                }
                if ($tglBerakhir instanceof Carbon) {
                    $tglBerakhir = $tglBerakhir->format('Y-m-d');
                }

                // Perbandingan manual menggunakan string comparison
                if ($todayString < $tglMulai) {
                    // Hari ini sebelum tanggal mulai
                    $event->status = 'Publish';
                } elseif ($todayString >= $tglMulai && $todayString <= $tglBerakhir) {
                    // Hari ini di antara tanggal mulai dan berakhir (termasuk hari mulai dan berakhir)
                    $event->status = 'Berlangsung';
                } elseif ($todayString > $tglBerakhir) {
                    // Hari ini setelah tanggal berakhir
                    $event->status = 'Selesai';
                }

                $event->save();
            }
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

        $status = $request->has('status') && $request->input('status') === 'Publish' ? 'Publish' : 'Draft';

        if ($status === 'Publish') {
            $today = carbon::today();
            $tgl_mulai = carbon::parse($request->tgl_mulai);
            $tgl_berakhir = carbon::parse($request->tgl_berakhir);
            if ($today->lte($tgl_mulai)) {
                $status = 'Publish';
            } elseif ($today->gt($tgl_mulai) && $today->lte($tgl_berakhir)) {
                $status = 'Berlangsung';
            } elseif ($today->gt($tgl_berakhir)) {
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

        $data['biaya_regis'] = (int) str_replace(',', '', $request->biaya_regis);
        $data['biaya_regis'] = '' . $data['biaya_regis'] . '';
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

        // Ambil status dari input tersembunyi
        $status = $request->input('status', 'Draft');

        // Cek jika status_checkbox ada
        if ($request->has('status_checkbox')) {
            $status = 'Publish';
        } else {
            if (in_array($evt->status, ['Selesai', 'Berlangsung'])) {
                Alert::error('Error!', 'Status tidak daoat diubah menjadi draft.');
                return redirect()->back();
            }
            $status = 'Draft';
        }

        if ($status === 'Publish') {
            $today = carbon::today();
            $tgl_mulai = carbon::parse($request->tgl_mulai);
            $tgl_berakhir = carbon::parse($request->tgl_berakhir);
            if ($today->lte($tgl_mulai)) {
                $status = 'Publish';
            } elseif ($today->gt($tgl_mulai) && $today->lte($tgl_berakhir)) {
                $status = 'Berlangsung';
            } elseif ($today->gt($tgl_berakhir)) {
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

        $finalData = $request->except(['biaya_regis']);
        $finalData['biaya_regis'] = (int) str_replace(',', '', $request->biaya_regis);

        $evt->update($finalData);
        Alert::success('Berhasil Tersimpan!', 'Data berhasil diubah.');
        // dd($status);
        // dd($request->all());
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
