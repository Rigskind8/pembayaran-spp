<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Payment;
use App\Models\Student;
use App\Models\PaymentMethod;

class PembayaranController extends Controller
{
    private function activePaymentMethodNames(): array
    {
        return PaymentMethod::active()
            ->pluck('name')
            ->filter()
            ->map(fn ($name) => trim((string) $name))
            ->values()
            ->all();
    }

    private function resolveStudentForAuthenticatedUser(): ?Student
    {
        /** @var \App\Models\User|null $user */
        $user = auth()->user();

        if (!$user) {
            return null;
        }

        $student = Student::findByUser($user);

        // Auto-create profil siswa bila role siswa belum punya relasi student.
        if (!$student && $user->role === 'siswa') {
            $student = Student::createForUser($user);
        }

        return $student;
    }

    /* ===============================
       INDEX SISWA — halaman pembayaran siswa
    =============================== */
    public function index()
    {
        return $this->indexSiswa();
    }

    public function indexSiswa()
    {
        $student = $this->resolveStudentForAuthenticatedUser();

        if (!$student) {
            return redirect()->route('dashboard')
                ->with('error', 'Profil siswa belum terhubung ke akun Anda.');
        }

        // Tagihan aktif: dibuat admin (is_tagihan = true), belum lunas
        $tagihan = Payment::where('student_id', $student->id)
            ->where(function ($q) {
                $q->where('is_tagihan', true)
                  ->orWhereNotNull('jenis_tagihan');
            })
            ->whereNotIn('status', ['approved', 'paid'])
            ->latest()
            ->get();

        // Riwayat: hanya yang sudah approved/paid
        $riwayat = Payment::where('student_id', $student->id)
            ->whereIn('status', ['approved', 'paid'])
            ->latest()
            ->get();

        $paymentMethods = PaymentMethod::active()->orderBy('name')->get();

        return view('students.pembayaran', compact('tagihan', 'riwayat', 'student', 'paymentMethods'));
    }

    /* ===============================
       ADMIN INDEX
    =============================== */
    public function adminIndex()
    {
        $payments = Payment::with('student')
            ->latest()
            ->paginate(10);

        $totalApproved = Payment::whereIn('status', ['approved', 'paid'])->count();
        $totalPending  = Payment::where('status', 'pending')->count();
        $totalUnpaid   = Payment::where('status', 'unpaid')->count();
        $totalNominal  = Payment::whereIn('status', ['approved', 'paid'])->sum('amount');

        return view('payments.admin', compact(
            'payments',
            'totalApproved',
            'totalPending',
            'totalUnpaid',
            'totalNominal'
        ));
    }

    /* ===============================
       FORM BUAT TAGIHAN (Admin)
    =============================== */
    public function createTagihan()
    {
        $students = Student::orderBy('name')->get();
        return view('payments.create-tagihan', compact('students'));
    }

    /* ===============================
       SIMPAN TAGIHAN SINGLE (Admin)
    =============================== */
    public function storeTagihan(Request $request)
    {
        $request->validate([
            'student_id'    => 'required|exists:students,id',
            'jenis_tagihan' => 'required|string|max:100',
            'keterangan'    => 'nullable|string|max:255',
            'amount'        => 'required|numeric|min:1',
            'month'         => 'required|string',
            'year'          => 'required|numeric|min:2020|max:2099',
        ]);

        Payment::create([
            'student_id'    => $request->student_id,
            'jenis_tagihan' => $request->jenis_tagihan,
            'keterangan'    => $request->keterangan,
            'amount'        => $request->amount,
            'month'         => $request->month,
            'year'          => $request->year,
            'type'          => $request->jenis_tagihan === 'SPP' ? 'SPP' : 'Lainnya',
            'status'        => 'unpaid',
            'is_tagihan'    => true,
        ]);

        return redirect()->route('admin.payments')
            ->with('success', 'Tagihan berhasil dibuat.');
    }

    /* ===============================
       SIMPAN TAGIHAN BULK (Admin → semua siswa)
    =============================== */
    public function storeTagihanBulk(Request $request)
    {
        $request->validate([
            'jenis_tagihan' => 'required|string|max:100',
            'keterangan'    => 'nullable|string|max:255',
            'amount'        => 'required|numeric|min:1',
            'month'         => 'required|string',
            'year'          => 'required|numeric|min:2020|max:2099',
        ]);

        $students = Student::all();
        $jumlah   = 0;

        foreach ($students as $student) {
            $sudahAda = Payment::where('student_id', $student->id)
                ->where('jenis_tagihan', $request->jenis_tagihan)
                ->where('month', $request->month)
                ->where('year', $request->year)
                ->where('is_tagihan', true)
                ->exists();

            if (!$sudahAda) {
                Payment::create([
                    'student_id'    => $student->id,
                    'jenis_tagihan' => $request->jenis_tagihan,
                    'keterangan'    => $request->keterangan,
                    'amount'        => $request->amount,
                    'month'         => $request->month,
                    'year'          => $request->year,
                    'type'          => $request->jenis_tagihan === 'SPP' ? 'SPP' : 'Lainnya',
                    'status'        => 'unpaid',
                    'is_tagihan'    => true,
                ]);
                $jumlah++;
            }
        }

        return redirect()->route('admin.payments')
            ->with('success', "Tagihan berhasil dibuat untuk {$jumlah} siswa.");
    }

