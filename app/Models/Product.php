<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function parts()
    {
        return $this->belongsToMany(Part::class, 'product_part');
    }

    public function specifications()
    {
        return $this->belongsToMany(Specification::class, 'product_specification');
    }
}
