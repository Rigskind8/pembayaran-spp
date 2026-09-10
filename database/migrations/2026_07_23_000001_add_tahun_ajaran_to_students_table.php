<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('students', 'tahun_ajaran')) {
            Schema::table('students', function (Blueprint $table) {
                $table->string('tahun_ajaran', 20)->nullable()->after('class_id');
                $table->index('tahun_ajaran');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('students', 'tahun_ajaran')) {
            Schema::table('students', function (Blueprint $table) {
                $table->dropIndex(['tahun_ajaran']);
                $table->dropColumn('tahun_ajaran');
            });
        }
    }
};
