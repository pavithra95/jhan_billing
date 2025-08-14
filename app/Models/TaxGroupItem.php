<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaxGroupItem extends Model
{
     public function taxGroup()
    {
    	return $this->hasMany(TaxGroup::class, 'tax_group_id');
    }
    public function Tax()
    {
    	return $this->hasOne(Tax::class, 'id' ,'tax_id');
    }

    public static function CheckTax($tax_group_id,$tax_id)
    {
    	$project = TaxGroupItem::where('tax_group_id',$tax_group_id)->where('tax_id',$tax_id)->count();

    	if($project=='1'){
    		return 1;
    	}else{
    		return 0;
    	}

    }


}
