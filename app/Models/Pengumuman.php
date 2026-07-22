<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pengumuman extends Model
{
    protected $table = 'pengumuman';

    protected $fillable = [
        'title',
        'slug',
        'type',
        'body',
        'user_id',
        'is_pinned',
    ];

    protected $casts = [
        'is_pinned' => 'boolean',
    ];

    /**
     * Get the user that created this announcement
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
