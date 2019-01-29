<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'name',
    ];


    public function user()
    {
        return $this->belongsTo('App\Models\Site\User');
    }

    public function venues()
    {
        return $this->hasMany('App\Models\Site\Venue');
    }
}
