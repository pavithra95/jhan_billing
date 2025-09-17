<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesInvoiceItem extends Model
{
    protected $fillable = [
        'sales_invoice_id',
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
         return $this->hasOne(SalesInvoice::class, 'id' , 'invoice_id');
     } 


     public function Gst()
    {
         return $this->hasMany(SalesInvoiceItemTaxGroup::class,'item_id','id')->where('type', 'gst');
     }

     public function Cess()
    {
         return $this->hasMany(SalesInvoiceItemTaxGroup::class,'item_id','id')->where('type', 'cess');
     }

     



}
