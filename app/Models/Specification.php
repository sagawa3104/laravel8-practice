<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Specification extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'content',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_specification')->withPivot(['id'])->as('productSpecification')->using(ProductSpecification::class);
    }
}
