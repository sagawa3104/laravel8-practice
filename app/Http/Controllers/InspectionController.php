<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreinspectionRequest;
use App\Http\Requests\UpdateinspectionRequest;
use App\Models\inspection;

class InspectionController extends Controller
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
     * @param  \App\Http\Requests\StoreinspectionRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreinspectionRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\inspection  $inspection
     * @return \Illuminate\Http\Response
     */
    public function show(inspection $inspection)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\inspection  $inspection
     * @return \Illuminate\Http\Response
     */
    public function edit(inspection $inspection)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateinspectionRequest  $request
     * @param  \App\Models\inspection  $inspection
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateinspectionRequest $request, inspection $inspection)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\inspection  $inspection
     * @return \Illuminate\Http\Response
     */
    public function destroy(inspection $inspection)
    {
        //
    }
}
