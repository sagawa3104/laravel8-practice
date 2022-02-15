<?php

use App\Models\Part;
use App\Models\Product;
use App\Models\ProductPart;
use App\Models\ProductSpecification;
use App\Models\Specification;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    //工程・部位生成
    $product = Product::factory()->create();
    $specification = Specification::factory()->create();
    //部位-工程中間テーブル生成
    $product->specifications()->attach($specification->id);
});

test('品目モデルを取得できる', function () {
    // Arrange

    // Action
    $productSpecification = ProductSpecification::first();

    // Assert
    expect($productSpecification->product)->toBeInstanceOf(Product::class);
});

test('仕様モデルを取得できる', function () {
    // Arrange

    // Action
    $productSpecification = ProductSpecification::first();

    // Assert
    expect($productSpecification->specification)->toBeInstanceOf(Specification::class);
});


