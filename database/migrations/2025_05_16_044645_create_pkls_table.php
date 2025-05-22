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
        Schema::create('pkls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('gurus')->onDelete('restrict');
            $table->foreignId('industri_id')->constrained('industris')->onDelete('restrict');
            $table->foreignId('siswa_id')->constrained('siswas')->onDelete('restrict');
            $table->date('mulai');
            $table->date('selesai');
            $table->timestamps();

            $table->unique('siswa_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pkls');
    }
};
