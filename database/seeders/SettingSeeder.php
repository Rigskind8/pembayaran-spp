<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            ['key' => 'ttd_bendahara',  'value' => null],
            ['key' => 'logo_sekolah',   'value' => null],
            ['key' => 'nama_bendahara', 'value' => 'Bendahara'],
            ['key' => 'nama_sekolah',   'value' => 'SMK Travina Prima'],
            ['key' => 'wa_admin_number','value' => '6281388796229'],
        ];

        foreach ($settings as $setting) {
            DB::table('settings')->updateOrInsert(
                ['key' => $setting['key']],
                ['value' => $setting['value'], 'updated_at' => now(), 'created_at' => now()]
            );
        }
    }
}