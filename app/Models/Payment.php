<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'jenis_tagihan',
        'amount',
        'month',
        'year',
        'status',
        'type',
        'is_tagihan',
        'proof',
        'payment_method',
        'catatan',
        'keterangan',       // nama/tujuan tagihan dari admin
        'catatan_reject',   // alasan penolakan dari admin
    ];

    protected $casts = [
        'amount'     => 'decimal:2',
        'is_tagihan' => 'boolean',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /*
    |------------------------------------------------------------------
    | HELPERS
    |------------------------------------------------------------------
    */

    // Apakah tagihan ini ditolak?
    public function isRejected(): bool
    {
        return $this->status === 'rejected' || $this->status === 'unpaid' && !empty($this->catatan_reject);
    }
}