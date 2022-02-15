<?php

use App\Models\InspectingForm;
use App\Models\Part;
use App\Models\Process;
use App\Models\Product;
use App\Models\ProductPart;
use App\Models\ProductSpecification;
use App\Models\RecordedProduct;
use App\Models\Specification;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);
beforeEach(function () {
    Product::factory()->create([
        'name' => 'test product',
        'code' => 'TESTPRODUCT01',
    ]);
});

test('品目に複数の工程を設定できる', function () {
    // Arrange
    $product = Product::first();
    //工程生成
    $processes = Process::factory()->count(5)->create();

    //まだデータはない
    expect($product->processes)->toHaveCount(0);

    // Action
    //品目-工程中間テーブル生成
    $processIds= $processes->pluck('id')->toArray();
    $product->processes()->attach($processIds, [
        'form' => 'MAPPING'
    ]);
    $product->refresh();

    // Assert
    expect($product->processes)->toHaveCount(5);
    expect($product->processes)->each(function($process) {
        $process->inspectingForm->toBeInstanceOf(InspectingForm::class);
        $process->inspectingForm->id->toBeInt();
        $process->inspectingForm->form->toBeString();
    });

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
    expect($product->parts)->each(function($part){
        $part->productPart->toBeInstanceOf(ProductPart::class);
        $part->productPart->id->toBeInt();
    });
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
    expect($product->specifications)->each(function($specification){
        $specification->productSpecification->toBeInstanceOf(ProductSpecification::class);
        $specification->productSpecification->id->toBeInt();
    });
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
