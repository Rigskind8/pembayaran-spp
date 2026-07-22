<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User model
 *
 * @property int $id
 * @property string $name
 * @property string $email
 * @property string $role
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string|null $remember_token
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * @property string $role 'admin' | 'guru' | 'siswa' | 'kepala_sekolah'
     */

    protected $fillable = [
        'name',
        'email',
        'password',
        'role', // 'admin' | 'guru' | 'siswa' | 'kepala_sekolah'
        'photo',
    ];

    protected $hidden = ['password', 'remember_token'];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password'          => 'hashed',
    ];

    public function isAdmin(): bool  { return $this->role === 'admin'; }
    public function isGuru(): bool   { return in_array($this->role, ['guru', 'teacher'], true); }
    public function isSiswa(): bool  { return $this->role === 'siswa'; }
    public function isKepsek(): bool { return $this->role === 'kepala_sekolah'; }

    public function ujians(): HasMany
    {
        return $this->hasMany(Ujian::class);
    }

    public function notifikasis(): HasMany
    {
        return $this->hasMany(Notifikasi::class)->latest();
    }

    public function notifikasiBelumDibaca(): HasMany
    {
        return $this->hasMany(Notifikasi::class)->where('dibaca', false);
    }

    public function student()
    {
        return $this->hasOne(Student::class);
    }
}