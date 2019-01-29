<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class News_category extends Model
{
    protected $fillable = [
        'title', 'slug','description',
    ];

    public function news()
    {
        return $this->hasMany('App\Models\Admin\News', 'category_id');
    }
}
