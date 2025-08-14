<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturnInvoiceItemTaxGroup extends Model
{
     public function GstItem()
    {
         return $this->hasMany(PurchaseReturnInvoiceItemTaxGroupItem::class,'parent_group_id','id');
     }
}
