<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Link extends Model
{
    protected $appends = [
        'comment_count',
    ];

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function getCommentCountAttribute() {
        return count($this->comments);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }
}
