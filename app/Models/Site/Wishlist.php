<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Wishlist extends Model
{
    protected $fillable = [
        'user_id','list_name','item_id',
    ];

    public function user()
    {
        return $this->belongsTo('App\Models\Site\User');
    }
}
