<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model
{
    public function vendor()
    {
        return $this->hasOne(Vendors::class, 'id', 'vendor_id');
    }
     public function Payment()
    {
        return $this->hasOne(PaymentMethod::class,  'id','payment_method_id');
    }
     public function SaleItem()
    {
        return $this->hasMany(PurchaseInvoiceItem::class, 'invoice_id','id')->where('line_type','item');
    }
    
    
}
