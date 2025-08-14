<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashBillInvoiceItemTaxGroup extends Model
{
    public function GstItem()
    {
         return $this->hasMany(CashBillInvoiceItemTaxGroupItem::class,'parent_group_id','id');
     }
}
