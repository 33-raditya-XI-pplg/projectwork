<?php

namespace App\Http\Controllers;

use id;
use App\Models\Page;
use App\Models\Partner;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Log;
use Illuminate\Http\RedirectResponse;
use Illuminate\Contracts\View\Factory;
use Illuminate\Support\Facades\Storage;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Database\QueryException;


class PartnerController extends Controller
{
    /**
     * Display a listing of the partners.
     *
     * @return View|Factory|Response
     */
    public function index()
    {
        $pages = Page::all();

        $partners = Partner::all();

        return view('admin.partner.index', compact('partners', 'pages'));
    }

    /**
     *
     *
     * @return View|Factory|Response
     */


    /**
     *
     *
     * @param  Request  $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {

        $request->validate([
            'page_id' => 'required|exists:tb_page,id_page',
            'nama_partner' => 'required|string|max:255',
            'email_partner' => 'required|email|max:255|unique:tb_partner,email_partner',
            'telepon_partner' => 'required|digits:12',
            'alamat_partner' => 'required|string|max:255',
            'jenis_partner' => 'required|string|max:50',
            'tanggal_bergabung' => 'required|date',
            'website_partner' => 'required|url|max:255',
            'logo' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'status_partner' => 'nullable|boolean',
        ]);

        try {

            $partner = new Partner();
            $partner->page_id = $request->page_id;
            $partner->nama_partner = $request->nama_partner;
            $partner->email_partner = $request->email_partner;
            $partner->telepon_partner = $request->telepon_partner;
            $partner->alamat_partner = $request->alamat_partner;
            $partner->jenis_partner = $request->jenis_partner;
            $partner->tanggal_bergabung = $request->tanggal_bergabung;
            $partner->website_partner = $request->website_partner;
            $partner->status_partner = $request->status_partner ? true : false;


            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public', $filename);
                $partner->logo = $filename;
            }


            $partner->save();


            return redirect()->back()->with('success', 'Partner berhasil ditambahkan!');
        } catch (\Exception $e) {

            return redirect()->back()->withErrors(['msg' => 'Terjadi kesalahan saat menyimpan data: ' . $e->getMessage()]);
        }
    }



    /**
     *
     *
     * @param  int  $id
     * @return View|Factory|Response
     */
    public function show($id)
    {
        $partner = Partner::findOrFail($id);
        return view('admin.partner.show', compact('partner'));
    }

    /**
     * Show the form for editing the specified partner.
     *
     * @param  int  $id
     * @return View|Factory|Response



     * Update the specified partner in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return RedirectResponse
     */
    public function update(Request $request, $id)
    {

        $validatedData = $request->validate([
            'page_id' => 'required|exists:tb_page,id_page',
            'nama_partner' => 'required|string|max:100',
            'email_partner' => 'required|email|max:100|unique:tb_partner,email_partner,' . $id . ',id_partner',
            'telepon_partner' => 'required|digits:12',
            'alamat_partner' => 'nullable|string|max:255',
            'jenis_partner' => 'nullable|string|max:50',
            'tanggal_bergabung' => 'nullable|date',
            'website_partner' => 'nullable|url|max:255',
            'status_partner' => 'nullable',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);


        $statusPartner = $request->has('status_partner') && $request->input('status_partner') === 'on';

        $partner = Partner::findOrFail($id);

        if ($request->hasFile('logo')) {

            if ($partner->logo) {
                Storage::disk('public')->delete($partner->logo);
            }

            $logoPath = $request->file('logo')->store('logos', 'public');
            $validatedData['logo'] = $logoPath;
        } else {

            $validatedData['logo'] = $partner->logo;
        }
        $validatedData['status_partner'] = $statusPartner;
        $partner->update($validatedData);


        return redirect()->route('partner.index')->with('success', 'Partner berhasil diperbarui.');
    }



    /**
     * Remove the specified partner from storage.
     *
     * @param  int  $id
     * @return RedirectResponse
     */
    public function destroy(Partner $partner)
    {
        try {

            if ($partner->logo) {
                Storage::disk('public')->delete($partner->logo);
            }


            $partner->delete();


            Alert::success('Berhasil Menghapus!', 'Partner berhasil dihapus.');
        } catch (QueryException $e) {

            Alert::error('Terjadi Kesalahan!', 'Partner gagal dihapus.');
        }

        return redirect()->route('partner.index');
    }
}

