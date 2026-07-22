<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'subject_id',
        'type',
        'answers',
        'score',
        'max_score',
        'correct_count',
        'total_questions',
        'submitted_at',
    ];

    protected $casts = [
        'answers'       => 'array',
        'submitted_at'  => 'datetime',
        'score'         => 'decimal:2',
        'max_score'     => 'decimal:2',
        'correct_count' => 'integer',
        'total_questions' => 'integer',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }
}