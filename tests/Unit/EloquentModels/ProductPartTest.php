<?php

use App\Models\Part;
use App\Models\Product;
use App\Models\ProductPart;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    //工程・部位生成
    $product = Product::factory()->create();
    $part = Part::factory()->create();
    //部位-工程中間テーブル生成
    $product->parts()->attach($part->id);
});

test('品目モデルを取得できる', function () {
    // Arrange

    // Action
    $productPart = ProductPart::first();

    // Assert
    expect($productPart->product)->toBeInstanceOf(Product::class);
});

test('部位モデルを取得できる', function () {
    // Arrange

    // Action
    $productPart = ProductPart::first();

    // Assert
    expect($productPart->part)->toBeInstanceOf(Part::class);
});


