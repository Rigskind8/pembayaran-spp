<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('nilais', function (Blueprint $table) {
            $table->id();
            $table->foreignId('student_id')->constrained()->onDelete('cascade');
            $table->foreignId('subject_id')->constrained()->onDelete('cascade');
            $table->enum('type', ['uts', 'uas']);
            $table->tinyInteger('semester'); // 1 atau 2
            $table->year('tahun');
            $table->decimal('nilai', 5, 2);  // 0.00 - 100.00
            $table->text('keterangan')->nullable();
            $table->timestamps();

            // Satu siswa tidak bisa punya nilai duplikat untuk mapel + type + semester + tahun yang sama
            $table->unique(
                ['student_id', 'subject_id', 'type', 'semester', 'tahun'],
                'nilais_unique'
            );
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('nilais');
    }
};