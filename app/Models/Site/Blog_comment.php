<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Blog_comment extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'blog_id', 'comment', 'status'
    ];

    public function blog_post()
    {
        return $this->belongsTo('App\Models\Admin\Blog_post','blog_id');
    }

    public function user()
    {
        return $this->belongsTo('App\Models\Site\User');
    }
}
