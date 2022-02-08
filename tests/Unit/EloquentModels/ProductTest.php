<?php

use App\Models\Part;
use App\Models\Product;
use App\Models\RecordedProduct;
use App\Models\Specification;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);
beforeEach(function () {
    Product::factory()->create([
        'name' => 'test product',
        'code' => 'TESTPRODUCT01',
    ]);
});

test('品目に複数の部位を設定できる', function () {
    // Arrange
    $product = Product::first();
    //部位生成
    $parts = Part::factory()->count(5)->create();

    //まだデータはない
    expect($product->parts)->toHaveCount(0);

    // Action
    //品目-部位中間テーブル生成
    $partIds= $parts->pluck('id')->toArray();
    $product->parts()->attach($partIds);
    $product->refresh();

    // Assert
    expect($product->parts)->toHaveCount(5);
});

test('品目に複数の仕様を設定できる', function () {
    // Arrange
    $product = Product::first();
    //部位生成
    $specifications = Specification::factory()->count(5)->create();

    //まだデータはない
    expect($product->specifications)->toHaveCount(0);

    // Act
    //品目-部位中間テーブル生成
    $specificationIds= $specifications->pluck('id')->toArray();
    $product->specifications()->attach($specificationIds);
    $product->refresh();

    // Assert
    expect($product->specifications)->toHaveCount(5);
});

test('品目に複数の生産実績が存在する', function () {
    // Arrange
    $product = Product::first();

    // Act
    //生産実績生成
    $recordedProducts = RecordedProduct::factory()->count(5)->for($product)->create();

    // Assert
    expect($product->recordedProducts)->toHaveCount(5);
});
