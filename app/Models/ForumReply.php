<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ForumReply extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'forum_thread_id',
        'user_id',
        'content',
        'attachment',
        'parent_id',
    ];

    public function thread()
    {
        return $this->belongsTo(ForumThread::class, 'forum_thread_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function parent()
    {
        return $this->belongsTo(ForumReply::class, 'parent_id');
    }

    public function replies()
    {
        return $this->hasMany(ForumReply::class, 'parent_id');
    }

    public function likes()
    {
        return $this->hasMany(ForumReplyLike::class);
    }

    public function getLikeCountAttribute(): int
    {
        return $this->likes()->count();
    }

    public function getAttachmentUrlAttribute(): ?string
    {
        return $this->attachment ? asset('storage/'.$this->attachment) : null;
    }
}
