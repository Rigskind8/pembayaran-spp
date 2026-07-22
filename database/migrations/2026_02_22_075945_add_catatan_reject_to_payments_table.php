<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasColumn('payments', 'catatan_reject')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->text('catatan_reject')->nullable()->after('catatan');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('payments', 'catatan_reject')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->dropColumn('catatan_reject');
            });
        }
    }
};