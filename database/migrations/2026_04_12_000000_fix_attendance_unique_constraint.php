<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropUnique(['student_id', 'date']);
            $table->unique(['student_id', 'schedule_id', 'date']);
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('attendances', function (Blueprint $table) {
            $table->dropForeign(['student_id']);
            $table->dropUnique(['student_id', 'schedule_id', 'date']);
            $table->unique(['student_id', 'date']);
            $table->foreign('student_id')->references('id')->on('students')->onDelete('cascade');
        });
    }
};
