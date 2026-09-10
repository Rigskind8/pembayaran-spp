<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Setting;

class SettingController extends Controller
{
    public function index()
    {
        $namaSekolah = Setting::get('nama_sekolah', 'SMK Travina Prima');
        $namaBendahara = Setting::get('nama_bendahara', 'Bendahara');
        $waAdminNumber = Setting::get('wa_admin_number', '6281388796229');
        $kodeSurat = Setting::get('kode_surat', 'SMK-TP');
        $logoSekolah = Setting::get('logo_sekolah');
        $ttd = Setting::get('ttd_bendahara');
        $examDurationUts = Setting::get('exam_duration_uts', 60);
        $examDurationUas = Setting::get('exam_duration_uas', 90);

        return view('settings.index', compact(
            'namaSekolah',
            'namaBendahara',
            'waAdminNumber',
            'kodeSurat',
            'logoSekolah',
            'ttd',
            'examDurationUts',
            'examDurationUas'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'nama_sekolah' => 'required|string|max:255',
            'nama_bendahara' => 'required|string|max:255',
            'kode_surat' => 'nullable|string|max:50',
            'wa_admin_number' => 'required|string|max:20',
            'logo_sekolah' => 'nullable|image|mimes:png,jpg,jpeg,webp|max:4096',
            'ttd_bendahara' => 'nullable|image|mimes:png,jpg,jpeg|max:2048',
            'exam_duration_uts' => 'nullable|integer|min:1',
            'exam_duration_uas' => 'nullable|integer|min:1',
        ]);

        Setting::set('nama_sekolah', $request->nama_sekolah);
        Setting::set('nama_bendahara', $request->nama_bendahara);
        Setting::set('kode_surat', $request->kode_surat ?: 'SMK-TP');

        if ($request->filled('exam_duration_uts')) Setting::set('exam_duration_uts', $request->exam_duration_uts);
        if ($request->filled('exam_duration_uas')) Setting::set('exam_duration_uas', $request->exam_duration_uas);

        $waNumber = preg_replace('/\D+/', '', (string) $request->wa_admin_number);
        if (str_starts_with($waNumber, '0')) {
            $waNumber = '62' . substr($waNumber, 1);
        }
        Setting::set('wa_admin_number', $waNumber ?: '6281388796229');

        if ($request->hasFile('logo_sekolah')) {
            $oldLogo = Setting::get('logo_sekolah');
            if ($oldLogo) {
                Storage::disk('public')->delete($oldLogo);
            }

            $logoPath = $request->file('logo_sekolah')->store('settings/logo', 'public');
            Setting::set('logo_sekolah', $logoPath);
        }

        if ($request->hasFile('ttd_bendahara')) {
            $oldTtd = Setting::get('ttd_bendahara');
            if ($oldTtd) {
                Storage::disk('public')->delete($oldTtd);
            }

            $path = $request->file('ttd_bendahara')->store('settings', 'public');
            Setting::set('ttd_bendahara', $path);
        }

        return back()->with('success', 'Pengaturan berhasil disimpan.');
    }

    public function hapusTTD()
    {
        $ttd = Setting::get('ttd_bendahara');

        if ($ttd) {
            Storage::disk('public')->delete($ttd);
            Setting::set('ttd_bendahara', null);
        }

        return back()->with('success', 'TTD dihapus.');
    }
}