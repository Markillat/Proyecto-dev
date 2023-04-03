<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('applicants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->foreignId('workstation_id')->nullable();
            $table->text('message')->nullable();
            $table->text('curriculum_vitae')->nullable();
            $table->enum('status_job', ['pendiente', 'enviado', 'rechazado', 'finalista'])->default('enviado');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('applicants');
    }
};
