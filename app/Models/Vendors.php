<?php

namespace App\Models;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

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
   // Vendor.php (model)
public function getSupplierTypeNamesAttribute()
{
    // decode JSON field into array
    $ids = json_decode($this->supplier_type, true);

    if (!$ids) {
        return [];
    }

    // fetch names from sub_categories table
    return DB::table('sub_categories')
        ->whereIn('id', $ids)
        ->pluck('name')
        ->toArray();
}

}