<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreRecordedProductRequest;
use App\Http\Requests\UpdateRecordedProductRequest;
use App\Models\Product;
use App\Models\RecordedProduct;

class RecordedProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $recordedProducts = RecordedProduct::paginate(15);
        return view('recorded-products.index', [
            'recordedProducts' => $recordedProducts
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
        $products = Product::all();
        return view('recorded-products.create', [
            'products' => $products,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreRecordedProductRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRecordedProductRequest $request)
    {
        //
        $input = $request->all();

        $product = Product::find($input['product']);

        $product->recordedProducts()->create([
            'recorded_number' => $input['recorded_number'],
            'is_inspected' => false,
        ]);


        return redirect(route('recorded-products.index'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\RecordedProduct  $recordedProduct
     * @return \Illuminate\Http\Response
     */
    public function show(RecordedProduct $recordedProduct)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\RecordedProduct  $recorded_product
     * @return \Illuminate\Http\Response
     */
    public function edit(RecordedProduct $recorded_product)
    {
        //
        $products = Product::all();
        return view('recorded-products.edit', [
            'recordedProduct' => $recorded_product,
            'products' => $products,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateRecordedProductRequest  $request
     * @param  \App\Models\RecordedProduct  $recorded_product
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRecordedProductRequest $request, RecordedProduct $recorded_product)
    {
        //
        $input = $request->all();
        $product = Product::find($input['product']);

        $recorded_product->product()->associate($product);
        $recorded_product->save();

        return redirect(route('recorded-products.index'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\RecordedProduct  $recorded_product
     * @return \Illuminate\Http\Response
     */
    public function destroy(RecordedProduct $recorded_product)
    {
        //
        $recorded_product->delete();

        return redirect(route('recorded-products.index'));
    }
}