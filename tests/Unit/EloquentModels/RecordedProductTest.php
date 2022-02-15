<?php

use App\Models\Inspection;
use App\Models\Process;
use App\Models\Product;
use App\Models\RecordedProduct;
use App\Models\SpecialSpecification;

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

test('生産実績に複数の工程を設定できる', function () {
    // Arrange
    $processes = Process::factory()->count(5)->create();
    //生産実績生成
    $product = Product::factory()->create();
    $recordedProduct = RecordedProduct::factory()->for($product)->create();

    //まだデータはない
    expect($recordedProduct->processes)->toHaveCount(0);

    // Action
    //品目-工程中間テーブル生成
    $processIds= $processes->pluck('id')->toArray();
    $recordedProduct->processes()->attach($processIds);
    $recordedProduct->refresh();

    // Assert
    expect($recordedProduct->processes)->toHaveCount(5);
    expect($recordedProduct->processes)->each(function($process){
        $process->inspection->toBeInstanceOf(Inspection::class);
        $process->inspection->id->toBeInt();
    });
});

test('複数の特別仕様を取得できる', function () {
    // Arrange
    $product = Product::factory()->create();
    $recordedProduct = RecordedProduct::factory()->for($product)->create();

    // Act
    //生産実績生成
    $specialSpecification = SpecialSpecification::factory()->count(5)->for($recordedProduct)->create();

    // Assert
    expect($recordedProduct->specialSpecifications)->toHaveCount(5);
    expect($recordedProduct->specialSpecifications)->each(function($specialSpecification){
        expect($specialSpecification)->value->toBeInstanceOf(SpecialSpecification::class);
    });
});
