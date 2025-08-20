<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseReturnInvoiceItem extends Model
{
     protected $fillable = [
        'invoice_id',
        'item_id',  // Add this line
        'barcode',
        'quantity',
        'rate',
        'amount'
    ];
     public function quantity()
    {
         return $this->belongsTo(Product::class,'item_id','id')
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
     public function sales()
     {
         return $this->hasOne(PurchaseReturnInvoice::class, 'id' , 'invoice_id');
     }  
     
      public function product()
    {
         return $this->belongsTo(Product::class, 'item_id', 'id');
    }
     public function gstTax()
     {
         return $this->hasMany(PurchaseReturnInvoiceItem::class, 'invoice_id' , 'invoice_id')->where('line_type','gst_tax');
     }

      public function Gst()
    {
         return $this->hasMany(PurchaseReturnInvoiceItemTaxGroup::class,'item_id','id')->where('type', 'gst');
     }

     public function Cess()
    {
         return $this->hasMany(PurchaseReturnInvoiceItemTaxGroup::class,'item_id','id')->where('type', 'cess');
     } 

}
