<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('ujians')) {
            return;
        }

        if (!Schema::hasColumn('ujians', 'jenis')) {
            Schema::table('ujians', function (Blueprint $table) {
                $table->string('jenis')->nullable()->after('user_id');
            });
        }

        if (!Schema::hasColumn('ujians', 'mata_pelajaran')) {
            Schema::table('ujians', function (Blueprint $table) {
                $table->string('mata_pelajaran')->nullable()->after('jenis');
            });
        }

        if (!Schema::hasColumn('ujians', 'tanggal_ujian')) {
            Schema::table('ujians', function (Blueprint $table) {
                $table->date('tanggal_ujian')->nullable()->after('mata_pelajaran');
            });
        }

        if (!Schema::hasColumn('ujians', 'verified_at')) {
            Schema::table('ujians', function (Blueprint $table) {
                $table->timestamp('verified_at')->nullable()->after('catatan_admin');
            });
        }
    }

    public function down(): void
    {
        if (!Schema::hasTable('ujians')) {
            return;
        }

        if (Schema::hasColumn('ujians', 'verified_at')) {
            Schema::table('ujians', function (Blueprint $table) {
                $table->dropColumn('verified_at');
            });
        }

        if (Schema::hasColumn('ujians', 'tanggal_ujian')) {
            Schema::table('ujians', function (Blueprint $table) {
                $table->dropColumn('tanggal_ujian');
            });
        }

        if (Schema::hasColumn('ujians', 'mata_pelajaran')) {
            Schema::table('ujians', function (Blueprint $table) {
                $table->dropColumn('mata_pelajaran');
            });
        }

        if (Schema::hasColumn('ujians', 'jenis')) {
            Schema::table('ujians', function (Blueprint $table) {
                $table->dropColumn('jenis');
            });
        }
    }
};
