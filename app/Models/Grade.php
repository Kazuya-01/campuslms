<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Grade extends Model
{
    protected $fillable = [
        'user_id',
        'class_id',
        'quiz_id',
        'assignment_id',
        'type',
        'score',
        'max_score',
        'weight',
    ];

    protected function casts(): array
    {
        return [
            'score' => 'decimal:2',
            'max_score' => 'decimal:2',
            'weight' => 'decimal:2',
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

    public function quiz()
    {
        return $this->belongsTo(Quiz::class);
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function getTypeLabelAttribute(): string
    {
        return match ($this->type) {
            'quiz' => 'Quiz',
            'assignment' => 'Tugas',
            'attendance' => 'Kehadiran',
            'final' => 'Nilai Akhir',
            default => 'Unknown',
        };
    }

    public function getPercentageAttribute(): float
    {
        if ($this->max_score <= 0) {
            return 0;
        }

        return round(($this->score / $this->max_score) * 100, 2);
    }

    public function scopeQuiz($query)
    {
        return $query->where('type', 'quiz');
    }

    public function scopeAssignment($query)
    {
        return $query->where('type', 'assignment');
    }

    public function scopeFinal($query)
    {
        return $query->where('type', 'final');
    }
}
