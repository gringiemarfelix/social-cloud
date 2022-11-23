<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    public function user(){
        return $this->belongsTo(User::class, 'user_id');
    }

    public function likes(){
        return $this->hasMany(PostLike::class, 'post_id')
            ->where('status', 'liked');
    }

    public function comments(){
        return $this->hasMany(PostComment::class, 'post_id');
    }

    public function share(){
        return $this->where('id', $this->share_id)->first();
    }

    public function shares(){
        return $this->hasMany(Post::class, 'share_id');
    }
        
    public function liked(){
        return $this->likes()->where('user_id', auth()->id())->exists();
    }
}
