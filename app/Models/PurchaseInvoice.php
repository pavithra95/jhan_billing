<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseInvoice extends Model
{
    public function vendor()
    {
        return $this->hasOne(Vendors::class, 'id', 'supplier_id');
    }
     public function Payment()
    {
        return $this->hasOne(PaymentMethod::class,  'id','payment_method_id');
    }
     public function PurchaseItem()
    {
        return $this->hasMany(PurchaseInvoiceItem::class, 'purchase_invoice_id','id');
    }
    
}
