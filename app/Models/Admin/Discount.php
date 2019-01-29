<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Discount extends Model
{
    protected $fillable = [
        'type','no_of_booking', 'discount'
    ];


    public function user()
    {
        return $this->belongsTo('App\Models\Site\User', 'category_id');
    }
}
