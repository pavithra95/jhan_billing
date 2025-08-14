<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesReturnInvoiceItem extends Model
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
     public function Tax()
    {
        return $this->hasOne(Tax::class,'id', 'tax_group_id');
    }
     public function CessProductTax()
     {
         return $this->hasOne(TaxGroup::class, 'id' , 'cess_tax_group_id');
     } 
     public function product()
    {
         return $this->belongsTo(Product::class, 'item_id', 'id');
    }

    public function sales()
     {
         return $this->hasOne(SalesReturnInvoice::class, 'id' , 'invoice_id');
     } 


     public function Gst()
    {
         return $this->hasMany(SalesReturnInvoiceItemTaxGroup::class,'item_id','id')->where('type', 'gst');
     }

     public function Cess()
    {
         return $this->hasMany(SalesReturnInvoiceItemTaxGroup::class,'item_id','id')->where('type', 'cess');
     }


}
