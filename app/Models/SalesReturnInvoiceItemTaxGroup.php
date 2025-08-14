<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesReturnInvoiceItemTaxGroup extends Model
{
    public function GstItem()
    {
         return $this->hasMany(SalesReturnInvoiceItemTaxGroupItem::class,'parent_group_id','id');
     }
}
