<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('student_id');
            $table->string('jenis_tagihan')->nullable();
            $table->string('keterangan')->nullable();
            $table->decimal('amount', 10, 2);
            $table->string('month');
            $table->year('year');
            $table->string('type')->default('Lainnya'); // SPP, UTS, UAS, Lainnya
            $table->enum('status', ['unpaid', 'pending', 'paid', 'approved'])->default('unpaid');
            $table->boolean('is_tagihan')->default(false);
            $table->string('proof')->nullable();
            $table->string('payment_method')->nullable();
            $table->text('catatan')->nullable();
            $table->string('catatan_reject')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('payments');
    }
};