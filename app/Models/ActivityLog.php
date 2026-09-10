<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'user_name',
        'role',
        'action',
        'description',
        'ip_address',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Record a system activity log.
     */
    public static function record(string $action, string $description): ?static
    {
        try {
            $user = Auth::user();
            return static::create([
                'user_id'     => $user?->id,
                'user_name'   => $user?->name ?? 'Guest/System',
                'role'        => $user?->role ?? 'system',
                'action'      => strtoupper($action),
                'description' => $description,
                'ip_address'  => request()->ip(),
            ]);
        } catch (\Throwable $e) {
            return null;
        }
    }
}

