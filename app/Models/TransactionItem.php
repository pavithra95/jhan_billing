<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TransactionItem extends Model
{
    public function account()
    {
    	return $this->belongsTo(Account::class, 'account_id', 'id');
    }
     public function vendor()
    {
        return $this->hasOne(Vendors::class, 'id', 'contact');
    }
}
