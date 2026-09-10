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
        'original_amount',
        'discount_amount',
        'penalty_amount',
        'discount_reason',
        'due_date',
    ];

    protected $casts = [
        'amount'          => 'decimal:2',
        'original_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'penalty_amount'  => 'decimal:2',
        'is_tagihan'      => 'boolean',
        'due_date'        => 'date',
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