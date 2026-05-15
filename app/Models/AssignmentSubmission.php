<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    protected $fillable = [
        'assignment_id',
        'user_id',
        'file_path',
        'notes',
        'score',
        'feedback',
        'feedback_file',
        'status',
        'submitted_at',
        'graded_at',
    ];

    protected function casts(): array
    {
        return [
            'score' => 'decimal:2',
            'submitted_at' => 'datetime',
            'graded_at' => 'datetime',
        ];
    }

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getFileUrlAttribute(): ?string
    {
        return $this->file_path ? asset('storage/'.$this->file_path) : null;
    }

    public function getFeedbackFileUrlAttribute(): ?string
    {
        return $this->feedback_file ? asset('storage/'.$this->feedback_file) : null;
    }

    public function getStatusLabelAttribute(): string
    {
        return match ($this->status) {
            'submitted' => 'Dikumpulkan',
            'late' => 'Terlambat',
            'revised' => 'Revisi',
            'graded' => 'Selesai Dinilai',
            default => 'Belum Dikerjakan',
        };
    }

    public function getStatusColorAttribute(): string
    {
        return match ($this->status) {
            'submitted' => 'yellow',
            'late' => 'red',
            'revised' => 'orange',
            'graded' => 'green',
            default => 'gray',
        };
    }

    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }
}
