<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
     protected $fillable = [
        'phone',  // Add this
        'name',
        'customer_type',
        'count'
    ];
    public function State()
    {
    	return $this->hasOne(GstStateMaster::class, 'id' , 'state_id');
    }
}
