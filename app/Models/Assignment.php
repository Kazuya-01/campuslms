<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Assignment extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'class_id',
        'title',
        'description',
        'file_path',
        'max_score',
        'deadline',
        'instructions',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'max_score' => 'decimal:2',
            'deadline' => 'datetime',
            'is_active' => 'boolean',
        ];
    }

    public function class()
    {
        return $this->belongsTo(LMSClass::class, 'class_id');
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    public function getFileUrlAttribute(): ?string
    {
        return $this->file_path ? asset('storage/'.$this->file_path) : null;
    }

    public function getStatusAttribute(): string
    {
        return $this->deadline && $this->deadline->isPast() ? 'closed' : 'open';
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
