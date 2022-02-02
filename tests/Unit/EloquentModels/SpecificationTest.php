<?php

use App\Models\Specification;
use App\Models\Product;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);
beforeEach(function () {
    Specification::factory()->create();
});

test('仕様に複数の品目を設定できる', function () {
    // Arrange
    $specification = Specification::first();
    //部位生成
    $products = Product::factory()->count(5)->create();

    //まだデータはない
    expect($specification->products)->toHaveCount(0);

    // Action
    //品目-部位中間テーブル生成
    $productIds= $products->pluck('id')->toArray();
    $specification->products()->attach($productIds);
    $specification->refresh();

    // Assert
    expect($specification->products)->toHaveCount(5);
});
