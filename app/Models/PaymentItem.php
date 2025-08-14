<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PaymentItem extends Model
{
    
    public function salesInvoice()
    {
    	return $this->belongsTo(SalesInvoice::class ,'invoice_id' , 'id');
    }
	public function purchaseInvoice()
    {
    	return $this->belongsTo(PurchaseInvoice::class ,'invoice_id' , 'id');
    }

}
