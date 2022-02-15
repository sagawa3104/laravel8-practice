<?php

use App\Models\Inspection;
use App\Models\InspectionDetail;
use App\Models\Process;
use App\Models\Product;
use App\Models\RecordedCheckingItem;
use App\Models\RecordedProduct;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('検査実績明細モデルを取得できる', function () {
    // Arrange
    $product = Product::factory()->create();
    $process = Process::factory()->create();
    // 生産実績の作成
    $recordedProduct = RecordedProduct::factory()->for($product)->create();
    // 検査実績の作成
    $recordedProduct->processes()->attach($process->id);
    // 検査方式設定
    $process->products()->attach(Product::first()->id, ['form' => 'CHECKLIST']);
    // 検査実績明細の作成
    $inspection = Inspection::first();
    InspectionDetail::factory()->for($inspection)->has(RecordedCheckingItem::factory())->create();

    // Action
    $recordedMappingItem = RecordedCheckingItem::first();

    // Assert
    expect($recordedMappingItem)->inspectionDetail->toBeInstanceOf(InspectionDetail::class);
});
