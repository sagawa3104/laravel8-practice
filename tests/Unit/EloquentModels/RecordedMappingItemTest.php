<?php

use App\Models\Inspection;
use App\Models\InspectionDetail;
use App\Models\MappingItem;
use App\Models\Part;
use App\Models\Process;
use App\Models\Product;
use App\Models\RecordedMappingItem;
use App\Models\RecordedProduct;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('検査実績明細モデルを取得できる', function () {
    // Arrange
    $product = Product::factory()->create();
    $process = Process::factory()->create();
    $part = Part::factory()->create();
    $product->parts()->attach($part->id);
    $process->parts()->attach($part->id);
    // 生産実績の作成
    $recordedProduct = RecordedProduct::factory()->for($product)->create();
    // 検査実績の作成
    $recordedProduct->processes()->attach($process->id);
    // 検査方式設定
    $process->products()->attach(Product::first()->id, ['form' => 'MAPPING']);
    // マッピング項目設定
    $process->parts()->attach($part->id);
    $processPart =  $process->parts()->find($part->id)->processPart;
    $mappingItem = MappingItem::factory()->for($processPart)->create();
    // 検査実績明細の作成
    $inspection = Inspection::first();
    InspectionDetail::factory()->for($inspection)->has(RecordedMappingItem::factory()->state([
        'mapping_item_id' => $mappingItem->id,
    ]))->create();

    // Action
    $recordedMappingItem = RecordedMappingItem::first();

    // Assert
    expect($recordedMappingItem)->inspectionDetail->toBeInstanceOf(InspectionDetail::class);
});

