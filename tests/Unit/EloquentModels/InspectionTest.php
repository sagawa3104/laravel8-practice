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

test('検査実績明細モデルを複数取得できる', function () {
    // Arrange
    $process = Process::first();
    $process->products()->attach(Product::first()->id, ['form' => 'CHECKLIST']);
    // Action
    $inspection = Inspection::first();

    // Assert
    expect($inspection->recordedProduct)->toBeInstanceOf(RecordedProduct::class);
});


test('検査方式を取得できる', function () {
    // Arrange
    $process = Process::first();
    $process->products()->attach(Product::first()->id, ['form' => 'CHECKLIST']);
    // Action
    $inspection = Inspection::first();

    // Assert
    expect($inspection->inspectingForm())->toBe('CHECKLIST');
});


test('指定した製番と工程の検査モデルを取得できる', function () {
    // Arrange
    $process = Process::first();
    $process->products()->attach(Product::first()->id, ['form' => 'CHECKLIST']);
    //
    $target = 'target';
    $product = Product::first();
    $process->recordedProducts()->attach(RecordedProduct::factory()->for($product)->create([
        'recorded_number' => $target,
    ])->id);
    $param = [
        'process' => $process->id,
        'recorded_number' => $target
    ];
    // Action
    $inspections = Inspection::search($param)->get();

    // Assert
    expect($inspections)->each(function($inspection) use($param) {
        $inspection->recordedProduct->recorded_number->toBe($param['recorded_number']);
        $inspection->process->id->toBe($param['process']);
    });
});


