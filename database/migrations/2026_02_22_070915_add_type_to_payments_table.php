<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('payments', 'is_tagihan')) {
            Schema::table('payments', function (Blueprint $table) {
                // Tandai apakah tagihan ini dibuat oleh admin (bukan siswa upload sendiri)
                $table->boolean('is_tagihan')->default(false)->after('year');
            });
        }

        if (!Schema::hasColumn('payments', 'jenis_tagihan')) {
            Schema::table('payments', function (Blueprint $table) {
                // Jenis tagihan bebas: SPP, Seragam, UTS, UAS, Lainnya
                $table->string('jenis_tagihan')->nullable()->after('is_tagihan');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('payments', 'jenis_tagihan')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->dropColumn('jenis_tagihan');
            });
        }

        if (Schema::hasColumn('payments', 'is_tagihan')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->dropColumn('is_tagihan');
            });
        }
    }
};