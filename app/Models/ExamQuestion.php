<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ExamQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'type',
        'question',
        'options',
        'correct_answer',
        'points',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'options'    => 'array',
        'points'     => 'integer',
        'sort_order' => 'integer',
        'is_active'  => 'boolean',
    ];

    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}