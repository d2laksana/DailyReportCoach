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
        Schema::create('absensis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pertemuans_id')->constrained('pertemuans')->onDelete('cascade')->onUpdate('cascade');
            $table->string('siswas_id')->index();
            $table->foreign('siswas_id')->references('noIdentitas')->on('siswas')->onDelete('cascade')->onUpdate('cascade');
            $table->enum('status', ['hadir', 'alpha', 'ijin']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('absensis');
    }
};
