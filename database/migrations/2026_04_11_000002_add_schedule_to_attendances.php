<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add schedule_id dan comment ke attendances table
        Schema::table('attendances', function (Blueprint $table) {
            $table->foreignId('schedule_id')->nullable()->constrained('schedules')->onDelete('cascade')->after('student_id');
            $table->text('comment')->nullable()->after('keterangan');
            $table->dateTime('submitted_at')->nullable()->after('comment');
            $table->enum('verification_status', ['pending', 'verified', 'rejected'])->default('pending')->after('submitted_at');
            $table->text('verification_note')->nullable()->after('verification_status');
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeignIdFor('Schedule');
            $table->dropColumn(['schedule_id', 'comment', 'submitted_at', 'verification_status', 'verification_note']);
        });
    }
};
