<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesInvoice extends Model
{
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    public function Payment()
    {
        return $this->hasOne(PaymentMethod::class,  'id','payment_method_id');
    }
    public function SaleItem()
    {
        return $this->hasMany(SalesInvoiceItem::class, 'sales_invoice_id','id');
    }

    
  
    
    
}
