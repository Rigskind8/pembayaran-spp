<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call(RoleSeeder::class);
        $this->call(SubjectSeeder::class);
        $this->call(ExamQuestionSeeder::class);

        User::factory()->create([
            'name'    => 'Admin User',
            'email'   => 'ricki@gmail.com',
            'password' => bcrypt('rigskind'),
            'role'    => 'admin',
        ]);

        User::factory()->create([
            'name'    => 'Teacher User',
            'email'   => 'anisa@gmail.com',
            'password' => bcrypt('rigskind'),
            'role'    => 'guru',
        ]);

        User::factory()->create([
            'name'    => 'Student User',
            'email'   => 'amel@gmail.com',
            'password' => bcrypt('rigskind'),
            'role'    => 'siswa',
        ]);
    }
}