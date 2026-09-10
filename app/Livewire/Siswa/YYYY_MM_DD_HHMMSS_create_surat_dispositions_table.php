<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('surat_dispositions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('surat_id')->constrained('surats')->onDelete('cascade');
            $table->foreignId('disposed_by_user_id')->comment('User yang memberi disposisi')->constrained('users')->onDelete('cascade');
            $table->foreignId('disposed_to_user_id')->comment('User yang dituju')->constrained('users')->onDelete('cascade');
            $table->text('instruction')->comment('Instruksi disposisi');
            $table->text('notes')->nullable()->comment('Catatan tambahan');
            $table->timestamp('read_at')->nullable()->comment('Waktu dibaca oleh penerima');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('surat_dispositions');
    }
};