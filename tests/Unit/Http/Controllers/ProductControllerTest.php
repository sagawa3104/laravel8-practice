<?php

use App\Models\Part;
use App\Models\Product;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('品目管理 一覧', function () {
    // Arrange
    Product::factory()->create();

    // Act
    $res = $this->get('/products');

    // Assert
    $res->assertStatus(200);
});

test('品目管理 部位一覧', function () {
    // Arrange
    $product = Product::factory()->create();
    $parts = Part::factory()->count(5)->create();
    //品目-部位中間テーブル生成
    $partIds= $parts->pluck('id')->toArray();
    $product->parts()->attach($partIds);
    $product->refresh();

    // Act
    $res = $this->get("/products/{$product->id}/parts");

    // Assert
    $res->assertStatus(200);
});
