<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreInspectionDetailRequest;
use App\Http\Requests\UpdateInspectionDetailRequest;
use App\Models\InspectionDetail;

class InspectionDetailController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreInspectionDetailRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreInspectionDetailRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\InspectionDetail  $inspectionDetail
     * @return \Illuminate\Http\Response
     */
    public function show(InspectionDetail $inspectionDetail)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\InspectionDetail  $inspectionDetail
     * @return \Illuminate\Http\Response
     */
    public function edit(InspectionDetail $inspectionDetail)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateInspectionDetailRequest  $request
     * @param  \App\Models\InspectionDetail  $inspectionDetail
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateInspectionDetailRequest $request, InspectionDetail $inspectionDetail)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\InspectionDetail  $inspectionDetail
     * @return \Illuminate\Http\Response
     */
    public function destroy(InspectionDetail $inspectionDetail)
    {
        //
    }
}
