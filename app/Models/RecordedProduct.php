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
        return $this->belongsToMany(Process::class, 'inspections')->withPivot(['id'])->as('inspection')->using(Inspection::class);
    }

    public function specialSpecifications()
    {
        return $this->hasMany(SpecialSpecification::class);
    }

    /**
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  string  $value
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeRecordedNumber($query, $value)
    {
        return $query->where('recorded_number', $value);
    }
}
