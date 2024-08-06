<?php

namespace App\Http\Controllers\Api;

use App\Models\Event;
use App\Models\Skema;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

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
    public function shoow($id) {
        $event = Event::with(['eventTempat', 'eventEvent_Skema.event_skemaMenguji'])
            ->find($id);

        if (!$event) {
            return response()->json(['error' => 'Event not found'], 404);
        }

        $data = [
            'id' => $event->id_event,
            'nama_event' => $event->nama_event,
            'tanggal_mulai' => $event->tgl_mulai,
            'tanggal_berakhir' => $event->tgl_berakhir,
            'biaya' => $event->biaya_regis,
            'banner' => $event->path_banner,
            'deskripsi' => $event->deskripsi,
            'status' => $event->status,
            'visibilitas' => $event->visibilitas,
            'tuk' => $event->eventTempat,
            'skema' => $event->eventEvent_Skema->map(function ($skema) {
                return [
                    'id' => $skema->id_event_skema,
                    'nama_skema' => Skema::find($skema->skema_id)->nama_skema,
                    'penguji' => $skema->event_skemaMenguji->select('nama_lengkap', 'jabatan_penguji')
                ];
            })
        ];

        return response()->json(['event' => $data], 200, [], JSON_PRETTY_PRINT);
    }



    public function store(Request $request)
    {
        // Define validation rules
        $rules = [
            'instansi_id' => 'required|integer|exists:tb_instansi,id_instansi',
            'tempat_id' => 'required|integer|exists:tb_tempat,id_tempat',
            'jenis_event_id' => 'required|integer|exists:tb_jenis_event,id_jenis_event',
            'nama_event' => 'required|string|max:255',
            'tgl_mulai' => 'required|date',
            'tgl_berakhir' => 'required|date|after_or_equal:tgl_mulai',
            'biaya_regis' => 'required|integer',
            'path_banner' => 'nullable|string|max:255',
            'deskripsi' => 'nullable|string',
            'status' => 'required|string|max:255',
            'visibilitas' => 'required|in:privat,publik',
            'created_by' => 'nullable|integer|exists:users,id',
        ];

        // Validate incoming request
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation failed',
                'errors' => $validator->errors()
            ], 422);
        }

        // Create a new Event record
        $event = Event::create($request->all());

        return response()->json([
            'status' => true,
            'message' => 'Event created successfully',
            'data' => $event
        ], 201);
    }


    public function update(Request $request, string $id)
{
    // Find the event by ID
    $event = Event::find($id);

    if (!$event) {
        return response()->json([
            'status' => false,
            'message' => 'Event not found'
        ], 404);
    }

    // Define validation rules
    $rules = [
        'instansi_id' => 'required|integer|exists:tb_instansi,id_instansi',
        'tempat_id' => 'required|integer|exists:tb_tempat,id_tempat',
        'jenis_event_id' => 'required|integer|exists:tb_jenis_event,id_jenis_event',
        'nama_event' => 'nullable|string|max:255',
        'tgl_mulai' => 'nullable|date',
        'tgl_berakhir' => 'nullable|date|after_or_equal:tgl_mulai',
        'biaya_regis' => 'nullable|integer',
        'path_banner' => 'nullable|string|max:255',
        'deskripsi' => 'nullable|string',
        'status' => 'nullable|string|max:255',
        'visibilitas' => 'nullable|in:privat,publik',
        'updated_by' => 'nullable|integer|exists:users,id', // Assuming users table exists
    ];

    // Validate incoming request
    $validator = Validator::make($request->all(), $rules);

    if ($validator->fails()) {
        return response()->json([
            'status' => false,
            'message' => 'Validation failed',
            'errors' => $validator->errors()
        ], 422);
    }

    // Update the event record
    $event->update($request->all());

    return response()->json([
        'status' => true,
        'message' => 'Event updated successfully',
        'data' => $event
    ], 200);
}

public function destroy(string $id)
{
    // Find the event by ID
    $event = Event::find($id);

    if (!$event) {
        return response()->json([
            'status' => false,
            'message' => 'Event not found'
        ], 404);
    }

    // Delete the event record
    $event->delete();

    return response()->json([
        'status' => true,
        'message' => 'Event deleted successfully'
    ], 200);
}






}
