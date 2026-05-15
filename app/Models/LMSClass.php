<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LMSClass extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'classes';

    protected $fillable = [
        'name',
        'slug',
        'description',
        'thumbnail',
        'category',
        'level',
        'code',
        'dosen_id',
        'is_active',
    ];

    protected function casts(): array
    {
        return [
            'is_active' => 'boolean',
        ];
    }

    public function dosen()
    {
        return $this->belongsTo(User::class, 'dosen_id');
    }

    public function students()
    {
        return $this->belongsToMany(User::class, 'class_user', 'class_id', 'user_id')
            ->withPivot(['progress', 'is_active'])
            ->withTimestamps();
    }

    public function materials()
    {
        return $this->hasMany(Material::class, 'class_id');
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class, 'class_id');
    }

    public function quizzes()
    {
        return $this->hasMany(Quiz::class, 'class_id');
    }

    public function forumThreads()
    {
        return $this->hasMany(ForumThread::class, 'class_id');
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'class_id');
    }

    public function announcements()
    {
        return $this->hasMany(Announcement::class, 'class_id');
    }

    public function grades()
    {
        return $this->hasMany(Grade::class, 'class_id');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'class_id');
    }

    public function getRouteKeyName(): string
    {
        return 'slug';
    }

    public function getThumbnailUrlAttribute(): string
    {
        return $this->thumbnail ? asset('storage/'.$this->thumbnail) : 'https://ui-avatars.com/api/?name='.urlencode($this->name).'&background=6366f1&color=fff&size=200';
    }

    public function getStudentCountAttribute(): int
    {
        return $this->students()->count();
    }

    public function getMaterialCountAttribute(): int
    {
        return $this->materials()->count();
    }

    public function getAssignmentCountAttribute(): int
    {
        return $this->assignments()->count();
    }

    public function getQuizCountAttribute(): int
    {
        return $this->quizzes()->count();
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    protected static function booted(): void
    {
        static::creating(function (LMSClass $class) {
            $class->slug = str($class->name)->slug();
            $class->code = static::generateUniqueCode();
        });
    }

    private static function generateUniqueCode(): string
    {
        do {
            $code = strtoupper(substr(str_shuffle('ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 0, 3).random_int(100, 999));
        } while (static::where('code', $code)->exists());

        return $code;
    }
}
