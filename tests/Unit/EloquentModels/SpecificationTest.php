<?php

use App\Models\Inspection;
use App\Models\InspectionDetail;
use App\Models\Part;
use App\Models\Process;
use App\Models\Specification;
use App\Models\Product;
use App\Models\ProductSpecification;
use App\Models\RecordedCheckingItem;
use App\Models\RecordedProduct;
use App\Models\SpecialSpecification;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);
beforeEach(function () {
    Specification::factory()->create();
});

test('仕様に複数の品目を設定できる', function () {
    // Arrange
    $specification = Specification::first();
    //部位生成
    $products = Product::factory()->count(5)->create();

    //まだデータはない
    expect($specification->products)->toHaveCount(0);

    // Action
    //品目-部位中間テーブル生成
    $productIds= $products->pluck('id')->toArray();
    $specification->products()->attach($productIds);
    $specification->refresh();

    // Assert
    expect($specification->products)->each(function($product) {
        $product->productSpecification->toBeInstanceOf(ProductSpecification::class);
        $product->productSpecification->id->toBeInt();
    });
});

test('複数の検査実績明細CL項目を取得できる', function () {
    // Arrange
    $product = Product::factory()->create();
    $process = Process::factory()->create();
    $part = Part::factory()->create();
    $specification = Specification::first();

    $product->parts()->attach($part->id);
    $product->specifications()->attach($specification->id);
    $process->parts()->attach($part->id);

    // 生産実績の作成
    $recordedProducts = RecordedProduct::factory()->count(3)->for($product)->create();
    // 検査実績の作成
    $recordedProducts->each(function($recordedProduct) use($process) {
        $recordedProduct->processes()->attach($process->id);
    });
    // 検査方式設定
    $process->products()->attach(Product::first()->id, ['form' => 'CHECKLIST']);
    // 検査実績明細の作成
    $inspections = Inspection::all();
    $inspections->each(function($inspection) use($specification){
        InspectionDetail::factory()->for($inspection)->has(RecordedCheckingItem::factory()->for($specification, 'itemable'))->create();
    });

    // Action
    $specification->refresh();

    // Assert
    expect($specification->recordedCheckingItems)->toHaveCount(3)->each(function($recordedCheckingItem){
        $recordedCheckingItem->toBeInstanceOf(RecordedCheckingItem::class);
    });
});
