<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use App\Models\Attendance;
use App\Models\Student;

/**
 * App\Models\Schedule model
 *
 * @property int $id
 * @property int $subject_id
 * @property int $teacher_id
 * @property string $class_id
 * @property string $day
 * @property \Illuminate\Support\Carbon $start_time
 * @property \Illuminate\Support\Carbon $end_time
 * @property string|null $room
 * @property bool $is_active
 */
class Schedule extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject_id',
        'teacher_id',
        'class_id',
        'day',
        'start_time',
        'end_time',
        'room',
        'is_active',
    ];

    protected $casts = [
        'start_time' => 'datetime:H:i',
        'end_time'   => 'datetime:H:i',
        'is_active'  => 'boolean',
    ];

    /**
     * Get the subject for this schedule
     */
    public function subject(): BelongsTo
    {
        return $this->belongsTo(Subject::class);
    }

    /**
     * Get the teacher for this schedule
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get attendance records for this schedule
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    public function absensiHariIni(): HasOne
    {
        $relation = $this->hasOne(Attendance::class)
                         ->where('date', today()->toDateString());

        if (auth()->check()) {
            $student = Student::findByUser(auth()->user());
            if ($student) {
                $relation->where('student_id', $student->id);
            }
        }

        return $relation;
    }

    /**
     * Scope to active schedules
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope by day of week
     */
    public function scopeByDay($query, $day)
    {
        $normalizedDay = strtolower(trim($day));
        return $query->whereRaw('LOWER(TRIM(day)) = ?', [$normalizedDay]);
    }

    /**
     * Scope by class
     */
    public function scopeByClass($query, $classId)
    {
        return $query->where('class_id', trim($classId));
    }
}
