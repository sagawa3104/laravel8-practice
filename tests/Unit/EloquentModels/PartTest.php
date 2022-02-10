<?php

use App\Models\Part;
use App\Models\Process;
use App\Models\ProcessPart;
use App\Models\Product;
use App\Models\ProductPart;

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
    expect($part->products)->each(function($product){
        $product->productPart->toBeInstanceOf(ProductPart::class);
        $product->productPart->id->toBeInt();
    });
});

test('部位に複数の工程を設定できる', function () {
    // Arrange
    $part = Part::first();

    //工程生成
    $processes = Process::factory()->count(5)->create();

    //まだデータはない
    expect($part->processes)->toHaveCount(0);

    // Action
    //品目-工程中間テーブル生成
    $processIds = $processes->pluck('id')->toArray();
    $part->processes()->attach($processIds);
    $part->refresh();

    // Assert
    expect($part->processes)->toHaveCount(5);
    expect($part->processes)->each(function($process){
        $process->processPart->toBeInstanceOf(ProcessPart::class);
        $process->processPart->id->toBeInt();
    });
});
