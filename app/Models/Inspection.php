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
}
