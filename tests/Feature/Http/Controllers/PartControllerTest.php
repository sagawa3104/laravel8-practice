<?php

use App\Models\Part;
use App\Models\Process;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('部位管理 一覧', function () {
    // Arrange
    $count = 16;
    Part::factory()->count($count)->create();

    // Act
    $res = $this->get('/parts');
    $data = $res->getOriginalContent()->getData();
    $parts = $data['parts'];

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    // 取得データの確認
    expect($parts->total())->toBe($count);
    expect($parts->lastPage())->toBe(2);
});

test('部位別管理 一覧', function () {
    // Arrange
    $count = 3;
    $part = Part::factory()->has(Process::factory()->count($count))->create();

    // Act
    $res = $this->get("/parts/{$part->id}/processes");

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    // 取得データの確認
    $res->assertViewHas('part', function($part) use($count) {
        return $part->processes->count() == $count;
    });
});

test('部位管理 登録画面', function () {
    // Arrange

    // Act
    $res = $this->get('/parts/create');

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
});

test('部位管理 登録処理_正常', function () {
    // Arrange
    $data = [
        'part_code' => 'test_code',
        'part_name' => 'test_name'
    ];
    $this->assertDatabaseMissing('parts', [
        'code' => $data['part_code'],
        'name' => $data['part_name'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from('/parts/create')->post('/parts', $data);

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/parts');
    // DBに登録されていること
    $this->assertDatabaseHas('parts', [
        'code' => $data['part_code'],
        'name' => $data['part_name'],
    ]);
});

test('部位管理 登録処理_異常(バリデーション)', function () {
    // Arrange
    $data = [
        'part_code' => 'test_code',
        'part_name' => ''
    ];
    $this->assertDatabaseMissing('parts', [
        'code' => $data['part_code'],
        'name' => $data['part_name'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from('/parts/create')->post('/parts', $data);

    // Assert
    // 自画面をリダイレクトしていること
    $res->assertRedirect('/parts/create');
    // DBに登録されていないこと
    $this->assertDatabaseMissing('parts', [
        'code' => $data['part_code'],
        'name' => $data['part_name'],
    ]);
});

test('部位管理 更新画面', function () {
    // Arrange
    $part = Part::factory()->create();
    // Act
    $res = $this->get("/parts/{$part->id}/edit");

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    $res->assertViewHas('part', function(Part $viewPart) use($part){
        return $viewPart->id === $part->id;
    });
});

test('部位管理 更新処理_正常', function () {
    // Arrange
    $part = Part::factory()->create([
        'name' => 'before_test'
    ]);
    $data = [
        'part_name' => 'after_test'
    ];
    $this->assertDatabaseHas('parts', [
        'code' => $part->code,
        'name' => $part->name,
    ]);
    $this->assertDatabaseMissing('parts', [
        'code' => $part->code,
        'name' => $data['part_name'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/parts/{$part->id}/edit")->put("/parts/{$part->id}", $data);

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/parts');
    // DBに更新されていること
    $this->assertDatabaseMissing('parts', [
        'code' => $part->code,
        'name' => $part->name,
    ]);
    $this->assertDatabaseHas('parts', [
        'code' => $part->code,
        'name' => $data['part_name'],
    ]);
});

test('部位管理 更新処理_異常(バリデーション)', function () {
    // Arrange
    $part = Part::factory()->create([
        'name' => 'before_test'
    ]);
    $data = [
        'part_name' => ''
    ];
    $this->assertDatabaseHas('parts', [
        'code' => $part->code,
        'name' => $part->name,
    ]);
    $this->assertDatabaseMissing('parts', [
        'code' => $part->code,
        'name' => $data['part_name'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/parts/{$part->id}/edit")->put("/parts/{$part->id}", $data);

    // Assert
    // 編集画面にリダイレクトしていること
    $res->assertRedirect("/parts/{$part->id}/edit");
    // DBに更新されていないこと
    $this->assertDatabaseHas('parts', [
        'code' => $part->code,
        'name' => $part->name,
    ]);
    $this->assertDatabaseMissing('parts', [
        'code' => $part->code,
        'name' => $data['part_name'],
    ]);
});

test('部位管理 削除処理_正常', function () {
    // Arrange
    $part = Part::factory()->create();
    $this->assertDatabaseHas('parts', [
        'id' => $part->id,
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/parts/{$part->id}/edit")->delete("/parts/{$part->id}");

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect("/parts");
    // DBに更新されていること
    $this->assertDatabaseMissing('parts', [
        'id' => $part->id,
    ]);
});

// test('部位管理 削除処理_異常(DB整合性)', function () {
//     // Arrange
//     $part = Part::factory()->create();
//     $this->assertDatabaseHas('parts', [
//         'id' => $part->id,
//     ]);

//     // Act
//     // POST元URIをセットしてからPOST
//     // $res = $this->from("/parts/{$part->id}/edit")->delete("/parts/{$part->id}");

//     // Assert
//     // 一覧画面にリダイレクトしていること
//     // $res->assertRedirect("/parts");
//     // DBに更新されていないこと
//     $this->assertDatabaseHas('parts', [
//         'id' => $part->id,
//     ]);
// });

// test('部位管理 品目一覧', function () {
//     // Arrange
//     $part = Part::factory()->create();
//     $parts = Part::factory()->count(5)->create();
//     //品目-部位中間テーブル生成
//     $partIds = $parts->pluck('id')->toArray();
//     $part->parts()->attach($partIds);
//     $part->refresh();

//     // Act
//     $res = $this->get("/parts/{$part->id}/parts");

//     // Assert
//     $res->assertStatus(200);
// });
