<?php

use App\Models\Process;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('工程のリストをJSON形式で返す', function () {
    // Arrange
    $count = 16;
    Process::factory()->count($count)->create();

    // Act
    $res = $this->get('api/processes');

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
});

