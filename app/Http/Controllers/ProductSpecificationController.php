<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductSpecificationController extends Controller
{
    //
        /**
     * Display a listing of the resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product)
    {
        //
        $productSpecifications = $product->specifications()->paginate(15);
        return view('products.specifications.index',[
            'product' => $product,
            'productSpecifications' => $productSpecifications,
        ]);
    }
}
