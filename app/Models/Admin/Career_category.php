<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Career_category extends Model
{
    protected $fillable = [
        'title', 'slug','description',
    ];

    public function careers()
    {
        return $this->hasMany('App\Models\Admin\Career', 'category_id');
    }
}
