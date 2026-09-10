<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

/**
 * App\Models\Student model
 *
 * @property int $id
 * @property string $name
 * @property string $nis
 * @property string $class_id
 * @property string $email
 * @property int|null $user_id
 */
class Student extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'nis', 'class_id', 'tahun_ajaran', 'gender', 'email', 'user_id', 'beasiswa_type', 'potongan_spp'];

    protected $casts = [
        'potongan_spp' => 'decimal:2',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Find a student record using the authenticated user's email first,
     * and fallback to user_id if the column exists in the database.
     */
    public static function findByUser($user)
    {
        $query = static::where('email', $user->email);

        if (Schema::hasColumn((new static)->getTable(), 'user_id')) {
            $query->orWhere('user_id', $user->id);
        }

        return $query->first();
    }

    /**
     * Create a student record for the authenticated user.
     * The user_id attribute is included only when the column exists.
     */
    public static function createForUser($user, array $attributes = [])
    {
        $defaults = [
            'name'     => $user->name,
            'email'    => $user->email,
            'nis'      => 'AUTO-' . $user->id . '-' . now()->format('YmdHis'),
            'class_id' => 'X - IPA',
        ];

        if (Schema::hasColumn((new static)->getTable(), 'user_id')) {
            $defaults['user_id'] = $user->id;
        }

        return static::create(array_merge($defaults, $attributes));
    }
}