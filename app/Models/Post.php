<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Post extends Model
{
    protected $fillable = [
        'title',
        'body',
        'post_id'
    ];
    protected $withCount = [
        'likes',
    ];

    public function comments()
    {
        return $this->hasMany(Comment::class );
    }

    protected static function booted()
    {
        // We will automatically add the user to the post when it's saved.
        static::creating(function ($post) {
            if (auth()->user()) {
                $post->user_id = auth()->id();
            }
        });
    }

    public function likes(): HasMany
    {
        return $this->hasMany(PostLike::class,'post_id');
    }

    public function isLiked(): bool
    {
        if (auth()->user()) {
            return auth()->user()->likes()->forPost($this)->count();
        }

        if (($ip = request()->ip()) && ($userAgent = request()->userAgent())) {
            return $this->likes()->forIp($ip)->forUserAgent($userAgent)->count();
        }

        return false;
    }

    public function removeLike(): bool
    {
        if (auth()->user()) {
            return auth()->user()->likes()->forPost($this)->delete();
        }

        if (($ip = request()->ip()) && ($userAgent = request()->userAgent())) {
            return $this->likes()->forIp($ip)->forUserAgent($userAgent)->delete();
        }

        return false;
    }
}
