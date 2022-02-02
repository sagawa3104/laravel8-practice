<?php

use App\Models\Part;
use App\Models\Product;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);
beforeEach(function () {
    Part::factory()->create();
});

test('部位に複数の品目を設定できる', function () {
    // Arrange
    $part = Part::first();
    //部位生成
    $products = Product::factory()->count(5)->create();

    //まだデータはない
    expect($part->products)->toHaveCount(0);

    // Action
    //品目-部位中間テーブル生成
    $productIds= $products->pluck('id')->toArray();
    $part->products()->attach($productIds);
    $part->refresh();

    // Assert
    expect($part->products)->toHaveCount(5);
});
