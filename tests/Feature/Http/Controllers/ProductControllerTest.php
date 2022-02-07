<?php

use App\Models\Part;
use App\Models\Product;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('品目管理 一覧', function () {
    // Arrange
    $count = 16;
    Product::factory()->count($count)->create();

    // Act
    $res = $this->get('/products');
    $data = $res->getOriginalContent()->getData();
    $products = $data['products'];

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    // 取得データの確認
    expect($products->total())->toBe($count);
    expect($products->lastPage())->toBe(2);
});

test('品目管理 登録画面', function () {
    // Arrange

    // Act
    $res = $this->get('/products/create');

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
});

test('品目管理 部位一覧', function () {
    // Arrange
    $product = Product::factory()->create();
    $parts = Part::factory()->count(5)->create();
    //品目-部位中間テーブル生成
    $partIds = $parts->pluck('id')->toArray();
    $product->parts()->attach($partIds);
    $product->refresh();

    // Act
    $res = $this->get("/products/{$product->id}/parts");

    // Assert
    $res->assertStatus(200);
});
