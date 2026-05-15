<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'user_id',
        'class_id',
        'title',
        'content',
        'attachment',
        'is_pinned',
        'is_global',
    ];

    protected function casts(): array
    {
        return [
            'is_pinned' => 'boolean',
            'is_global' => 'boolean',
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

    public function scopeGlobal($query)
    {
        return $query->where('is_global', true);
    }

    public function scopeForClass($query, int $classId)
    {
        return $query->where('class_id', $classId)->orWhere('is_global', true);
    }

    public function scopePinned($query)
    {
        return $query->where('is_pinned', true);
    }

    public function getAttachmentUrlAttribute(): ?string
    {
        return $this->attachment ? asset('storage/'.$this->attachment) : null;
    }
}
