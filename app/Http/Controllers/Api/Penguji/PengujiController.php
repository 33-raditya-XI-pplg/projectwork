<?php

namespace App\Http\Controllers\Api\Penguji;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class PengujiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $pageId = $request->input('page_id');

        $penguji = User::where('level', 'penguji')->with('pageuser')
            ->when($pageId, function ($query, $pageId) {
                return $query->whereHas('pageuser', function ($query) use ($pageId) {
                    $query->where('page_id', $pageId);
                });
            })
            ->get();

        // $penguji = User::where('level', 'penguji')->with('pageuser')->get();

        if ($penguji->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan untuk page_id yang dimasukan.'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data jenis event ditemukan',
            'data' => $penguji,
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $penguji = User::where('level', 'penguji')->with('pageuser')->find($id);

        if (!$penguji) {
            return response()->json([
                'status' => false,
                'message' => 'Data penguji tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Data penguji ditemukan',
            'data' => $penguji,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
