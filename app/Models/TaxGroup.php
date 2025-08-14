<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxGroup extends Model
{
    public function taxGroup()
    {
    	return $this->hasMany(TaxGroupItem::class, 'tax_group_id','id');
    }
    public function taxGroupPercent()
    {
    	return $this->hasMany(TaxGroupItem::class, 'tax_group_id','id')->sum('tax_percentage');
    }
}
