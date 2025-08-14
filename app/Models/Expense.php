<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    public function Category()
    {
    	return $this->hasOne(ExpenseCategory::class, 'id' , 'category_id');
    }
}
