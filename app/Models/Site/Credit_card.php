<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class Credit_card extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'card_number', 'month','year', 'security_code','currency', 'first_name', 'last_name','email', 'address'
    ];


    public function user()
    {
        return $this->belongsTo('App\Models\Site\User');
    }
}
