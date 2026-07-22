<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();

        return view('admin.profile.edit', compact('user'));
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'photo' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $user->name  = $request->name;
        $user->email = $request->email;

        if ($request->hasFile('photo')) {
            $photo    = $request->file('photo');
            $filename = 'admin_' . $user->id . '_' . time() . '.' . $photo->getClientOriginalExtension();
            $path     = $photo->storeAs('uploads/profile', $filename, 'public');
            $user->photo = $path;
        }

        $user->save();

        return redirect()->route('admin.profile.edit')->with('success', 'Profil berhasil diperbarui.');
    }

    /**
     * Upload foto profil via sidebar (AJAX).
     */
    public function updatePhoto(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'photo' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $photo    = $request->file('photo');
            $filename = 'admin_' . $user->id . '_' . time() . '.' . $photo->getClientOriginalExtension();
            $path     = $photo->storeAs('uploads/profile', $filename, 'public');
            $user->photo = $path;
            $user->save();
        }

        return response()->json([
            'success' => true,
            'photo'   => $user->photo,
        ]);
    }
}