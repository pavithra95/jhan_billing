<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseInvoiceItemTaxGroup extends Model
{
     public function GstItem()
    {
         return $this->hasMany(PurchaseInvoiceItemTaxGroupItem::class,'parent_group_id','id');
     }
}
