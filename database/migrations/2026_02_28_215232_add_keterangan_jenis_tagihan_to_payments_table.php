<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('payments', 'jenis_tagihan')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->string('jenis_tagihan')->nullable()->after('student_id');
            });
        }

        if (!Schema::hasColumn('payments', 'keterangan')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->string('keterangan')->nullable()->after('jenis_tagihan');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('payments', 'keterangan')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->dropColumn('keterangan');
            });
        }

        if (Schema::hasColumn('payments', 'jenis_tagihan')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->dropColumn('jenis_tagihan');
            });
        }
    }
};