<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SpecialSpecification extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'content',
    ];

    public function recordedProduct()
    {
        return $this->belongsTo(RecordedProduct::class);
    }

    public function recordedCheckingItems()
    {
        return $this->morphMany(RecordedCheckingItem::class, 'itemable');
    }
}
