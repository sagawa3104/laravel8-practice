<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePartRequest;
use App\Http\Requests\UpdatePartRequest;
use App\Models\Part;

class PartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $parts = Part::paginate(15);

        return view('parts.index', [
            'parts' => $parts,
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexProcesses(Part $part)
    {
        //
        return view('parts.processes.index', [
            'part' => $part,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        return view('parts.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePartRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePartRequest $request)
    {
        //
        $input = $request->all();
        Part::create([
            'code' => $input['part_code'],
            'name' => $input['part_name'],
        ]);

        return redirect(route('parts.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function show(Part $part)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function edit(Part $part)
    {
        //
        return view('parts.edit', [
            'part' => $part
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePartRequest  $request
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePartRequest $request, Part $part)
    {
        //
        $input = $request->all();

        $part->name = $input['part_name'];
        $part->save();

        return redirect(route('parts.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Part  $part
     * @return \Illuminate\Http\Response
     */
    public function destroy(Part $part)
    {
        //
        $part->delete();

        return redirect(route('parts.index'));
    }
}
