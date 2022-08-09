<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Comment extends Model
{
    protected $guarded = [];

    public function creator()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

}
