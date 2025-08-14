<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerType extends Model
{
    // use HasFactory;

    protected $fillable = ['type_name', 'description'];
}
