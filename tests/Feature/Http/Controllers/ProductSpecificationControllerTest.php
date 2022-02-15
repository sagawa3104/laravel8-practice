<?php

use App\Models\Specification;
use App\Models\Product;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('品目別仕様一覧', function () {
    // Arrange
    $count = 16;
    $product = Product::factory()->create();
    $specifications = Specification::factory()->count($count)->create();
    //品目-仕様中間テーブル生成
    $specificationIds = $specifications->pluck('id')->toArray();
    $product->specifications()->attach($specificationIds);
    $product->refresh();

    // Act
    $res = $this->get("/products/{$product->id}/specifications");

    // Assert
    $res->assertStatus(200);
    // 取得データの確認
    $res->assertViewHas('product', function($viewProduct) use($product){
        return $viewProduct->id == $product->id;
    });
    $res->assertViewHas('productSpecifications', function($productSpecifications) use($count){
        expect($productSpecifications->lastPage())->toBe(2);
        return $productSpecifications->total() == $count;
    });
});
