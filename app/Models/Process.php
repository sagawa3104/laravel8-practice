<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Process extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'inspecting_forms')->as('inspectingForm')->using(InspectingForm::class);
    }

    public function parts()
    {
        return $this->belongsToMany(Part::class, 'process_part')->withPivot(['id'])->as('processPart')->using(ProcessPart::class);
    }
}
