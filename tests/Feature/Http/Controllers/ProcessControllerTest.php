<?php

use App\Models\Process;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('工程管理 一覧', function () {
    // Arrange
    $count = 16;
    Process::factory()->count($count)->create();

    // Act
    $res = $this->get('/processes');
    $data = $res->getOriginalContent()->getData();
    $processes = $data['processes'];

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    // 取得データの確認
    expect($processes->total())->toBe($count);
    expect($processes->lastPage())->toBe(2);
});

test('工程管理 登録画面', function () {
    // Arrange

    // Act
    $res = $this->get('/processes/create');

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
});

test('工程管理 登録処理_正常', function () {
    // Arrange
    $data = [
        'process_code' => 'test_code',
        'process_name' => 'test_name'
    ];
    $this->assertDatabaseMissing('processes', [
        'code' => $data['process_code'],
        'name' => $data['process_name'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from('/processes/create')->post('/processes', $data);

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/processes');
    // DBに登録されていること
    $this->assertDatabaseHas('processes', [
        'code' => $data['process_code'],
        'name' => $data['process_name'],
    ]);
});

test('工程管理 登録処理_異常(バリデーション)', function () {
    // Arrange
    $data = [
        'process_code' => 'test_code',
        'process_name' => ''
    ];
    $this->assertDatabaseMissing('processes', [
        'code' => $data['process_code'],
        'name' => $data['process_name'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from('/processes/create')->post('/processes', $data);

    // Assert
    // 自画面をリダイレクトしていること
    $res->assertRedirect('/processes/create');
    // DBに登録されていないこと
    $this->assertDatabaseMissing('processes', [
        'code' => $data['process_code'],
        'name' => $data['process_name'],
    ]);
});

test('工程管理 更新画面', function () {
    // Arrange
    $process = Process::factory()->create();
    // Act
    $res = $this->get("/processes/{$process->id}/edit");

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    $res->assertViewHas('process', function(Process $viewProcess) use($process){
        return $viewProcess->id === $process->id;
    });
});

test('工程管理 更新処理_正常', function () {
    // Arrange
    $process = Process::factory()->create([
        'name' => 'before_test'
    ]);
    $data = [
        'process_name' => 'after_test'
    ];
    $this->assertDatabaseHas('processes', [
        'code' => $process->code,
        'name' => $process->name,
    ]);
    $this->assertDatabaseMissing('processes', [
        'code' => $process->code,
        'name' => $data['process_name'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/processes/{$process->id}/edit")->put("/processes/{$process->id}", $data);

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/processes');
    // DBに更新されていること
    $this->assertDatabaseMissing('processes', [
        'code' => $process->code,
        'name' => $process->name,
    ]);
    $this->assertDatabaseHas('processes', [
        'code' => $process->code,
        'name' => $data['process_name'],
    ]);
});

test('工程管理 更新処理_異常(バリデーション)', function () {
    // Arrange
    $process = Process::factory()->create([
        'name' => 'before_test'
    ]);
    $data = [
        'process_name' => ''
    ];
    $this->assertDatabaseHas('processes', [
        'code' => $process->code,
        'name' => $process->name,
    ]);
    $this->assertDatabaseMissing('processes', [
        'code' => $process->code,
        'name' => $data['process_name'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/processes/{$process->id}/edit")->put("/processes/{$process->id}", $data);

    // Assert
    // 編集画面にリダイレクトしていること
    $res->assertRedirect("/processes/{$process->id}/edit");
    // DBに更新されていないこと
    $this->assertDatabaseHas('processes', [
        'code' => $process->code,
        'name' => $process->name,
    ]);
    $this->assertDatabaseMissing('processes', [
        'code' => $process->code,
        'name' => $data['process_name'],
    ]);
});

test('工程管理 削除処理_正常', function () {
    // Arrange
    $process = Process::factory()->create();
    $this->assertDatabaseHas('processes', [
        'id' => $process->id,
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/processes/{$process->id}/edit")->delete("/processes/{$process->id}");

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect("/processes");
    // DBに更新されていること
    $this->assertDatabaseMissing('processes', [
        'id' => $process->id,
    ]);
});

// test('工程管理 削除処理_異常(DB整合性)', function () {
//     // Arrange
//     $process = Process::factory()->create();
//     $this->assertDatabaseHas('processes', [
//         'id' => $process->id,
//     ]);

//     // Act
//     // POST元URIをセットしてからPOST
//     // $res = $this->from("/processes/{$process->id}/edit")->delete("/processes/{$process->id}");

//     // Assert
//     // 一覧画面にリダイレクトしていること
//     // $res->assertRedirect("/processes");
//     // DBに更新されていないこと
//     $this->assertDatabaseHas('processes', [
//         'id' => $process->id,
//     ]);
// });

// test('工程管理 品目一覧', function () {
//     // Arrange
//     $process = Process::factory()->create();
//     $processes = Process::factory()->count(5)->create();
//     //品目-工程中間テーブル生成
//     $processIds = $processes->pluck('id')->toArray();
//     $process->processes()->attach($processIds);
//     $process->refresh();

//     // Act
//     $res = $this->get("/processes/{$process->id}/processes");

//     // Assert
//     $res->assertStatus(200);
// });
