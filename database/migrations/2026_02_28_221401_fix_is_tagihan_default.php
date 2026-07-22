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
                $table->boolean('is_tagihan')->default(false)->after('keterangan');
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('payments', 'is_tagihan')) {
            Schema::table('payments', function (Blueprint $table) {
                $table->dropColumn('is_tagihan');
            });
        }
    }
};