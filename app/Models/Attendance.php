<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $fillable = [
        'teacher_id',
        'date',
        'check_in',
        'check_out',
        'status',
        'latitude',
        'longitude',
        'accuracy',
        'distance',
        'photo',
        'ip_address',
        'user_agent',
        'notes',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    // Status constants
    const STATUS_HADIR = 'Hadir';
    const STATUS_TERLAMBAT = 'Terlambat';
    const STATUS_PULANG = 'Pulang';
    const STATUS_IZIN = 'Izin';
    const STATUS_SAKIT = 'Sakit';
    const STATUS_ALPA = 'Alpa';

    public static function statuses(): array
    {
        return [
            self::STATUS_HADIR,
            self::STATUS_TERLAMBAT,
            self::STATUS_PULANG,
            self::STATUS_IZIN,
            self::STATUS_SAKIT,
            self::STATUS_ALPA,
        ];
    }

    /**
     * Get the teacher that owns the attendance.
     */
    public function teacher()
    {
        return $this->belongsTo(Teacher::class);
    }

    /**
     * Get status badge color.
     */
    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_HADIR => 'emerald',
            self::STATUS_TERLAMBAT => 'amber',
            self::STATUS_PULANG => 'sky',
            self::STATUS_IZIN => 'blue',
            self::STATUS_SAKIT => 'purple',
            self::STATUS_ALPA => 'rose',
            default => 'slate',
        };
    }

    /**
     * Get status emoji.
     */
    public function getStatusEmojiAttribute(): string
    {
        return match ($this->status) {
            self::STATUS_HADIR => '🟢',
            self::STATUS_TERLAMBAT => '🟡',
            self::STATUS_PULANG => '🔵',
            self::STATUS_IZIN => '🔵',
            self::STATUS_SAKIT => '🟣',
            self::STATUS_ALPA => '🔴',
            default => '⚪',
        };
    }
}
