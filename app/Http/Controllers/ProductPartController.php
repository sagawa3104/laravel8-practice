<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductPartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        //
        $productParts = $product->parts()->paginate(15);
        return view('products.parts.index',[
            'product' => $product,
            'productParts' => $productParts,
        ]);
    }
}
