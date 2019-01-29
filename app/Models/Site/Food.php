<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Food extends Model
{
    protected $fillable = [
        'title', 'category_id', 'slug','image','description','status',
    ];

    public function foodCategory()
    {
        return $this->belongsTo('App\Models\Site\FoodCategory', 'category_id');
    }
}
