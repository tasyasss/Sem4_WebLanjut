<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserModel;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function index()
    {
        $user = UserModel::with('level')->find(Auth::id());

        $breadcrumb = (object) [
            'title' => 'Profile Setting',
            'list' => ['Home', 'User', 'Profile Setting'],
        ];

        $page = (object) [
            'title' => 'Profile Setting',
        ];

        $activeMenu = 'profile';

        return view('profile.index', compact('user', 'breadcrumb', 'page', 'activeMenu'));
    }

    public function updateAvatar(Request $request)
    {
        $request->validate([
            'avatar' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = UserModel::find(Auth::id());

        if ($request->hasFile('avatar')) {
            if ($user->foto_profil && file_exists(public_path($user->foto_profil))) {
                unlink(public_path($user->foto_profil));
            }

            $filename = time() . '.' . $request->avatar->extension();
            $path = 'avatars/' . $filename;
            $request->avatar->move(public_path('avatars'), $filename);

            $user->update(['foto_profil' => $path]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'status' => true,
                    'message' => 'Avatar berhasil diperbarui!',
                    'new_avatar_url' => asset($path),
                ]);
            }

            return redirect()->back()->with('success', 'Avatar berhasil diperbarui!');
        }
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['status' => false, 'message' => 'Gagal memperbarui avatar.']);
        }

        return redirect()->back()->with('error', 'Gagal memperbarui avatar.');
    }
}
