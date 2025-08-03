<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('village_data', function (Blueprint $table) {
            $table->id();
            $table->enum('type', ['demografi', 'geografis', 'ekonomi', 'pendidikan', 'kesehatan']);
            $table->string('label');
            $table->string('value');
            $table->text('description')->nullable();
            $table->string('icon')->nullable();
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('village_data');
    }
};