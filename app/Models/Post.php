<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

    protected $fillable = [ 'content', 'user_id', 'status' ];
    public function user() {
        return $this->belongsTo(User::class);
    }

    public function likes() {
        return $this->hasMany(Like::class);
    }

    public function comments() {
        return $this->hasMany(Comment::class)->whereNull('parent_id');
    }

    public function reports() {
        return $this->hasMany(Report::class);
    }

    public function rejectReason() {
        return $this->hasOne(PostRejectReason::class);
    }
}
