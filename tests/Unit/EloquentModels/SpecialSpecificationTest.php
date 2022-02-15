<?php

use App\Models\Inspection;
use App\Models\InspectionDetail;
use App\Models\Part;
use App\Models\Process;
use App\Models\Product;
use App\Models\RecordedCheckingItem;
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

test('複数の検査実績明細CL項目を取得できる', function () {
    // Arrange
    $product = Product::factory()->create();
    $process = Process::factory()->create();

    // 生産実績の作成
    $recordedProducts = RecordedProduct::factory()->count(3)->for($product)->create();
    // 検査実績の作成
    $recordedProducts->each(function($recordedProduct) use($process) {
        SpecialSpecification::factory()->for($recordedProduct)->create();
        $recordedProduct->processes()->attach($process->id);
    });
    // 検査方式設定
    $process->products()->attach(Product::first()->id, ['form' => 'CHECKLIST']);
    // 検査実績明細の作成
    $inspections = Inspection::all();
    $specialSpecification = SpecialSpecification::first();
    $inspections->each(function($inspection) use($specialSpecification){
        InspectionDetail::factory()->for($inspection)->has(RecordedCheckingItem::factory()->for($specialSpecification, 'itemable'))->create();
    });

    // Action
    $specialSpecification->refresh();

    // Assert
    expect($specialSpecification->recordedCheckingItems)->toHaveCount(3)->each(function($recordedCheckingItem){
        $recordedCheckingItem->toBeInstanceOf(RecordedCheckingItem::class);
    });
});
