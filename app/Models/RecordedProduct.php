<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordedProduct extends Model
{
    use HasFactory;

    protected $fillable = [
        'recorded_number',
        'product_id',
        'is_inspected',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function processes()
    {
        return $this->belongsToMany(Process::class, 'inspections')->as('inspection')->using(Inspection::class);
    }
}
