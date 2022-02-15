<?php

use App\Models\Inspection;
use App\Models\Process;
use App\Models\Product;
use App\Models\RecordedProduct;
use App\Models\SpecialSpecification;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('生産実績モデルを取得できる', function () {
    //Arrange
    $product = Product::factory()->create();
    $recordedProduct = RecordedProduct::factory()->for($product)->create();

    // Act
    //特別仕様生成
    $specialSpecification = SpecialSpecification::factory()->for($recordedProduct)->create();

    // Assert
    expect($specialSpecification->recordedProduct)->toBeInstanceOf(RecordedProduct::class);
});
