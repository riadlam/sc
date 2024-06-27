<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanTheme extends Model
{
    use HasFactory;

    protected $fillable = ['plan_id','theme_slug','status'];

    public function plan()
    {
        return $this->belongsTo(PricePlan::class,'plan_id','id');
    }
}
