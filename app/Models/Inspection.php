<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Inspection extends Pivot
{
    //
    protected $table = 'inspections';

    public function recordedProduct()
    {
        return $this->belongsTo(RecordedProduct::class);
    }

    public function process()
    {
        return $this->belongsTo(Process::class);
    }

    public function inspectionDetails()
    {
        return $this->hasMany(InspectionDetail::class, 'inspection_id');
    }

    public function inspectingForm()
    {
        $product = $this->recordedProduct->product;
        return $this->process->products()->find($product->id)->inspectingForm->form;
    }
}
