<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Role;
use App\Models\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $users = User::latest()->get();
        return view('users.index', compact('users'));
    }

    public function edit(User $user)
    {
        $roles = Role::all();
        return view('users.edit', compact('user', 'roles'));
    }

    public function teachers()
    {
        $users = User::where('role', 'guru')->latest()->paginate(15);
        return view('users.teachers', compact('users'));
    }

    public function create()
    {
        $roles = Role::all(); 
        return view('users.create', compact('roles'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'role_id'  => 'required|exists:roles,id',
        ]);

        $role = Role::findOrFail($request->role_id);
        $roleValue = $this->normalizeRole($role->name);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $roleValue,
        ]);

        if ($roleValue === 'siswa') {
            $existingStudent = Student::where('email', $user->email)->first();

            if (!$existingStudent) {
                Student::createForUser($user, [
                    'nis' => $this->generateUniqueNis(),
                ]);
            }
        }

        return redirect()->route('users.index')->with('success', 'Akun user berhasil ditambahkan & otomatis terkoneksi ke Data Siswa!');
    }

    public function update(Request $request, User $user)
    {
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $user->id,
            'role_id'  => 'required|exists:roles,id',
        ]);

        $role = Role::findOrFail($request->role_id);
        $roleValue = $this->normalizeRole($role->name);
        $oldEmail = $user->email;
        $oldRole = $user->role;

        $user->update([
            'name'  => $request->name,
            'email' => $request->email,
            'role'  => $roleValue,
        ]);

        $student = Student::findByUser($user);

        if ($roleValue === 'siswa') {
            if ($student) {
                $student->update([
                    'name'  => $user->name,
                    'email' => $user->email,
                ]);
            } else {
                Student::createForUser($user, [
                    'nis' => $this->generateUniqueNis(),
                ]);
            }
        } elseif ($student && $oldRole === 'siswa') {
            $student->update([
                'name'  => $user->name,
                'email' => $user->email,
            ]);
        }

        if ($student && $oldEmail !== $user->email) {
            $student->update([
                'email' => $user->email,
            ]);
        }

        return redirect()->route('users.index')->with('success', 'Akun user berhasil diupdate!');
    }

    public function destroy(User $user)
    {
        if(auth()->id() === $user->id) {
            return back()->with('error', 'Bro, lo nggak bisa hapus akun lo sendiri yang lagi dipake login!');
        }

        $user->delete();
        return back()->with('success', 'Akun user berhasil dihapus!');
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'new_password' => 'required|string|min:6'
        ]);

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);

        return back()->with('success', "Password untuk akun {$user->name} berhasil di-reset!");
    }

    private function normalizeRole(string $role): string
    {
        $value = strtolower(trim($role));

        return match ($value) {
            'teacher' => 'guru',
            'student' => 'siswa',
            default => $value,
        };
    }

    private function generateUniqueNis(): string
    {
        do {
            $nis = 'AUTO-' . now()->format('ymdHis') . random_int(10, 99);
        } while (Student::where('nis', $nis)->exists());

        return $nis;
    }
}