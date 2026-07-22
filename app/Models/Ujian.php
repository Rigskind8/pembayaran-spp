<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Ujian extends Model
{
    protected $fillable = [
        'user_id',
        'subject_id',
        'jenis',
        'mata_pelajaran',
        'tanggal_ujian',
        'status',
        'bukti',
        'catatan_admin',
        'verified_at',
    ];

    protected $casts = [
        'tanggal_ujian' => 'date',
        'verified_at'   => 'datetime',
    ];

    // ── Relationships ──────────────────────────────────

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function notifikasis(): HasMany
    {
        return $this->hasMany(Notifikasi::class);
    }

    // ── Helpers ────────────────────────────────────────

    public function isPending(): bool   { return $this->status === 'pending'; }
    public function isVerified(): bool  { return $this->status === 'verified'; }
    public function isRejected(): bool  { return $this->status === 'rejected'; }

    public function jenisLabel(): string
    {
        return match($this->jenis) {
            'uts'      => 'UTS',
            'uas'      => 'UAS',
            'praktek'  => 'Praktek',
            'remedial' => 'Remedial',
            default    => strtoupper($this->jenis),
        };
    }
}