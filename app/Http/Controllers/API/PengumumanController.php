<?php

namespace App\Http\Controllers;

use App\Models\Pengumuman;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth; // Tambahin ini biar auth() lebih stabil

class PengumumanController extends Controller
{
    public function index()
    {
        // Pake paginate biar kalau pengumuman udah ribuan, web lo nggak lemot
        $announcements = Pengumuman::with('user')->latest()->paginate(10);
        return view('kepala-sekolah.pengumuman.index', compact('announcements'));
    }

    public function create()
    {
        return view('kepala-sekolah.pengumuman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type'  => 'required|in:info,urgent,event',
            'body'  => 'required|string',
        ]);

        // Proteksi: pastiin user emang login
        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Sesi habis.');
        }

        Pengumuman::create([
            'title'   => $request->title,
            'slug'    => Str::slug($request->title) . '-' . Str::lower(Str::random(5)),
            'type'    => $request->type,
            'body'    => $request->body,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('kepala-sekolah.pengumuman.index')
                         ->with('success', 'Pengumuman berhasil diterbitkan!');
    }

    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        $pengumuman->delete();
        
        return redirect()->back()->with('success', 'Pengumuman berhasil dihapus.');
    }
}