<?php

use App\Models\Product;
use App\Models\RecordedProduct;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('生産実績から品目が取得できる', function () {
    //Arrange
    $product = Product::factory()->create();
    // Act
    //生産実績生成
    $recordedProducts = RecordedProduct::factory()->count(2)->for($product)->create();

    // Assert
    $recordedProducts->each(function($recordedProduct) use($product){
        expect($recordedProduct->product->id)->toBe($product->id);
    });
});
