<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Facades\Schema;

class Subject extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 
        'code', 
        'class_id', 
        'hours_per_week', 
        'teacher',
        'description',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Get all schedules for this subject
     */
    public function schedules(): HasMany
    {
        return $this->hasMany(Schedule::class);
    }

    /**
     * Scope to active subjects
     */
    public function scopeActive($query)
    {
        if (!Schema::hasColumn($this->getTable(), 'is_active')) {
            return $query;
        }

        return $query->where('is_active', true);
    }
}