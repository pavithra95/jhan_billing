<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashBillInvoiceItem extends Model
{
    public function quantity()
    {
         return $this->belongsTo(Item::class,'item_id','id')
         ->sum('quantity');
     }
      public function ProductTax()
     {
         return $this->hasOne(TaxGroup::class, 'id' , 'tax_group_id');
     } 
     public function CessProductTax()
     {
         return $this->hasOne(TaxGroup::class, 'id' , 'cess_tax_group_id');
     } 
     public function product()
    {
         return $this->belongsTo(Product::class, 'item_id', 'id');
    }
    public function Gst()
    {
         return $this->hasMany(CashBillInvoiceItemTaxGroup::class,'item_id','id')->where('type', 'gst');
     }

     public function Cess()
    {
         return $this->hasMany(CashBillInvoiceItemTaxGroup::class,'item_id','id')->where('type', 'cess');
     } 

}
