<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Accessibility extends Model
{
    //
    protected $fillable = [
        'name', 'image',
    ];

    public function spaces()
    {
        return $this->belongsToMany('App\Models\Site\Spaces','space_accessibility','accessibility_id','space_id')->withTimestamps();
    }
}
