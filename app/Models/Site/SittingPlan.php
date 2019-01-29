<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class SittingPlan extends Model
{
    //
    protected $fillable = [
        'title', 'image'
    ];

    public function spaces()
    {
        return $this->belongsToMany('App\Models\Site\Spaces','space_sitting_plan','sitting_plan_id','space_id')->withTimestamps();
    }

    public function sittingPlanCapacity()
    {
        return $this->hasMany('App\Models\Site\SpaceCapacityPlan', 'sitting_plan_id');
    }
}
