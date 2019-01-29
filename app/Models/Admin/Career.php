<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    protected $fillable = [
        'title', 'category_id', 'slug','location','description','status',
    ];


    public function career_category()
    {
        return $this->belongsTo('App\Models\Admin\Career_category', 'category_id');
    }
}
