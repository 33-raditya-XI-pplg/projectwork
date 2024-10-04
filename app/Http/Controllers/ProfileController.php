<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Instansi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use RealRashid\SweetAlert\Facades\Alert;
use App\Http\Requests\ProfileUpdateRequest;

class ProfileController extends Controller
{
    public function index()
    {
        // Ambil data yang diperlukan, misalnya data pengguna
        $data = auth()->user(); // Ambil data pengguna yang login, misalnya
        $Title = 'Profile';
        // Periksa level pengguna
        if ($data->level == 'Pengguna' || $data->level == 'Admin' || $data->level == 'Penguji') {

            return view('profile.index', compact('data', 'Title')); // Kirim data ke view
        } else {
            abort(403, 'Unauthorized action.');
        }
    }

    public function edit()
    {
        $id = Auth::user()->id_user;
        $instansi = Instansi::get();
        $user = User::findOrFail($id);
        $regencies = DB::table('regencies')->pluck('name', 'id');
        $Title = 'Edit Profile';
        return view('profile.edit', compact('user', 'regencies', 'instansi', 'Title'));
    }

    public function update(Request $request, $id)
    {
        $user = User::find($id);
        $data = $request->all();

        if ($request->has('path_foto')) {

            // Check if user has path_foto
            if (!empty(Auth::user()->path_foto)) {
                if (Auth::user()->isLevel('Admin')) {
                    $foto = $request->file('path_foto');
                    $filename = 'foto_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
                    $storedPath = $foto->storeAs('public/foto_admin', $filename);
                    Storage::url($storedPath);
                    $data = $request->except(['path_foto']);
                    $data['path_foto'] = "/storage/foto_admin/$filename";
                    // $foto = $request->file('foto_pengguna');
                    // $filename = 'foto_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
                    // $foto->storeAs('public/foto_admin', $filename);
                } elseif (Auth::user()->isLevel('Penguji')) {
                    $foto = $request->file('path_foto');
                    $filename = 'foto_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
                    $storedPath = $foto->storeAs('public/foto_penguji', $filename);
                    Storage::url($storedPath);
                    $data = $request->except(['path_foto']);
                    $data['path_foto'] = "/storage/foto_penguji/$filename";
                    // $foto = $request->file('foto_pengguna');
                    // $filename = 'foto_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
                    // $foto->storeAs('public/foto_penguji', $filename);
                } elseif (Auth::user()->isLevel('Pengguna')) {
                    $foto = $request->file('path_foto');
                    $filename = 'foto_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
                    $storedPath = $foto->storeAs('public/foto_pengguna', $filename);
                    Storage::url($storedPath);
                    $data = $request->except(['path_foto']);
                    $data['path_foto'] = "/storage/foto_pengguna/$filename";
                    // $foto = $request->file('foto_pengguna');
                    // $filename = 'foto_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
                    // $foto->storeAs('public/foto_pengguna', $filename);
                }
            } else {
                if (Auth::user()->isLevel('Admin')) {

                    if ($user->path_foto) {
                        $oldPhotoPath = str_replace('/storage', 'public', $user->path_foto);
                        if (Storage::exists($oldPhotoPath)) {
                            Storage::delete($oldPhotoPath);
                        }
                    }
                    $foto = $request->file('path_foto');
                    $filename = 'foto_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
                    $storedPath = $foto->storeAs('public/foto_admin', $filename);
                    Storage::url($storedPath);
                    $data = $request->except(['path_foto']);
                    $data['path_foto'] = "/storage/foto_admin/$filename";
                    // $foto = $request->file('foto_pengguna');
                    // $filename = 'foto_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
                    // $stored = $foto->storeAs('public/foto_admin', $filename);

                    // $request->merge([
                    //     'path_foto' => Storage::url($stored)
                    // ]);
                } elseif (Auth::user()->isLevel('Penguji')) {

                    if ($user->path_foto) {
                        $oldPhotoPath = str_replace('/storage', 'public', $user->path_foto);
                        if (Storage::exists($oldPhotoPath)) {
                            Storage::delete($oldPhotoPath);
                        }
                    }
                    $foto = $request->file('path_foto');
                    $filename = 'foto_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
                    $storedPath = $foto->storeAs('public/foto_penguji', $filename);
                    Storage::url($storedPath);
                    $data = $request->except(['path_foto']);
                    $data['path_foto'] = "/storage/foto_penguji/$filename";
                    // $foto = $request->file('foto_pengguna');
                    // $filename = 'foto_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
                    // $stored = $foto->storeAs('public/foto_penguji', $filename);

                    // $request->merge([
                    //     'path_foto' => Storage::url($stored)
                    // ]);
                } elseif (Auth::user()->isLevel('Pengguna')) {

                    if ($user->path_foto) {
                        $oldPhotoPath = str_replace('/storage', 'public', $user->path_foto);
                        if (Storage::exists($oldPhotoPath)) {
                            Storage::delete($oldPhotoPath);
                        }
                    }
                    $foto = $request->file('path_foto');
                    $filename = 'foto_' . $request->nama_lengkap . '.' . $foto->getClientOriginalExtension();
                    $storedPath = $foto->storeAs('public/foto_pengguna', $filename);
                    Storage::url($storedPath);
                    $data = $request->except(['path_foto']);
                    $data['path_foto'] = "/storage/foto_pengguna/$filename";
                    // $foto = $request->file('foto_pengguna');
                    // $filename = 'foto_' . $request->nomor_induk . '.' . $foto->getClientOriginalExtension();
                    // $stored = $foto->storeAs('public/foto_pengguna', $filename);

                    // $request->merge([
                    //     'path_foto' => Storage::url($stored)
                    // ]);
                }
            }
            // END Check path_foto
        }

        if ($request->has('password_lama') && $request->has('password_baru') && $request->has('konfirmasi_password_baru')) {
            if (!Hash::check($request->password_lama, $user->password)) {
                Alert::error('Gagal Tersimpan!', 'Password lama salah');
                return redirect()->back();
            } else {
                if ($request->password_baru != $request->konfirmasi_password_baru) {
                    Alert::error('Gagal Tersimpan!', 'Password baru tidak sama');
                    return redirect()->back();
                } else {
                    $user->password = Hash::make($request->password_baru);
                    $user->save();

                    Alert::success('Berhasil Tersimpan!', 'Password berhasil diperbarui');
                    return redirect()->back();
                }
            }
        }


        // $user->alamat = $request->input('alamat');
        // $user->save();

        $user->update($data);

        Alert::success('Berhasil Tersimpan!', 'Data berhasil diperbarui.');
        if (Auth::user()->level == 'Admin') {
            return redirect()->route('profile.index');
        } elseif (Auth::user()->level == 'Pengguna') {
            return redirect()->route('profile-user.index');
        } elseif (Auth::user()->level == 'Penguji') {
            return redirect()->route('profile-penguji.index');
        }
    }

    public function destroy($id)
    {
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

        toast('Pengguna terhapus!', 'success');
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
