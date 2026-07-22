<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('exam_questions')) {
            return;
        }

        Schema::create('exam_questions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('subject_id')->constrained()->cascadeOnDelete();
            $table->enum('type', ['uts', 'uas']);
            $table->text('question');
            $table->json('options');
            $table->enum('correct_answer', ['a', 'b', 'c', 'd']);
            $table->unsignedInteger('points')->default(10);
            $table->unsignedInteger('sort_order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index(['subject_id', 'type', 'is_active']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('exam_questions');
    }
};