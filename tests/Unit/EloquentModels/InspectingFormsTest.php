<?php

use App\Models\InspectingForm;
use App\Models\Process;
use App\Models\Product;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    //工程・品目生成
    $process = Process::factory()->create();
    $product = Product::factory()->create();
    //品目-工程中間テーブル生成
    $process->products()->attach($product->id, [ 'form' => 'CHECKLIST']);
});

test('工程モデルを取得できる', function () {
    // Arrange

    // Action
    $inspectionForm = InspectingForm::first();

    // Assert
    expect($inspectionForm->process)->toBeInstanceOf(Process::class);
});

test('品目モデルを取得できる', function () {
    // Arrange

    // Action
    $inspectionForm = InspectingForm::first();

    // Assert
    expect($inspectionForm->product)->toBeInstanceOf(Product::class);
});
