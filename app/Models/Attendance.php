<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\Attendance model
 *
 * @property int $id
 * @property int $student_id
 * @property int $schedule_id
 * @property \Illuminate\Support\Carbon $date
 * @property string $status
 * @property string|null $comment
 * @property int|null $created_by
 * @property \Illuminate\Support\Carbon|null $submitted_at
 * @property string|null $verification_status
 * @property string|null $verification_note
 */
class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'schedule_id',
        'date',
        'status',
        'keterangan',
        'created_by',
        'comment',
        'submitted_at',
        'verification_status',
        'verification_note',
    ];

    protected $casts = [
        'date'         => 'date',
        'submitted_at' => 'datetime',
    ];

    /**
     * Get the student
     */
    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class, 'student_id');
    }

    /**
     * Get the schedule (mapel)
     */
    public function schedule(): BelongsTo
    {
        return $this->belongsTo(Schedule::class);
    }

    /**
     * Get who created this record
     */
    public function createdBy(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope untuk attendance pending verification
     */
    public function scopePending($query)
    {
        return $query->where('verification_status', 'pending');
    }

    /**
     * Scope untuk attendance yang sudah verified
     */
    public function scopeVerified($query)
    {
        return $query->where('verification_status', 'verified');
    }

    /**
     * Get status label
     */
    public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'hadir' => '✓ Hadir',
            'sakit' => '🤒 Sakit',
            'izin'  => '📝 Izin',
            'alpha' => '✕ Bolos',
            default => 'Belum Absen'
        };
    }

    /**
     * Get verification status label
     */
    public function getVerificationLabelAttribute(): string
    {
        return match($this->verification_status) {
            'pending'  => '⏳ Menunggu',
            'verified' => '✓ Terverifikasi',
            'rejected' => '✕ Ditolak',
            default    => 'Unknown'
        };
    }
}
