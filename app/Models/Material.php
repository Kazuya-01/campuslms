<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Material extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'class_id',
        'title',
        'description',
        'file_path',
        'file_type',
        'file_size',
        'video_url',
        'link_url',
        'meeting_number',
        'type',
        'order',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
            'file_size' => 'integer',
            'meeting_number' => 'integer',
            'order' => 'integer',
        ];
    }

    public function class()
    {
        return $this->belongsTo(LMSClass::class, 'class_id');
    }

    public function progress()
    {
        return $this->hasMany(MaterialProgress::class);
    }

    public function userProgress(int $userId): ?MaterialProgress
    {
        return $this->progress()->where('user_id', $userId)->first();
    }

    public function getFileUrlAttribute(): ?string
    {
        return $this->file_path ? asset('storage/' . $this->file_path) : null;
    }

    public function getFileIconAttribute(): string
    {
        return match ($this->file_type) {
            'pdf' => 'far fa-file-pdf text-red-500',
            'doc', 'docx' => 'far fa-file-word text-blue-500',
            'ppt', 'pptx' => 'far fa-file-powerpoint text-orange-500',
            'mp4', 'webm', 'ogg' => 'far fa-file-video text-purple-500',
            default => 'far fa-file text-gray-500',
        };
    }

    public function getFileSizeFormattedAttribute(): string
    {
        if (!$this->file_size) return '';
        $units = ['B', 'KB', 'MB', 'GB'];
        $size = $this->file_size;
        $i = 0;
        while ($size >= 1024 && $i < count($units) - 1) {
            $size /= 1024;
            $i++;
        }
        return round($size, 2) . ' ' . $units[$i];
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order')->orderBy('created_at');
    }
}
