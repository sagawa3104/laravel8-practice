<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RecordedMappingItem extends Model
{
    use HasFactory;

    public function inspectionDetail()
    {
        return $this->belongsTo(InspectionDetail::class);
    }

    public function mappingItem()
    {
        return $this->belongsTo(MappingItem::class);
    }

    public function itemable()
    {
        return $this->morphTo();
    }
}
