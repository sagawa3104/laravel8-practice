<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProcessPartRequest;
use App\Http\Requests\UpdateProcessPartRequest;
use App\Models\ProcessPart;

class ProcessPartController extends Controller
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
     * @param  \App\Http\Requests\StoreProcessPartRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProcessPartRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\ProcessPart  $processPart
     * @return \Illuminate\Http\Response
     */
    public function show(ProcessPart $processPart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\ProcessPart  $processPart
     * @return \Illuminate\Http\Response
     */
    public function edit(ProcessPart $processPart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateProcessPartRequest  $request
     * @param  \App\Models\ProcessPart  $processPart
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProcessPartRequest $request, ProcessPart $processPart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProcessPart  $processPart
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProcessPart $processPart)
    {
        //
    }
}
