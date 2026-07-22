<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class ExamPayment extends Model
{
    protected $fillable = ['student_id', 'type', 'amount', 'status', 'proof', 'academic_year', 'catatan'];

    public function student() { return $this->belongsTo(Student::class); }
}