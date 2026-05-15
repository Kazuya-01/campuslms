<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Quiz extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'class_id',
        'title',
        'description',
        'time_limit',
        'max_score',
        'random_questions',
        'random_answers',
        'allow_review',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'max_score' => 'decimal:2',
            'time_limit' => 'integer',
            'random_questions' => 'boolean',
            'random_answers' => 'boolean',
            'allow_review' => 'boolean',
            'is_active' => 'boolean',
        ];
    }

    public function class()
    {
        return $this->belongsTo(LMSClass::class, 'class_id');
    }

    public function questions()
    {
        return $this->hasMany(QuizQuestion::class);
    }

    public function attempts()
    {
        return $this->hasMany(QuizAttempt::class);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
