<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductCategory extends Model
{
    public function subCategories()
{
    return $this->hasMany(SubCategory::class);
}

}
