<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesInvoiceItemTaxGroup extends Model
{
    public function GstItem()
    {
         return $this->hasMany(SalesInvoiceItemTaxGroupItem::class,'parent_group_id','id');
     }
}
