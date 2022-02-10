<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreMappingItemRequest;
use App\Http\Requests\UpdateMappingItemRequest;
use App\Models\MappingItem;
use App\Models\ProcessPart;

class MappingItemController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\ProcessPart  $process_part
     * @return \Illuminate\Http\Response
     */
    public function index(ProcessPart $process_part)
    {
        //
        $mappingItems = $process_part->mappingItems()->paginate(15);
        return view('mapping-items.index',[
            'processPart' => $process_part,
            'mappingItems' => $mappingItems,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param  \App\Models\ProcessPart  $process_part
     * @return \Illuminate\Http\Response
     */
    public function create(ProcessPart $process_part)
    {
        //
        return view('mapping-items.create',[
            'processPart' => $process_part,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreMappingItemRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreMappingItemRequest $request, ProcessPart $process_part)
    {
        //
        $input = $request->all();
        $process_part->mappingItems()->create([
            'code' => $input['mapping_item_code'],
            'content' => $input['mapping_item_content'],
        ]);
        return redirect(route('mapping-items.index',[
            $process_part->id
        ]));
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
     * @param  \App\Models\ProcessPart  $process_part
     * @param  \App\Models\Mapping_item  $mapping_item
     * @return \Illuminate\Http\Response
     */
    public function edit(ProcessPart $process_part, MappingItem $mapping_item)
    {
        //
        return view('mapping-items.edit',[
            'processPart' => $process_part,
            'mappingItem' => $mapping_item,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateMappingItemRequest  $request
     * @param  \App\Models\ProcessPart  $process_part
     * @param  \App\Models\MappingItem  $mapping_item
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateMappingItemRequest $request, ProcessPart $process_part, MappingItem $mapping_item)
    {
        //
        $input = $request->all();
        $mapping_item->content = $input['mapping_item_content'];
        $mapping_item->save();

        return redirect(route('mapping-items.index',[
            $process_part->id
        ]));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\ProcessPart  $process_part
     * @param  \App\Models\MappingItem  $mapping_item
     * @return \Illuminate\Http\Response
     */
    public function destroy(ProcessPart $process_part, MappingItem $mapping_item)
    {
        //
        $mapping_item->delete();

        return redirect(route('mapping-items.index',[
            $process_part->id
        ]));
    }
}
