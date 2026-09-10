<?php

namespace App\Http\Controllers;

use App\Models\SuratDisposition;
use App\Models\Notifikasi;
use App\Models\Surat;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class SuratController extends Controller
{
    public function index(Request $request): View
    {
        $query = Surat::with('creator')->latest('letter_date')->latest('id');

        if ($request->filled('type') && in_array($request->type, ['masuk', 'keluar'], true)) {
            $query->where('type', $request->type);
        }

        if ($request->filled('status') && in_array($request->status, ['baru', 'diproses', 'selesai', 'arsip'], true)) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $search = trim((string) $request->q);
            $query->where(function ($builder) use ($search) {
                $builder->where('number', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('sender', 'like', "%{$search}%")
                    ->orWhere('recipient', 'like', "%{$search}%");
            });
        }

        $letters = $query->paginate(15)->withQueryString();
        $summary = [
            'total' => Surat::count(),
            'masuk' => Surat::where('type', 'masuk')->count(),
            'keluar' => Surat::where('type', 'keluar')->count(),
            'baru' => Surat::where('status', 'baru')->count(),
        ];

        return view('surat.index', compact('letters', 'summary'));
    }

    public function create(): View
    {
        $surat = new Surat([
            'type' => 'masuk',
            'status' => 'baru',
            'letter_date' => now(),
        ]);

        $nextNumber = Surat::generateNextNumber();
        return view('surat.create', compact('surat', 'nextNumber'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data['created_by'] = $request->user()->id;

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('surat', 'public');
        }

        Surat::create($data);

        return redirect()->route('surat.index')->with('success', 'Surat berhasil ditambahkan.');
    }

    public function show(Surat $surat): View
    {
        $surat->load(['creator', 'dispositions.disposedBy', 'dispositions.disposedTo']);

        // Ambil user yang bisa menerima disposisi (misal: semua admin dan guru)
        $dispositionUsers = User::whereIn('role', ['admin', 'guru', 'teacher', 'kepala_sekolah'])
            ->where('id', '!=', Auth::id()) // Tidak bisa disposisi ke diri sendiri
            ->orderBy('name')
            ->get();

        // Opsi instruksi disposisi
        $instructions = ['Untuk diketahui', 'Mohon ditindaklanjuti', 'Siapkan balasan', 'Untuk diarsipkan', 'Koordinasikan'];

        return view('surat.show', compact('surat', 'dispositionUsers', 'instructions'));
    }

    public function edit(Surat $surat): View
    {
        return view('surat.edit', compact('surat'));
    }

    public function update(Request $request, Surat $surat): RedirectResponse
    {
        $data = $this->validated($request);

        if ($request->hasFile('attachment')) {
            if ($surat->attachment) {
                Storage::disk('public')->delete($surat->attachment);
            }
            $data['attachment'] = $request->file('attachment')->store('surat', 'public');
        }

        $surat->update($data);

        return redirect()->route('surat.index')->with('success', 'Surat berhasil diperbarui.');
    }

    public function destroy(Surat $surat): RedirectResponse
    {
        if ($surat->attachment) {
            Storage::disk('public')->delete($surat->attachment);
        }

        $surat->delete();

        return redirect()->route('surat.index')->with('success', 'Surat berhasil dihapus.');
    }

    public function storeDisposition(Request $request, Surat $surat): RedirectResponse
    {
        $data = $request->validate([
            'disposed_to_user_id' => 'required|exists:users,id',
            'instruction' => 'required|string|max:255',
            'notes' => 'nullable|string|max:2000',
        ]);

        SuratDisposition::create([
            'surat_id' => $surat->id,
            'disposed_by_user_id' => Auth::id(),
            'disposed_to_user_id' => $data['disposed_to_user_id'],
            'instruction' => $data['instruction'],
            'notes' => $data['notes'],
        ]);

        // Ubah status surat menjadi 'diproses' setelah didisposisi
        $surat->update(['status' => 'diproses']);

        // Buat notifikasi untuk user yang dituju
        try {
            Notifikasi::create([
                'user_id' => $data['disposed_to_user_id'],
                'surat_id' => $surat->id,
                'judul' => 'Disposisi Surat Baru',
                'pesan' => 'Anda menerima disposisi surat "' . \Illuminate\Support\Str::limit($surat->subject, 50) . '" dari ' . Auth::user()->name,
                'tipe' => 'surat',
                'dibaca' => false,
            ]);
        } catch (\Throwable $e) {
            // Abaikan jika gagal membuat notifikasi, proses utama tetap jalan
        }

        return back()->with('success', 'Disposisi berhasil dikirim.');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'type' => 'required|in:masuk,keluar',
            'number' => 'required|string|max:120',
            'letter_date' => 'required|date',
            'sender' => 'nullable|string|max:180',
            'priority' => 'required|in:biasa,penting,segera',
            'recipient' => 'nullable|string|max:180',
            'subject' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'status' => 'required|in:baru,diproses,selesai,arsip',
            'notes' => 'nullable|string|max:5000',
            'attachment' => 'nullable|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:10240',
        ]);
    }
}
