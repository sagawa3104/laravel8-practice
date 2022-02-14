<?php

use App\Models\Inspection;
use App\Models\Process;
use App\Models\Product;
use App\Models\RecordedProduct;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    //工程・品目生成
    $process = Process::factory()->create();
    $product = Product::factory()->create();
    $recordedProduct = RecordedProduct::factory()->for($product)->create();
    //検査(工程-生産実績)中間テーブル生成
    $process->recordedProducts()->attach($recordedProduct->id);
});

test('工程モデルを取得できる', function () {
    // Arrange

    // Action
    $inspection = Inspection::first();

    // Assert
    expect($inspection->process)->toBeInstanceOf(Process::class);
});

test('生産実績モデルを取得できる', function () {
    // Arrange

    // Action
    $inspection = Inspection::first();

    // Assert
    expect($inspection->recordedProduct)->toBeInstanceOf(RecordedProduct::class);
});
