<?php

use App\Models\MappingItem;
use App\Models\Part;
use App\Models\Process;
use App\Models\ProcessPart;

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


