<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    //
    protected $fillable = [
        'title', 'slug','content',
    ];
}