    /* ===============================
       SISWA BAYAR LANGSUNG (tanpa bukti)
    =============================== */
    public function bayarLangsung(Request $request)
    {
        $request->validate([
            'payment_id'     => 'required|exists:payments,id',
            'payment_method' => 'required|string|max:100',
            'catatan'        => 'nullable|string|max:500',
        ]);

        $student = $this->resolveStudentForAuthenticatedUser();

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Profil siswa belum terhubung ke akun Anda.',
            ], 404);
        }

        $payment = Payment::where('id', $request->payment_id)
            ->where('student_id', $student->id)
            ->whereIn('status', ['unpaid', 'pending'])
            ->first();

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Tagihan tidak valid atau tidak bisa diproses.',
            ], 403);
        }

        $payment->update([
            'payment_method' => $request->payment_method,
            'catatan'        => $request->catatan,
            'proof'          => null,
            'status'         => 'pending',
            'catatan_reject' => null,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Pembayaran berhasil dikirim, menunggu verifikasi admin.',
        ]);
    }

    /* ===============================
       CREATE (manual, bukan tagihan)
    =============================== */
    public function create()
    {
        $students = Student::orderBy('name')->get();
        return view('payments.create', compact('students'));
    }

    /* ===============================
       STORE
    =============================== */
    public function store(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'type'       => 'required|in:SPP,UTS,UAS,Lainnya',
            'month'      => 'required',
            'year'       => 'required|numeric',
            'amount'     => 'required|numeric|min:1',
            'status'     => 'required|in:unpaid,paid',
            'catatan'    => 'nullable|string|max:500',
        ]);

        Payment::create([
            'student_id' => $request->student_id,
            'type'       => $request->type,
            'month'      => $request->month,
            'year'       => $request->year,
            'amount'     => $request->amount,
            'status'     => $request->status,
            'catatan'    => $request->catatan,
            'is_tagihan' => false,
        ]);

        return redirect()->route('admin.payments')
            ->with('success', 'Data pembayaran berhasil disimpan.');
    }

    /* ===============================
       UPLOAD BUKTI
    =============================== */
    public function uploadBukti(Request $request)
    {
        $request->validate([
            'payment_id'     => 'required|exists:payments,id',
            'proof'          => 'required|file|mimes:jpg,jpeg,png,pdf|max:5120',
            'payment_method' => 'required|string|max:100',
            'catatan'        => 'nullable|string|max:500',
        ]);

        $activeMethodNames = $this->activePaymentMethodNames();
        if (!empty($activeMethodNames) && !in_array(trim((string) $request->payment_method), $activeMethodNames, true)) {
            return response()->json([
                'success' => false,
                'message' => 'Metode pembayaran tidak valid. Pilih metode yang tersedia.',
            ], 422);
        }

        $student = $this->resolveStudentForAuthenticatedUser();

        if (!$student) {
            return response()->json([
                'success' => false,
                'message' => 'Profil siswa belum terhubung ke akun Anda.',
            ], 404);
        }

        $payment = Payment::where('id', $request->payment_id)
            ->where('student_id', $student->id)
            ->whereIn('status', ['unpaid', 'pending'])
            ->first();

        if (!$payment) {
            return response()->json([
                'success' => false,
                'message' => 'Tagihan tidak valid atau tidak bisa diproses.',
            ], 403);
        }

        if ($payment->proof && \Storage::disk('public')->exists($payment->proof)) {
            \Storage::disk('public')->delete($payment->proof);
        }

        $filePath = $request->file('proof')->store('payments/bukti', 'public');

        $payment->update([
            'proof'          => $filePath,
            'payment_method' => $request->payment_method,
            'catatan'        => $request->catatan,
            'catatan_reject' => null,
            'status'         => 'pending',
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Bukti pembayaran berhasil dikirim.',
        ]);
    }

    /* ===============================
       SHOW
    =============================== */
    public function show(Payment $payment)
    {
        $payment->load('student');
        return view('payments.show', compact('payment'));
    }

    /* ===============================
       EDIT
    =============================== */
    public function edit(Payment $payment)
    {
        $students = Student::orderBy('name')->get();
        return view('payments.edit', compact('payment', 'students'));
    }

    /* ===============================
       UPDATE
    =============================== */
    public function update(Request $request, Payment $payment)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'type'       => 'required|in:SPP,UTS,UAS,Lainnya',
            'month'      => 'required',
            'year'       => 'required|numeric',
            'amount'     => 'required|numeric',
            'status'     => 'required|in:unpaid,pending,paid,approved',
            'catatan'    => 'nullable|string|max:500',
        ]);

        $payment->update($request->only([
            'student_id', 'type', 'month',
            'year', 'amount', 'status', 'catatan'
        ]));

        return redirect()->route('admin.payments')
            ->with('success', 'Data pembayaran berhasil diperbarui.');
    }

    /* ===============================
       DESTROY
    =============================== */
    public function destroy(Payment $payment)
    {
        if ($payment->proof && \Storage::disk('public')->exists($payment->proof)) {
            \Storage::disk('public')->delete($payment->proof);
        }

        $payment->delete();

        return redirect()->route('admin.payments')
            ->with('success', 'Data pembayaran berhasil dihapus.');
    }

    /* ===============================
       VERIFY — FIXED
    =============================== */
    public function verify(Payment $payment)
    {
        $payment->update([
            'status'         => 'approved',
            'catatan_reject' => null,
        ]);

        $referer = request()->headers->get('referer');

        return $referer
            ? redirect($referer)->with('success', 'Pembayaran berhasil diverifikasi.')
            : redirect()->route('admin.payments')->with('success', 'Pembayaran berhasil diverifikasi.');
    }

    /* ===============================
       REJECT — FIXED
    =============================== */
    public function reject(Request $request, Payment $payment)
    {
        $request->validate([
            'reason' => 'nullable|string|max:255',
        ]);

        if ($payment->proof && \Storage::disk('public')->exists($payment->proof)) {
            \Storage::disk('public')->delete($payment->proof);
        }

        $payment->update([
            'status'         => 'unpaid',
            'proof'          => null,
            'catatan_reject' => $request->reason,
        ]);

        $referer = request()->headers->get('referer');

        return $referer
            ? redirect($referer)->with('success', 'Pembayaran ditolak.')
            : redirect()->route('admin.payments')->with('success', 'Pembayaran ditolak.');
    }

    /* ===============================
       BULK APPROVE — FIXED
    =============================== */
    public function bulkApprove()
    {
        $jumlah = Payment::where('status', 'pending')
            ->update(['status' => 'approved']);

        $referer = request()->headers->get('referer');

        return $referer
            ? redirect($referer)->with('success', "Berhasil menyetujui {$jumlah} pembayaran.")
            : redirect()->route('admin.payments')->with('success', "Berhasil menyetujui {$jumlah} pembayaran.");
    }

    /* ===============================
       REPORT
    =============================== */
    public function report()
    {
        $tahun = request('tahun', date('Y'));

        $payments = Payment::with('student')
            ->whereIn('status', ['paid', 'approved'])
            ->whereYear('created_at', $tahun)
            ->latest()
            ->get();

        $totalPemasukan = $payments->sum('amount');

        return view('payments.report', compact(
            'payments',
            'totalPemasukan',
            'tahun'
        ));
    }

    /* ===============================
       DOWNLOAD PDF
    =============================== */
    public function downloadPDF()
    {
        $student = $this->resolveStudentForAuthenticatedUser();

        if (!$student) {
            return redirect()->route('dashboard')
                ->with('error', 'Profil siswa belum terhubung ke akun Anda.');
        }

        $payments = Payment::where('student_id', $student->id)
            ->whereIn('status', ['paid', 'approved'])
            ->get();

        $ttd                 = \App\Models\Setting::get('ttd_bendahara');
        $namaBendahara       = \App\Models\Setting::get('nama_bendahara', 'Bendahara');
        $namaKepalaSekolah   = \App\Models\Setting::get('nama_kepala_sekolah', 'Kepala Sekolah');
        $namaSekolah         = \App\Models\Setting::get('nama_sekolah', 'SMK Travina Prima');
        $ttdImage            = null;

        $toDataUri = static function (string $path): ?string {
            if (!is_file($path)) {
                return null;
            }

            $mime = @mime_content_type($path) ?: 'image/png';
            $data = @file_get_contents($path);

            if ($data === false) {
                return null;
            }

            return 'data:' . $mime . ';base64,' . base64_encode($data);
        };

        if (!empty($ttd)) {
            $storageTtd = storage_path('app/public/' . ltrim((string) $ttd, '/'));
            $ttdImage = $toDataUri($storageTtd);
        }

        if (empty($ttdImage)) {
            $fallbacks = [
                storage_path('app/public/ttd/ttd.png'),
                public_path('storage/ttd/ttd.png'),
                public_path('ttd.png'),
            ];

            foreach ($fallbacks as $path) {
                $ttdImage = $toDataUri($path);
                if (!empty($ttdImage)) {
                    break;
                }
            }
        }

        return view('payments.pdf', compact('payments', 'student', 'ttd', 'ttdImage', 'namaBendahara', 'namaKepalaSekolah', 'namaSekolah'));
    }
}