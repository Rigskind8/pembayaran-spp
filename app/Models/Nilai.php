<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Nilai extends Model
{
    protected $fillable = [
        'student_id',
        'subject_id',
        'type',
        'semester',
        'tahun',
        'nilai',
        'keterangan',
    ];

    protected $casts = [
        'nilai' => 'decimal:2',
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function subject()
    {
        return $this->belongsTo(Subject::class);
    }
}