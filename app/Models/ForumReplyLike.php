<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ForumReplyLike extends Model
{
    protected $fillable = [
        'forum_reply_id',
        'user_id',
    ];

    public function reply()
    {
        return $this->belongsTo(ForumReply::class, 'forum_reply_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
