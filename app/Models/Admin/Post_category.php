<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Post_category extends Model
{
    protected $fillable = [
        'title', 'slug','description',
    ];

    public function blog_posts()
    {
        return $this->hasMany('App\Models\Admin\Blog_post', 'category_id');
    }

}
