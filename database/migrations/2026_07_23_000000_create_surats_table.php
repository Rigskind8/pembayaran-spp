<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surats', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['masuk', 'keluar']);
            $table->string('number', 120);
            $table->date('letter_date');
            $table->string('sender', 180)->nullable();
            $table->string('recipient', 180)->nullable();
            $table->string('subject', 255);
            $table->text('description')->nullable();
            $table->enum('status', ['baru', 'diproses', 'selesai', 'arsip'])->default('baru');
            $table->string('attachment')->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['type', 'letter_date']);
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surats');
    }
};
