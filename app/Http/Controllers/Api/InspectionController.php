<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class InspectionController extends Controller
{
    //
    public function index(Request $request)
    {
        $input = $request->all();
        $inspections = Inspection::search($input)->paginate();
        $inspections->each(function($inspection){
            $inspection->form = $inspection->inspectingForm();
        });
        return $inspections;
    }

    public function show(Inspection $inspection)
    {
        $inspection->load([
            'process',
            'recordedProduct',
            'recordedProduct.product',
            'inspectionDetails',
            'inspectionDetails.recordedMappingItem',
            'inspectionDetails.recordedMappingItem.mappingItem',
            'inspectionDetails.recordedMappingItem.mappingItem.processPart',
            'inspectionDetails.recordedMappingItem.mappingItem.processPart.part',
        ]);
        return $inspection;
    }
}
