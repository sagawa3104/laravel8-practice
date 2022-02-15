<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    public function parts()
    {
        return $this->belongsToMany(Part::class, 'product_part')->withPivot(['id'])->as('productPart')->using(ProductPart::class);
    }

    public function processes()
    {
        return $this->belongsToMany(Process::class, 'inspecting_forms')->withPivot(['id', 'form'])->as('inspectingForm')->using(InspectingForm::class);
    }

    public function specifications()
    {
        return $this->belongsToMany(Specification::class, 'product_specification')->withPivot(['id'])->as('productSpecification')->using(ProductSpecification::class);
    }

    public function recordedProducts()
    {
        return $this->hasMany(RecordedProduct::class);
    }
}
