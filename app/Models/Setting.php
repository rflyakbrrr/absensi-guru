<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'school_name',
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
     * Get singleton setting instance.
     */
    public static function instance(): self
    {
        return self::firstOrFail();
    }
}
