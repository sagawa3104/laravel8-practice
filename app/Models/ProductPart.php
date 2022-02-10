<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProductPart extends Pivot
{
    //
    protected $table = 'product_part';
    public $incrementing = true;

    public function part()
    {
        return $this->belongsTo(part::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
