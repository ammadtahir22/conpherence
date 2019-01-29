<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Venue_category extends Model
{
    protected $fillable = [
        'user_id', 'title', 'slug', 'description',
    ];

    public function venues()
    {
        return $this->belongsToMany('App\Models\Site\Venue', 'venue_venue_category', 'category_id', 'venue_id')->withTimestamps();
    }

}
