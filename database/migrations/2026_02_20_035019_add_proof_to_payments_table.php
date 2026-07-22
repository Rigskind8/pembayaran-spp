<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            if (!Schema::hasColumn('payments', 'proof')) {
                $table->string('proof')->nullable()->after('amount');
            }
            if (!Schema::hasColumn('payments', 'payment_method')) {
                $table->string('payment_method')->nullable()->after('proof');
            }
            if (!Schema::hasColumn('payments', 'catatan')) {
                $table->text('catatan')->nullable()->after('payment_method');
            }
        });

        // Ubah enum status agar support pending & approved (hanya untuk MySQL)
        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            \DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM('unpaid','pending','paid','approved') DEFAULT 'unpaid'");
        }
    }

    public function down(): void
    {
        Schema::table('payments', function (Blueprint $table) {
            $table->dropColumnIfExists('proof');
            $table->dropColumnIfExists('payment_method');
            $table->dropColumnIfExists('catatan');
        });

        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            \DB::statement("ALTER TABLE payments MODIFY COLUMN status ENUM('paid','unpaid') DEFAULT 'unpaid'");
        }
    }
};