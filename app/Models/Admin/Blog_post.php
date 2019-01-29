<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Blog_post extends Model
{
    protected $fillable = [
        'title', 'category_id', 'slug','image','description','status',
    ];


    public function post_category()
    {
        return $this->belongsTo('App\Models\Admin\Post_category', 'category_id');
    }

    public function blog_comments()
    {
        return $this->hasMany('App\Models\Site\Blog_comment','blog_id');
    }

}
