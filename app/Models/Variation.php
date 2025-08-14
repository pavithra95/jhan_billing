<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Variation extends Model
{
    protected $fillable = ['name'];

    public function values()
    {
        return $this->hasMany(VariationValue::class);
    }
}
