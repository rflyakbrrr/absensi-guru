<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_name',
        'school_address',
        'school_logo',
        'latitude',
        'longitude',
        'radius',
        'check_in_start',
        'check_in_end',
        'late_after',
        'check_out_start',
        'check_out_end',
        'selfie_enabled',
        'gps_enabled',
        'qr_token',
        'qr_active',
        'maintenance_mode',
    ];

    protected $casts = [
        'selfie_enabled' => 'boolean',
        'gps_enabled' => 'boolean',
        'qr_active' => 'boolean',
        'maintenance_mode' => 'boolean',
        'radius' => 'integer',
    ];

    /**
     * Get singleton setting instance or create default if not exists.
     */
    public static function instance(): self
    {
        return self::firstOrCreate([], [
            'school_name' => 'SMK Negeri 1 Contoh',
            'school_address' => 'Jl. Pendidikan No. 123',
            'latitude' => -6.200000,
            'longitude' => 106.816666,
            'radius' => 100,
            'check_in_start' => '06:00',
            'check_in_end' => '08:00',
            'late_after' => '07:15',
            'check_out_start' => '14:00',
            'check_out_end' => '17:00',
            'selfie_enabled' => false,
            'gps_enabled' => true,
            'qr_active' => true,
            'maintenance_mode' => false,
        ]);
    }
}
