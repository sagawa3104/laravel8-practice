<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InspectionDetail extends Model
{
    use HasFactory;

    public function inspection()
    {
        return $this->belongsTo(Inspection::class);
    }

    public function recordedMappingItem()
    {
        return $this->hasOne(RecordedMappingItem::class);
    }

    public function recordedCheckingItem()
    {
        return $this->hasOne(RecordedCheckingItem::class);
    }

    public function detailItem()
    {
        if($this->inspection->inspectingForm() == 'MAPPING') return $this->recordedMappingItem;
        if($this->inspection->inspectingForm() == 'CHECKLIST') return $this->recordedCheckingItem;
        return null;
    }
}
