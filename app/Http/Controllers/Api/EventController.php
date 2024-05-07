<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Event;
use App\Models\Skema;

class EventController extends Controller
{
    public function show() {
        $data = Event::with(['eventTempat','eventEvent_Skema.event_skemaMenguji'])->get()->map(function ($evt) {
            return [
                'id' => $evt->id_event,
                'nama_event' => $evt->nama_event,
                'tanggal_mulai' => $evt->tgl_mulai,
                'tanggal_berakhir' => $evt->tgl_berakhir,
                'biaya' => $evt->biaya_regis,
                'banner' => $evt->path_banner,
                'deskripsi' => $evt->deskripsi,
                'status' => $evt->status,
                'visibilitas' => $evt->visibilitas,
                'tuk' => $evt->eventTempat,
                'skema' => $evt->eventEvent_Skema->map(function ($skema) {
                    return [
                        'id' => $skema->id_event_skema,
                        'nama_skema' => Skema::find($skema->skema_id)->nama_skema,
                        'penguji' => $skema->event_skemaMenguji->select('nama_lengkap', 'jabatan_penguji')
                    ];
                })
                // 'nama_penguji' => '',
                // 'jabatan_penguji' => ''
            ];
        });


        return response()->json(['event' => $data], 200, [], JSON_PRETTY_PRINT);
    }
}
