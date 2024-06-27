<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PlanPaymentGateway extends Model
{
    use HasFactory;

    protected $fillable = ['plan_id','payment_gateway_name','status'];

    public function plan()
    {
        return $this->belongsTo(PricePlan::class,'plan_id','id');
    }
}
