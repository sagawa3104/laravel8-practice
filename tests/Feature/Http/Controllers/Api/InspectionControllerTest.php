<?php

use App\Models\Inspection;
use App\Models\MappingItem;
use App\Models\Part;
use App\Models\Process;
use App\Models\Product;
use App\Models\RecordedProduct;
use Illuminate\Database\Eloquent\Collection;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('指定した条件に合致する検査をJSON形式で返す', function () {
    // Arrange
    $process = Process::factory()->create();
    $product = Product::factory()->create();
    $recordedProducts = RecordedProduct::factory()->count(16)->for($product)->create();
    $process->products()->attach($product->id, ['form' => 'MAPPING']);
    $recordedProducts->each(function($recordedProduct) use($process) {
        $recordedProduct->processes()->attach($process->id);
    });

    // Act
    $res = $this->get('api/inspections');

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
});

