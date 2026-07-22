<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('ujians')) {
            return;
        }

        if (! Schema::hasColumn('ujians', 'subject_id')) {
            Schema::table('ujians', function (Blueprint $table) {
                $table->foreignId('subject_id')->nullable()->after('user_id')->constrained()->nullOnDelete();
            });
        }
    }

    public function down(): void
    {
        if (! Schema::hasTable('ujians')) {
            return;
        }

        if (Schema::hasColumn('ujians', 'subject_id')) {
            Schema::table('ujians', function (Blueprint $table) {
                $table->dropConstrainedForeignId('subject_id');
            });
        }
    }
};