<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class InspectingForm extends Pivot
{
    protected $table = 'inspecting_forms';
    public $incrementing = true;
    //

    public function process()
    {
        return $this->belongsTo(Process::class);
    }
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
