<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            abort(403, 'Unauthorized');
        }

        $user = Auth::user();
        $roleValue = $user->role;

        // Cek apakah role disimpan sebagai relasi (object) atau string langsung
        if (is_object($roleValue) && property_exists($roleValue, 'name')) {
            $userRole = strtolower($roleValue->name ?? '');
        } else {
            $userRole = strtolower($roleValue ?? '');
        }

        // Normalisasi roles yang diizinkan (trim spasi, lowercase)
        $allowedRoles = array_map(fn($r) => strtolower(trim($r)), $roles);

        if (!in_array($userRole, $allowedRoles)) {
            abort(403, 'Anda tidak memiliki akses ke halaman ini.');
        }

        return $next($request);
    }
}