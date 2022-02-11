<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMappingItemRequest;
use App\Http\Requests\UpdateMappingItemRequest;
use App\Models\MappingItem;

class MappingItemController extends Controller
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
     * @param  \App\Http\Requests\StoreMappingItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMappingItemRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\MappingItem  $mappingItem
     * @return \Illuminate\Http\Response
     */
    public function show(MappingItem $mappingItem)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\MappingItem  $mappingItem
     * @return \Illuminate\Http\Response
     */
    public function edit(MappingItem $mappingItem)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMappingItemRequest  $request
     * @param  \App\Models\MappingItem  $mappingItem
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMappingItemRequest $request, MappingItem $mappingItem)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\MappingItem  $mappingItem
     * @return \Illuminate\Http\Response
     */
    public function destroy(MappingItem $mappingItem)
    {
        //
    }
}
