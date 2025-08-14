<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    public function transactionItem()
    {
        
    	return $this->belongsTo(TransactionItem::class, 'id', 'transaction_id');
    }

    public function debitItem()
    {
    	return $this->hasOne(TransactionItem::class, 'transaction_id', 'id')->where('type', 'debit');
    }
    public function creditItem()
    {
    	return $this->hasOne(TransactionItem::class, 'transaction_id', 'id')->where('type', 'credit');
    }

    


    // public function expense_index($id)
    // {
    //     $transaction= TransactionItem::where('transaction_id',$id)->where('type',"debit")->first(); 
    //     $acc_id = $transaction->account_id;
    //     return $acc_id;
    // }
}
