<?php

use App\Models\Part;
use App\Models\Product;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('品目別部位一覧', function () {
    // Arrange
    $count = 16;
    $product = Product::factory()->create();
    $parts = Part::factory()->count($count)->create();
    //品目-部位中間テーブル生成
    $partIds = $parts->pluck('id')->toArray();
    $product->parts()->attach($partIds);
    $product->refresh();

    // Act
    $res = $this->get("/products/{$product->id}/parts");

    // Assert
    $res->assertStatus(200);
    // 取得データの確認
    $res->assertViewHas('product', function($viewProduct) use($product){
        return $viewProduct->id == $product->id;
    });
    $res->assertViewHas('productParts', function($productParts) use($count){
        expect($productParts->lastPage())->toBe(2);
        return $productParts->total() == $count;
    });
});
