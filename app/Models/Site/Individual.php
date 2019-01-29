<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Individual extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'business_id',
    ];


    public function user()
    {
        return $this->belongsTo('App\Models\User');
    }

}
