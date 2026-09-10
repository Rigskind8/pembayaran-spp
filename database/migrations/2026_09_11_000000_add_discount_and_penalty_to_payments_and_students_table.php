<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('students', function (Blueprint $table) {
            if (!Schema::hasColumn('students', 'beasiswa_type')) {
                $table->string('beasiswa_type')->default('reguler')->after('email');
            }
            if (!Schema::hasColumn('students', 'potongan_spp')) {
                $table->decimal('potongan_spp', 10, 2)->default(0.00)->after('beasiswa_type');
            }
        });

        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'original_amount')) {
                $table->decimal('original_amount', 10, 2)->nullable()->after('amount');
            }
            if (!Schema::hasColumn('payments', 'discount_amount')) {
                $table->decimal('discount_amount', 10, 2)->default(0.00)->after('original_amount');
            }
            if (!Schema::hasColumn('payments', 'penalty_amount')) {
                $table->decimal('penalty_amount', 10, 2)->default(0.00)->after('discount_amount');
            }
            if (!Schema::hasColumn('payments', 'discount_reason')) {
                $table->string('discount_reason')->nullable()->after('penalty_amount');
            }
            if (!Schema::hasColumn('payments', 'due_date')) {
                $table->date('due_date')->nullable()->after('year');
            }
        });
    }

    public function down(): void
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn(['beasiswa_type', 'potongan_spp']);
        });

        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumn(['original_amount', 'discount_amount', 'penalty_amount', 'discount_reason', 'due_date']);
        });
    }
};

