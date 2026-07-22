<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('students', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->string('name');
            $table->string('nis')->unique();
            $table->string('class_id', 50)->nullable();
            $table->string('gender', 1)->nullable(); // 'L' atau 'P'
            $table->string('email')->unique();
            $table->timestamps();

            $table->index('class_id');
        });
    }

    public function down()
    {
        Schema::dropIfExists('students');
    }
};