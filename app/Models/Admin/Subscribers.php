<?php

namespace App\Models\Admin;

use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Model;

class Subscribers extends Model
{
    use Notifiable;
    //
    protected $table = 'subscribers';
    protected $fillable = array('email');
}
