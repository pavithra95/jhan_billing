<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Vendors extends Model
{

    protected $fillable = [
        'name',
        'address',
        'phone',
        'alt_phone',
        'supplier_type',
        'company_name',
        'gst_no',
        'city',
        'state_id',
        'gst_state_id',
        'gst_state_code',
        'status',
    ];

     public function State()
    {
    	return $this->hasOne(GstStateMaster::class, 'id' , 'state_id');
    }
}
