<?php

use App\Models\Inspection;
use App\Models\InspectionDetail;
use App\Models\Part;
use App\Models\Process;
use App\Models\Product;
use App\Models\RecordedCheckingItem;
use App\Models\RecordedProduct;
use App\Models\SpecialSpecification;
use App\Models\Specification;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('検査実績明細モデルを取得できる', function () {
    // Arrange
    $product = Product::factory()->create();
    $process = Process::factory()->create();
    $specification = Specification::factory()->create();
    // 生産実績の作成
    $recordedProduct = RecordedProduct::factory()->for($product)->create();
    // 検査実績の作成
    $recordedProduct->processes()->attach($process->id);
    // 検査方式設定
    $process->products()->attach(Product::first()->id, ['form' => 'CHECKLIST']);
    // 検査実績明細の作成
    $inspection = Inspection::first();
    InspectionDetail::factory()->for($inspection)->has(RecordedCheckingItem::factory()->for($specification, 'itemable'))->create();

    // Action
    $recordedCheckingItem = RecordedCheckingItem::first();

    // Assert
    expect($recordedCheckingItem)->inspectionDetail->toBeInstanceOf(InspectionDetail::class);
});

test('itemableで仕様モデルを取得できる', function () {
    // Arrange
    $product = Product::factory()->create();
    $process = Process::factory()->create();
    $part = Part::factory()->create();
    $specification = Specification::factory()->create();

    $product->parts()->attach($part->id);
    $product->specifications()->attach($specification->id);
    $process->parts()->attach($part->id);

    // 検査方式設定
    $process->products()->attach(Product::first()->id, ['form' => 'CHECKLIST']);
    // 生産実績の作成
    $recordedProduct = RecordedProduct::factory()->for($product)->create();
    // 検査実績の作成
    $recordedProduct->processes()->attach($process->id);
    // 検査実績明細の作成
    $inspection = Inspection::first();
    InspectionDetail::factory()->for($inspection)->has(RecordedCheckingItem::factory()->for($specification, 'itemable'))->create();

    // Action
    $recordedCheckingItem = RecordedCheckingItem::first();

    // Assert
    expect($recordedCheckingItem)->itemable->toBeInstanceOf(Specification::class);
});

test('itemableで特別仕様モデルを取得できる', function () {
    // Arrange
    $product = Product::factory()->create();
    $process = Process::factory()->create();
    $part = Part::factory()->create();
    $specification = Specification::factory()->create();

    $product->parts()->attach($part->id);
    $product->specifications()->attach($specification->id);
    $process->parts()->attach($part->id);
    // 検査方式設定
    $process->products()->attach(Product::first()->id, ['form' => 'CHECKLIST']);

    // 生産実績の作成
    $recordedProduct = RecordedProduct::factory()->for($product)->create();
    // 特別仕様の作成
    $specialSpecification = SpecialSpecification::factory()->for($recordedProduct)->create();
    // 検査実績の作成
    $recordedProduct->processes()->attach($process->id);

    // 検査実績明細の作成
    $inspection = Inspection::first();
    InspectionDetail::factory()->for($inspection)->has(RecordedCheckingItem::factory()->for($specialSpecification, 'itemable'))->create();

    // Action
    $recordedCheckingItem = RecordedCheckingItem::first();

    // Assert
    expect($recordedCheckingItem)->itemable->toBeInstanceOf(SpecialSpecification::class);
});
