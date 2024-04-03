<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;

use App\Models\User;
use App\Models\Instansi;

class ProfileController extends Controller
{
    public function index() {
        $data = auth()->user(); 

        return view('profile.index', compact('data'));
    }

    public function edit($id) {
        $instansi = Instansi::get();
        $user = User::findOrFail($id);

        return view('profile.edit', compact('user', 'instansi'));
    }

    public function update(Request $request, $id) {   
        if ($request->has('photo')) {
            if (Auth::user()->isLevel('Admin')) {
                $foto = $request->file('photo');
                $filename = 'foto_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
                $foto->storeAs('public/foto_admin', $filename);
            }
            elseif (Auth::user()->isLevel('Penguji')) {
                $foto = $request->file('photo');
                $filename = 'foto_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
                $foto->storeAs('public/foto_penguji', $filename);
            }
            elseif (Auth::user()->isLevel('Pengguna')) {
                $foto = $request->file('photo');
                $filename = 'foto_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
                $foto->storeAs('public/foto_pengguna', $filename);
            }
                  
        }

        $user = User::find($id);

        if (!Hash::check($request->password_lama, $user->password)) {
            Alert::error('Gagal Tersimpan!', 'Password lama salah');
            return redirect()->back();
        }
        else {
            if ($request->password_baru != $request->konfirmasi_password_baru) {
                Alert::error('Gagal Tersimpan!', 'Password baru tidak sama');
                return redirect()->back();
            }
            else {
                $user->password = Hash::make($request->password_baru);
                $user->save();
            }
        }

        $user->update($request->all());

        Alert::success('Berhasil Tersimpan!', 'Data berhasil diperbarui.');
        return redirect()->route('profile.index');
    }

    public function destroy($id) {
        $user = User::findOrFail($id);

        // BUG : Somehow path_foto not exists
        // quick fix : let-say path_foto can't be manually deleted on public_path
        // if (!empty($user->path_foto) && Storage::exists($user->path_foto)) {
        //     Storage::delete($user->path_foto);
        // }
        if (!empty($user->path_foto)) {
            unlink(public_path($user->path_foto));
            $user->delete();
        }
        $user->delete();
        
        toast('Pengguna terhapus!','success');
        return redirect()->back();
    }

    // public function edit(Request $request): View
    // {
    //     return view('profile.edit', [
    //         'user' => $request->user(),
    //     ]);
    // }

    // public function update(ProfileUpdateRequest $request): RedirectResponse
    // {
    //     $request->user()->fill($request->validated());

    //     if ($request->user()->isDirty('email')) {
    //         $request->user()->email_verified_at = null;
    //     }

    //     $request->user()->save();

    //     return Redirect::route('profile.edit')->with('status', 'profile-updated');
    // }

    // public function destroy(Request $request): RedirectResponse
    // {
    //     $request->validateWithBag('userDeletion', [
    //         'password' => ['required', 'current_password'],
    //     ]);

    //     $user = $request->user();

    //     Auth::logout();

    //     $user->delete();

    //     $request->session()->invalidate();
    //     $request->session()->regenerateToken();

    //     return Redirect::to('/');
    // }
}
