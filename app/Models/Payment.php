<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{

    public function paymentItems()
    {
        return $this->hasMany(PaymentItem::class, 'payment_id', 'id');
    }

	public function salesInvoice()
	{
		return $this->belongsTo(SalesInvoice::class, 'invoice_id', 'id');
	}
	public function purchaseInvoice()
	{
		return $this->belongsTo(PurchaseInvoice::class, 'invoice_id', 'id');
	}
	 public function purchaseInv()
    {
        return $this->hasOne(PurchaseInvoice::class, 'id', 'invoice_id');
    }

    public function salesInv()
    {
        return $this->hasOne(SalesInvoiceItem::class, 'id', 'invoice_id');
    }
    
    public function customer()
    {
         return $this->belongsTo(Customer::class , 'customer_id', 'id');
    }

    public function vendor()
    {
        return $this->belongsTo(Vendors::class , 'customer_id', 'id');
    }
}
