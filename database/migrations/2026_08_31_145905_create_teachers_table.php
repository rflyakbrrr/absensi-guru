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
    Schema::create('teachers', function (Blueprint $table) {
        $table->id();
        $table->string('name');
        $table->string('nip')->nullable();
        $table->string('position')->nullable();
        $table->boolean('status')->default(true); // true = aktif, false = nonaktif
        $table->timestamps();
        
        // Indexing untuk pencarian cepat
        $table->index('name');
    });
}

public function down(): void
{
    Schema::dropIfExists('teachers');
}
};
