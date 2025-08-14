<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CashBillInvoice extends Model
{
    public function State()
    {
    	return $this->hasOne(GstStateMaster::class,'id','state_id');
    }
    public function Payment()
    {
    	return $this->hasOne(PaymentMethod::class,'id','payment_method_id');
    }
     public function SaleItem()
    {
        return $this->hasMany(CashBillInvoiceItem::class, 'invoice_id','id')->where('line_type','item');
    }
}
