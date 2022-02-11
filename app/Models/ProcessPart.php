<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ProcessPart extends Pivot
{
    //
    protected $table = 'process_part';
    public $incrementing = true;

    public function process()
    {
        return $this->belongsTo(Process::class);
    }

    public function part()
    {
        return $this->belongsTo(Part::class);
    }

    public function mappingItems()
    {
        return $this->hasMany(MappingItem::class, 'process_part_id');
    }
}
