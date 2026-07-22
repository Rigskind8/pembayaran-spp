<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('ujians')) {
            Schema::create('ujians', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained()->onDelete('cascade');
                $table->string('status')->default('pending');
                $table->string('bukti')->nullable();
                $table->text('catatan_admin')->nullable();
                $table->timestamps();
            });
            return;
        }

        if (Schema::hasColumn('ujians', 'student_id')) {
            Schema::table('ujians', function (Blueprint $table) {
                $table->dropColumn('student_id');
            });
        }

        if (Schema::hasColumn('ujians', 'type')) {
            Schema::table('ujians', function (Blueprint $table) {
                $table->dropColumn('type');
            });
        }

        if (Schema::hasColumn('ujians', 'semester')) {
            Schema::table('ujians', function (Blueprint $table) {
                $table->dropColumn('semester');
            });
        }

        if (Schema::hasColumn('ujians', 'catatan')) {
            Schema::table('ujians', function (Blueprint $table) {
                $table->dropColumn('catatan');
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('ujians');
    }
    
};