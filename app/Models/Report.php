<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Report extends Model
{
   public function accountTotal()		
    {
    	return $this->hasMany(TransactionItem::class, 'account_id', 'id')->where('type','debit');
    }
}
