<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SalesReturnInvoice extends Model
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
        return $this->hasMany(SalesReturnInvoiceItem::class, 'invoice_id','id')->where('line_type','item');
    }
    
    
}
