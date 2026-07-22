<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('pengumuman') && !Schema::hasColumn('pengumuman', 'views')) {
            Schema::table('pengumuman', function (Blueprint $table) {
                $table->integer('views')->default(0)->after('is_pinned');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('pengumuman') && Schema::hasColumn('pengumuman', 'views')) {
            Schema::table('pengumuman', function (Blueprint $table) {
                $table->dropColumn('views');
            });
        }
    }
};
