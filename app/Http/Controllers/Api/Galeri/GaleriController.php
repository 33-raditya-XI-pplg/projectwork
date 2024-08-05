<?php

namespace App\Http\Controllers\Api\Galeri;

use App\Http\Controllers\Controller;
use App\Models\Galeri;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GaleriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        try {

            $data = Galeri::orderBy('nama', 'asc')->get();
            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => $data
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $dataGaleri = new Galeri();

        $rules = [
            'page_id'=>'required',
            'nama' => 'required',
            'path_file' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'required',
        ];
        $validator = Validator::make($request->all(),$rules);
        if ($validator->fails()) {
            return response()->json([
                'status'=>false,
                'message' =>'Gagal memasukkan data',
                'data'=>$validator->errors()

            ]);
        }



        $dataGaleri->page_id = $request->page_id;
        $dataGaleri->nama = $request->nama;
        $dataGaleri->path_file = $request->path_file;
        $dataGaleri->kategori = $request->kategori;
        $dataGaleri->deskripsi = $request->deskripsi;

        $post = $dataGaleri->save();

        return response()->json([
            'status' => true,
            'message' => 'Sukses memasukkan data'
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = Galeri::find($id);
        if($data){
            return response()->json([
                'status' => true,
                'message' => 'Data ditemukan',
                'data' => $data
            ], 200);



        }else{
            return response()->json([
                'status' =>false,
                'message' => 'data tidak di temukan',
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {

        $dataGaleri = Galeri::find($id);


        if (empty($dataGaleri)) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }


        $rules = [
            'page_id' => 'required',
            'nama' => 'required',
            'path_file' => 'required',
            'kategori' => 'required',
            'deskripsi' => 'required',
        ];


        $validator = Validator::make($request->all(), $rules);
        if ($validator->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Gagal melakukan update data',
                'errors' => $validator->errors()
            ], 422);
        }


        $dataGaleri->page_id = $request->page_id;
        $dataGaleri->nama = $request->nama;
        $dataGaleri->path_file = $request->path_file;
        $dataGaleri->kategori = $request->kategori;
        $dataGaleri->deskripsi = $request->deskripsi;


        $dataGaleri->save();

        return response()->json([
            'status' => true,
            'message' => 'Sukses melakukan update data',
            'data' => $dataGaleri
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $dataGaleri = Galeri::find($id);


        if (empty($dataGaleri)) {
            return response()->json([
                'status' => false,
                'message' => 'Data tidak ditemukan'
            ], 404);
        }





$post = $dataGaleri->delete();


        return response()->json([
            'status' => true,
            'message' => 'Sukses melakukan delete data',
            'data' => $dataGaleri
        ], 200);


    }
}
