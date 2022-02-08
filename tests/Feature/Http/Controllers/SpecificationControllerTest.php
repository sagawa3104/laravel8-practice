<?php

use App\Models\Specification;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('部位管理 一覧', function () {
    // Arrange
    $count = 16;
    Specification::factory()->count($count)->create();

    // Act
    $res = $this->get('/specifications');
    $data = $res->getOriginalContent()->getData();
    $specifications = $data['specifications'];

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    // 取得データの確認
    expect($specifications->total())->toBe($count);
    expect($specifications->lastPage())->toBe(2);
});

test('部位管理 登録画面', function () {
    // Arrange

    // Act
    $res = $this->get('/specifications/create');

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
});

test('部位管理 登録処理_正常', function () {
    // Arrange
    $data = [
        'specification_code' => 'test_code',
        'specification_name' => 'test_name'
    ];
    $this->assertDatabaseMissing('specifications', [
        'code' => $data['specification_code'],
        'name' => $data['specification_name'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from('/specifications/create')->post('/specifications', $data);

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/specifications');
    // DBに登録されていること
    $this->assertDatabaseHas('specifications', [
        'code' => $data['specification_code'],
        'name' => $data['specification_name'],
    ]);
});

test('部位管理 登録処理_異常(バリデーション)', function () {
    // Arrange
    $data = [
        'specification_code' => 'test_code',
        'specification_name' => ''
    ];
    $this->assertDatabaseMissing('specifications', [
        'code' => $data['specification_code'],
        'name' => $data['specification_name'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from('/specifications/create')->post('/specifications', $data);

    // Assert
    // 自画面をリダイレクトしていること
    $res->assertRedirect('/specifications/create');
    // DBに登録されていないこと
    $this->assertDatabaseMissing('specifications', [
        'code' => $data['specification_code'],
        'name' => $data['specification_name'],
    ]);
});

test('部位管理 更新画面', function () {
    // Arrange
    $specification = Specification::factory()->create();
    // Act
    $res = $this->get("/specifications/{$specification->id}/edit");

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    $res->assertViewHas('specification', function(Specification $viewSpecification) use($specification){
        return $viewSpecification->id === $specification->id;
    });
});

test('部位管理 更新処理_正常', function () {
    // Arrange
    $specification = Specification::factory()->create([
        'name' => 'before_test'
    ]);
    $data = [
        'specification_name' => 'after_test'
    ];
    $this->assertDatabaseHas('specifications', [
        'code' => $specification->code,
        'name' => $specification->name,
    ]);
    $this->assertDatabaseMissing('specifications', [
        'code' => $specification->code,
        'name' => $data['specification_name'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/specifications/{$specification->id}/edit")->put("/specifications/{$specification->id}", $data);

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/specifications');
    // DBに更新されていること
    $this->assertDatabaseMissing('specifications', [
        'code' => $specification->code,
        'name' => $specification->name,
    ]);
    $this->assertDatabaseHas('specifications', [
        'code' => $specification->code,
        'name' => $data['specification_name'],
    ]);
});

test('部位管理 更新処理_異常(バリデーション)', function () {
    // Arrange
    $specification = Specification::factory()->create([
        'name' => 'before_test'
    ]);
    $data = [
        'specification_name' => ''
    ];
    $this->assertDatabaseHas('specifications', [
        'code' => $specification->code,
        'name' => $specification->name,
    ]);
    $this->assertDatabaseMissing('specifications', [
        'code' => $specification->code,
        'name' => $data['specification_name'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/specifications/{$specification->id}/edit")->put("/specifications/{$specification->id}", $data);

    // Assert
    // 編集画面にリダイレクトしていること
    $res->assertRedirect("/specifications/{$specification->id}/edit");
    // DBに更新されていないこと
    $this->assertDatabaseHas('specifications', [
        'code' => $specification->code,
        'name' => $specification->name,
    ]);
    $this->assertDatabaseMissing('specifications', [
        'code' => $specification->code,
        'name' => $data['specification_name'],
    ]);
});

test('部位管理 削除処理_正常', function () {
    // Arrange
    $specification = Specification::factory()->create();
    $this->assertDatabaseHas('specifications', [
        'id' => $specification->id,
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/specifications/{$specification->id}/edit")->delete("/specifications/{$specification->id}");

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect("/specifications");
    // DBに更新されていること
    $this->assertDatabaseMissing('specifications', [
        'id' => $specification->id,
    ]);
});

// test('部位管理 削除処理_異常(DB整合性)', function () {
//     // Arrange
//     $specification = Specification::factory()->create();
//     $this->assertDatabaseHas('specifications', [
//         'id' => $specification->id,
//     ]);

//     // Act
//     // POST元URIをセットしてからPOST
//     // $res = $this->from("/specifications/{$specification->id}/edit")->delete("/specifications/{$specification->id}");

//     // Assert
//     // 一覧画面にリダイレクトしていること
//     // $res->assertRedirect("/specifications");
//     // DBに更新されていないこと
//     $this->assertDatabaseHas('specifications', [
//         'id' => $specification->id,
//     ]);
// });

// test('部位管理 品目一覧', function () {
//     // Arrange
//     $specification = Specification::factory()->create();
//     $specifications = Specification::factory()->count(5)->create();
//     //品目-部位中間テーブル生成
//     $specificationIds = $specifications->pluck('id')->toArray();
//     $specification->specifications()->attach($specificationIds);
//     $specification->refresh();

//     // Act
//     $res = $this->get("/specifications/{$specification->id}/specifications");

//     // Assert
//     $res->assertStatus(200);
// });
