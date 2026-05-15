<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ChatMessage extends Model
{
    protected $fillable = ['class_id', 'user_id', 'message'];

    public function class()
    {
        return $this->belongsTo(LMSClass::class, 'class_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
