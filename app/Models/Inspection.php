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

    /**
     * 製番・工程での検索クエリ
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @param  array  $param
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeSearch($query, $param)
    {
        if(isset($param['recorded_number'])){
            $query->whereIn('recorded_product_id', RecordedProduct::recordedNumber($param['recorded_number'])->select('recorded_products.id'));
        }
        if(isset($param['process'])){
            $query->whereIn('process_id', Process::where('id', $param['process'])->select('processes.id'));
        }
        $query->with([
            'process',
            'recordedProduct',
            'recordedProduct.product'
        ]);
        return $query;
    }
}
