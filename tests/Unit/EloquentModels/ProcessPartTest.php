<?php

use App\Models\Part;
use App\Models\Process;
use App\Models\ProcessPart;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

beforeEach(function () {
    //工程・部位生成
    $process = Process::factory()->create();
    $part = Part::factory()->create();
    //部位-工程中間テーブル生成
    $process->parts()->attach($part->id);
});

test('工程モデルを取得できる', function () {
    // Arrange

    // Action
    $processPart = ProcessPart::first();

    // Assert
    expect($processPart->process)->toBeInstanceOf(Process::class);
});

test('部位モデルを取得できる', function () {
    // Arrange

    // Action
    $processPart = ProcessPart::first();

    // Assert
    expect($processPart->part)->toBeInstanceOf(Part::class);
});
