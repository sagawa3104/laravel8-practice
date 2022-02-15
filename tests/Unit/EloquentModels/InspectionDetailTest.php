<?php

use App\Models\Inspection;
use App\Models\InspectionDetail;
use App\Models\MappingItem;
use App\Models\Part;
use App\Models\Process;
use App\Models\Product;
use App\Models\RecordedCheckingItem;
use App\Models\RecordedMappingItem;
use App\Models\RecordedProduct;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    $product = Product::factory()->create();
    $process = Process::factory()->create();
    $part = Part::factory()->create();

    $product->parts()->attach($part->id);
    $process->parts()->attach($part->id);

    // 生産実績の作成
    $recordedProduct = RecordedProduct::factory()->for($product)->create();
    // 検査実績の作成
    $recordedProduct->processes()->attach($process->id);

});

test('検査実績モデルを取得できる', function () {
    // Arrange
    $inspection = Inspection::first();

    // Action
    $inspectionDetail = InspectionDetail::factory()->for($inspection)->create();

    // Assert
    expect($inspectionDetail->inspection)->toBeInstanceOf(Inspection::class);
});

test('マッピング項目明細モデルを取得できる', function () {
    // Arrange
    $process = Process::first();
    // 検査方式設定
    $process->products()->attach(Product::first()->id, ['form' => 'MAPPING']);
    // マッピング項目設定
    $part = Part::first();
    $process->parts()->attach($part->id);
    $processPart =  $process->parts()->find($part->id)->processPart;
    $mappingItem = MappingItem::factory()->for($processPart)->create();
    // 検査実績明細の作成
    $inspection = Inspection::first();
    InspectionDetail::factory()->for($inspection)->has(RecordedMappingItem::factory()->state([
        'mapping_item_id' => $mappingItem->id,
    ]))->create();

    // Action
    $inspection->refresh();
    $inspectionDetails = $inspection->inspectionDetails;

    // Assert
    expect($inspectionDetails)->each(function($inspectionDetail){
        $inspectionDetail->recordedMappingItem->toBeInstanceOf(RecordedMappingItem::class);
    });
});

test('チェック項目明細モデルを取得できる', function () {
    // Arrange
    $process = Process::first();
    // 検査方式設定
    $process->products()->attach(Product::first()->id, ['form' => 'CHECKLIST']);
    // チェック項目設定

    // 検査実績明細の作成
    $inspection = Inspection::first();
    InspectionDetail::factory()->for($inspection)->has(RecordedCheckingItem::factory())->create();

    // Action
    $inspection->refresh();
    $inspectionDetails = $inspection->inspectionDetails;

    // Assert
    expect($inspectionDetails)->each(function($inspectionDetail){
        $inspectionDetail->recordedCheckingItem->toBeInstanceOf(RecordedCheckingItem::class);
    });
});

test('親検査実績モデルの検査方式から適切な明細モデルを取得できる', function () {
    // Arrange
    $process = Process::first();
    // 検査方式設定
    $process->products()->attach(Product::first()->id, ['form' => 'MAPPING']);
    // マッピング項目設定
    $part = Part::first();
    $process->parts()->attach($part->id);
    $processPart =  $process->parts()->find($part->id)->processPart;
    $mappingItem = MappingItem::factory()->for($processPart)->create();
    // 検査実績明細の作成
    $inspection = Inspection::first();
    InspectionDetail::factory()->for($inspection)->has(RecordedMappingItem::factory()->state([
        'mapping_item_id' => $mappingItem->id,
    ]))->create();

    // Action
    $inspection->refresh();
    $inspectionDetails = $inspection->inspectionDetails;

    // Assert
    expect($inspectionDetails)->each(function($inspectionDetail){
        $inspectionDetail->detailItem()->toBeInstanceOf(RecordedMappingItem::class);
    });
});
