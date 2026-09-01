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
    Schema::create('settings', function (Blueprint $table) {
        $table->id();
        $table->string('school_name')->default('MI TARBIYAH ISLAMIYAH');
        $table->string('school_logo')->nullable();
        $table->string('latitude')->default('-6.200000');
        $table->string('longitude')->default('106.816666');
        $table->integer('radius')->default(100); // dalam meter
        $table->time('check_in_start')->default('06:00:00');
        $table->time('check_in_end')->default('07:00:00');
        $table->time('late_after')->default('07:01:00');
        $table->time('check_out_start')->default('13:00:00');
        $table->time('check_out_end')->default('16:00:00');
        $table->boolean('selfie_enabled')->default(true);
        $table->boolean('gps_enabled')->default(true);
        $table->string('qr_token')->unique(); // Token untuk keamanan QR
        $table->timestamps();
    });
}

public function down(): void
{
    Schema::dropIfExists('settings');
}
};
