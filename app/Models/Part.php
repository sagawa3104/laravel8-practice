<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Part extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'name',
    ];

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_part');
    }

    public function processes()
    {
        return $this->belongsToMany(Process::class, 'process_part')->as('processPart')->using(ProcessPart::class);
    }
}
