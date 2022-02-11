<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MappingItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'content',
    ];

    public function processPart()
    {
        return $this->belongsTo(ProcessPart::class);
    }
}
