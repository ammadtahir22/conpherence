<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class SpacesType extends Model
{
    //
    protected $fillable = [
        'user_id', 'title', 'slug', 'image', 'description'
    ];

    public function spaces()
    {
        return $this->belongsToMany('App\Models\Site\Spaces', 'spaces_spaces_types', 'space_type_id', 'space_id')->withTimestamps();
    }

}
