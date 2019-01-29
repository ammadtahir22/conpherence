<?php

namespace App\Models\Site;

use Illuminate\Database\Eloquent\Model;

class SpaceCapacityPlan extends Model
{
    protected $fillable = [
        'space_id','sitting_plan_id','capacity'
    ];


    public function space()
    {
        return $this->belongsTo('App\Models\Site\Spaces', 'space_id');
    }

    public function sittingPlanCapacity()
    {
        return $this->belongsTo('App\Models\Site\SittingPlan', 'sitting_plan_id');
    }
}
