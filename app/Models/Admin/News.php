<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class News extends Model
{
    protected $fillable = [
        'title', 'category_id', 'slug','image','description','status',
    ];


    public function news_category()
    {
        return $this->belongsTo('App\Models\Admin\News_category', 'category_id');
    }
}
