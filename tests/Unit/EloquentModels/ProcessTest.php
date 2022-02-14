<?php

use App\Models\InspectingForm;
use App\Models\Inspection;
use App\Models\Part;
use App\Models\Process;
use App\Models\ProcessPart;
use App\Models\Product;
use App\Models\RecordedProduct;

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
    expect($process->products)->each(function($product) {
        $product->inspectingForm->toBeInstanceOf(InspectingForm::class);
        $product->inspectingForm->id->toBeInt();
        $product->inspectingForm->form->toBeString();
    });
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
    expect($process->parts)->each(function($part){
        $part->processPart->toBeInstanceOf(ProcessPart::class);
        $part->processPart->id->toBeInt();
    });
});

test('工程に複数の生産実績を設定できる', function () {
    // Arrange
    $process = Process::first();
    $product = Product::factory()->create();
    //生産実績生成
    $recordedProducts = RecordedProduct::factory()->count(5)->for($product)->create();

    //まだデータはない
    expect($process->recordedProducts)->toHaveCount(0);

    // Action
    //品目-工程中間テーブル生成
    $recordedProductIds= $recordedProducts->pluck('id')->toArray();
    $process->recordedProducts()->attach($recordedProductIds);
    $process->refresh();

    // Assert
    expect($process->recordedProducts)->toHaveCount(5);
    expect($process->recordedProducts)->each(function($recordedProduct){
        $recordedProduct->inspection->toBeInstanceOf(Inspection::class);
        $recordedProduct->inspection->id->toBeInt();
    });
});
