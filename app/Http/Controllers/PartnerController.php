<?php

namespace App\Http\Controllers;

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
        // Validate the incoming request data
        $request->validate([
            'page_id' => 'required|exists:tb_page,id_page',
            'nama_partner' => 'required|string|max:255',
            'email_partner' => 'required|email|max:255|unique:tb_partner,email_partner',
            'telepon_partner' => 'nullable|string|max:20',
            'alamat_partner' => 'nullable|string|max:255',
            'jenis_partner' => 'nullable|string|max:50',
            'tanggal_bergabung' => 'nullable|date',
            'website_partner' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'status_partner' => 'nullable|boolean',
        ]);

        try {
            // Create a new Partner instance and populate it with request data
            $partner = new Partner();
            $partner->page_id = $request->page_id;
            $partner->nama_partner = $request->nama_partner;
            $partner->email_partner = $request->email_partner;
            $partner->telepon_partner = $request->telepon_partner;
            $partner->alamat_partner = $request->alamat_partner;
            $partner->jenis_partner = $request->jenis_partner;
            $partner->tanggal_bergabung = $request->tanggal_bergabung;
            $partner->website_partner = $request->website_partner; // Store the website URL
            $partner->status_partner = $request->status_partner ? true : false;

            // Check if a logo file was uploaded
            if ($request->hasFile('logo')) {
                $file = $request->file('logo');
                $filename = time() . '.' . $file->getClientOriginalExtension();
                $file->storeAs('public', $filename);
                $partner->logo = $filename;
            }

            // Save the Partner instance to the database
            $partner->save();

            // Redirect back with a success message
            return redirect()->back()->with('success', 'Partner berhasil ditambahkan!');
        } catch (\Exception $e) {
            // Redirect back with an error message if something goes wrong
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

        return view('partners.show', compact('partner'));
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
    // Validate the incoming request data
    $validatedData = $request->validate([
        'page_id' => 'required|exists:tb_page,id_page',
        'nama_partner' => 'required|string|max:100',
        'email_partner' => 'required|email|max:100|unique:tb_partner,email_partner,' . $id . ',id_partner',
        'telepon_partner' => 'nullable|string|max:20',
        'alamat_partner' => 'nullable|string|max:255',
        'jenis_partner' => 'nullable|string|max:50',
        'tanggal_bergabung' => 'nullable|date',
        'website_partner' => 'nullable|url|max:255',  // Validate the website URL
        'status_partner' => 'nullable',
        'logo' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    // Determine the status_partner value based on the request input
    $statusPartner = $request->has('status_partner') && $request->input('status_partner') === 'on';

    // Find the existing Partner instance by ID
    $partner = Partner::findOrFail($id);

    // Check if a new logo file was uploaded
    if ($request->hasFile('logo')) {
        // Delete the existing logo file from storage if it exists
        if ($partner->logo) {
            Storage::disk('public')->delete($partner->logo);
        }

        // Store the new logo file and update the validatedData array
        $logoPath = $request->file('logo')->store('logos', 'public');
        $validatedData['logo'] = $logoPath;
    } else {
        // Retain the existing logo if no new file was uploaded
        $validatedData['logo'] = $partner->logo;
    }

    // Update the status_partner field in the validated data
    $validatedData['status_partner'] = $statusPartner;

    // Update the Partner instance with the validated data
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
        if ($partner->logo) {
            Storage::disk('public')->delete($partner->logo);
        }

        $partner->delete();

        return redirect()->route('partner.index')->with('success', 'Partner berhasil dihapus.');
    }
}
