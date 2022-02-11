<?php

use App\Models\InspectingForm;
use App\Models\Part;
use App\Models\Process;
use App\Models\ProcessPart;
use App\Models\Product;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    Process::factory()->create();
});
test('工程に複数の品目を設定できる', function () {
    // Arrange
    $process = Process::first();
    //工程生成
    $products = Product::factory()->count(5)->create();

    //まだデータはない
    expect($process->products)->toHaveCount(0);

    // Action
    //品目-工程中間テーブル生成
    $productIds= $products->pluck('id')->toArray();
    $process->products()->attach($productIds, [
        'form' => 'CHECKLIST'
    ]);
    $process->refresh();

    // Assert
    expect($process->products)->toHaveCount(5);
    expect($process->products)->each(fn($product) => $product->inspectingForm->toBeInstanceOf(InspectingForm::class));
});

test('工程に複数の部位を設定できる', function () {
    // Arrange
    $process = Process::first();
    //工程生成
    $parts = Part::factory()->count(5)->create();

    //まだデータはない
    expect($process->parts)->toHaveCount(0);

    // Action
    //品目-工程中間テーブル生成
    $processIds= $parts->pluck('id')->toArray();
    $process->parts()->attach($processIds);
    $process->refresh();

    // Assert
    expect($process->parts)->toHaveCount(5);
    expect($process->parts)->each(fn($part) => $part->processPart->toBeInstanceOf(ProcessPart::class));
});
