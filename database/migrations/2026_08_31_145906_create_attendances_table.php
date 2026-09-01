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
    Schema::create('attendances', function (Blueprint $table) {
        $table->id();
        $table->foreignId('teacher_id')->constrained()->cascadeOnDelete();
        $table->date('date');
        $table->time('check_in')->nullable();
        $table->time('check_out')->nullable();
        $table->string('status'); // Hadir, Terlambat, Izin, Sakit, Alpa, Pulang
        $table->string('latitude')->nullable();
        $table->string('longitude')->nullable();
        $table->string('accuracy')->nullable();
        $table->string('distance')->nullable();
        $table->string('photo')->nullable();
        $table->string('ip_address')->nullable();
        $table->text('user_agent')->nullable();
        $table->text('notes')->nullable();
        $table->timestamps();

        // Indexing agar rekap bulanan/tahunan loadingnya cepat
        $table->index(['teacher_id', 'date']);
    });
}

public function down(): void
{
    Schema::dropIfExists('attendances');
}
};
