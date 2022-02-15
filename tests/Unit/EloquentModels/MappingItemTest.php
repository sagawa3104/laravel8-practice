<?php

use App\Models\Inspection;
use App\Models\InspectionDetail;
use App\Models\MappingItem;
use App\Models\Part;
use App\Models\Process;
use App\Models\ProcessPart;
use App\Models\Product;
use App\Models\RecordedMappingItem;
use App\Models\RecordedProduct;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('工程部位モデルを取得できる', function () {
    // Arrange
    //工程・部位生成
    $process = Process::factory()->create();
    $part = Part::factory()->create();
    //部位-工程中間テーブル生成
    $process->parts()->attach($part->id);

    // Action
    $mappgingItem = MappingItem::factory()->for(ProcessPart::first())->create();

    // Assert
    expect($mappgingItem->processPart)->toBeInstanceOf(ProcessPart::class);
});

test('マッピング項目明細モデルを複数取得できる', function () {
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
    InspectionDetail::factory()->count(5)->for($inspection)->has(RecordedMappingItem::factory()->state([
        'mapping_item_id' => $mappingItem->id,
    ]))->create();

    // Action
    $mappingItem->refresh();

    // Assert
    expect($mappingItem->recordedMappingItems)->toHaveCount(5)->each(function($recordedMappingItem){
        $recordedMappingItem->toBeInstanceOf(RecordedMappingItem::class);
    });
});


