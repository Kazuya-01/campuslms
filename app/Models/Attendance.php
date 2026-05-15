<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    protected $fillable = [
        'class_id',
        'meeting_number',
        'date',
        'qr_code',
        'qr_expires_at',
        'dosen_id',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'date' => 'date',
            'qr_expires_at' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function class()
    {
        return $this->belongsTo(LMSClass::class, 'class_id');
    }

    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    public function records()
    {
        return $this->hasMany(AttendanceRecord::class);
    }

    public function getPresentCountAttribute(): int
    {
        return $this->records()->where('status', 'present')->count();
    }
}
