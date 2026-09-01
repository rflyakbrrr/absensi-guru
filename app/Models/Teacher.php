<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Teacher extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'nip', 'position', 'status'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    /**
     * Get attendances for this teacher.
     */
    public function attendances()
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Scope: only active teachers.
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}