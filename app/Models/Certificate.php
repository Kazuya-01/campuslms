<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'user_id',
        'class_id',
        'certificate_number',
        'issued_at',
    ];

    protected function casts(): array
    {
        return [
            'issued_at' => 'datetime',
        ];
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function class()
    {
        return $this->belongsTo(LMSClass::class, 'class_id');
    }

    protected static function booted(): void
    {
        static::creating(function (Certificate $certificate) {
            $certificate->certificate_number = 'CRT-'.now()->format('Ymd').'-'.strtoupper(substr(uniqid(), -6));
        });
    }
}
