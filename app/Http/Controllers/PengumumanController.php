<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pengumuman;
use Illuminate\Support\Facades\Auth;

class PengumumanController extends Controller
{
    public function index()
    {
        $announcements = Pengumuman::with('user')
            ->orderByDesc('is_pinned')
            ->latest()
            ->paginate(10);

        return view('kepala_sekolah.pengumuman.index', compact('announcements'));
    }

    public function create()
    {
        return view('kepala_sekolah.pengumuman.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title'     => 'required|string|max:255',
            'type'      => 'required|in:info,event,urgent',
            'body'      => 'required|string',
            'is_pinned' => 'nullable|boolean',
        ]);

        if (!Auth::check()) {
            return redirect()->route('login')->with('error', 'Sesi habis.');
        }

        Pengumuman::create([
            'title'     => $request->title,
            'type'      => $request->type,
            'body'      => $request->body,
            'user_id'   => Auth::id(),
            'is_pinned' => $request->boolean('is_pinned'),
        ]);

        return redirect()->route('kepala-sekolah.pengumuman.index')->with('success', 'Pengumuman berhasil dikirim!');
    }

    public function destroy($id)
    {
        $pengumuman = Pengumuman::findOrFail($id);
        
        // Pastikan hanya pembuat (kepala sekolah) yang bisa hapus
        /** @var \App\Models\User $user */
        $user = Auth::user();
        if (Auth::id() !== $pengumuman->user_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menghapus pengumuman ini.');
        }

        $pengumuman->delete();
        
        return redirect()->back()->with('success', 'Pengumuman berhasil dihapus!');
    }

    public function togglePin(Pengumuman $pengumuman)
    {
        // Hanya pembuat (kepala sekolah) yang bisa toggle pin
        if (Auth::id() !== $pengumuman->user_id) {
            return redirect()->back()->with('error', 'Anda tidak memiliki izin untuk menyematkan pengumuman ini.');
        }

        $nextPinnedState = !$pengumuman->is_pinned;
        $pengumuman->update([
            'is_pinned' => $nextPinnedState,
        ]);

        $message = $nextPinnedState ? 'Pengumuman berhasil disematkan.' : 'Sematan pengumuman berhasil dilepas.';

        return redirect()->back()->with('success', $message);
    }
}
