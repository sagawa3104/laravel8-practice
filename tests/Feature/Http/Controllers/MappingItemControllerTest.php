<?php

use App\Models\MappingItem;
use App\Models\Part;
use App\Models\Process;
use App\Models\ProcessPart;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('マッピング項目管理 一覧', function () {
    // Arrange
    $count = 16;
    $part = Part::factory()->has(Process::factory())->create();
    $processPart = $part->processes->first()->processPart;
    MappingItem::factory()->count($count)->for($processPart)->create();

    // Act
    $res = $this->get("/processes-parts/{$processPart->id}/mapping-items");

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    // 取得データの確認
    $res->assertViewHas('mappingItems', function($mappingItems) use($count){
        expect($mappingItems->lastPage())->toBe(2);
        return $mappingItems->total() == $count;
    });
});

test('マッピング項目管理 登録画面', function () {
    // Arrange
    $part = Part::factory()->has(Process::factory())->create();
    $processPart = $part->processes->first()->processPart;

    // Act
    $res = $this->get("/processes-parts/{$processPart->id}/mapping-items/create");

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    $res->assertViewIs('mapping-items.create');
});

test('マッピング項目管理 登録処理_正常', function () {
    // Arrange
    $part = Part::factory()->has(Process::factory())->create();
    $processPart = $part->processes->first()->processPart;
    $data = [
        'mapping_item_code' => 'test_code',
        'mapping_item_content' => 'test_content'
    ];
    $this->assertDatabaseMissing('mapping_items', [
        'process_part_id' => $processPart->id,
        'code' => $data['mapping_item_code'],
        'content' => $data['mapping_item_content'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/processes-parts/{$processPart->id}/mapping-items/create")->post("/processes-parts/{$processPart->id}/mapping-items", $data);

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect("/processes-parts/{$processPart->id}/mapping-items");
    // DBに登録されていること
    $this->assertDatabaseHas('mapping_items', [
        'process_part_id' => $processPart->id,
        'code' => $data['mapping_item_code'],
        'content' => $data['mapping_item_content'],
    ]);
});

test('マッピング項目管理 登録処理_異常(バリデーション)', function () {
    // Arrange
    $part = Part::factory()->has(Process::factory())->create();
    $processPart = $part->processes->first()->processPart;
    $data = [
        'mapping_item_code' => 'test_code',
        'mapping_item_content' => ''
    ];
    $this->assertDatabaseMissing('mapping_items', [
        'process_part_id' => $processPart->id,
        'code' => $data['mapping_item_code'],
        'content' => $data['mapping_item_content'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/processes-parts/{$processPart->id}/mapping-items/create")->post("/processes-parts/{$processPart->id}/mapping-items", $data);

    // Assert
    // 自画面をリダイレクトしていること
    $res->assertRedirect("/processes-parts/{$processPart->id}/mapping-items/create");
    // DBに登録されていないこと
    $this->assertDatabaseMissing('mapping_items', [
        'code' => $data['mapping_item_code'],
        'content' => $data['mapping_item_content'],
    ]);
});

test('マッピング項目管理 更新画面', function () {
    // Arrange
    $part = Part::factory()->has(Process::factory())->create();
    $processPart = $part->processes->first()->processPart;
    $mappingItem = MappingItem::factory()->for($processPart)->create();
    // Act
    $res = $this->get("/processes-parts/{$processPart->id}/mapping-items/{$mappingItem->id}/edit");

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    $res->assertViewHas('processPart', function(ProcessPart $viewProcessPart) use($processPart){
        return $viewProcessPart->id === $processPart->id;
    });
    $res->assertViewHas('mappingItem', function(MappingItem $viewMappingItem) use($mappingItem){
        return $viewMappingItem->id === $mappingItem->id;
    });

});

test('マッピング項目管理 更新処理_正常', function () {
    // Arrange
    $part = Part::factory()->has(Process::factory())->create();
    $processPart = $part->processes->first()->processPart;
    $mappingItem = MappingItem::factory()->for($processPart)->create(['content' => 'before']);
    $data = [
        'mapping_item_content' => 'after'
    ];
    $this->assertDatabaseMissing('mapping_items', [
        'process_part_id' => $processPart->id,
        'code' => $mappingItem->code,
        'content' => $data['mapping_item_content'],
    ]);
    $this->assertDatabaseHas('mapping_items', [
        'code' => $mappingItem->code,
        'content' => $mappingItem->content,
    ]);
    $this->assertDatabaseMissing('mapping_items', [
        'code' => $mappingItem->code,
        'content' => $data['mapping_item_content'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/processes-parts/{$processPart->id}/mapping-items/{$mappingItem->id}/edit")->put("processes-parts/{$processPart->id}/mapping-items/{$mappingItem->id}", $data);

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect("/processes-parts/{$processPart->id}/mapping-items");
    // DBに更新されていること
    $this->assertDatabaseMissing('mapping_items', [
        'code' => $mappingItem->code,
        'content' => $mappingItem->content,
    ]);
    $this->assertDatabaseHas('mapping_items', [
        'code' => $mappingItem->code,
        'content' => $data['mapping_item_content'],
    ]);
});

test('マッピング項目管理 更新処理_異常(バリデーション)', function () {
    // Arrange
    $part = Part::factory()->has(Process::factory())->create();
    $processPart = $part->processes->first()->processPart;
    $mappingItem = MappingItem::factory()->for($processPart)->create(['content' => 'before']);
    $data = [
        'mapping_item_content' => ''
    ];
    $this->assertDatabaseMissing('mapping_items', [
        'process_part_id' => $processPart->id,
        'code' => $mappingItem->code,
        'content' => $data['mapping_item_content'],
    ]);
    $this->assertDatabaseHas('mapping_items', [
        'code' => $mappingItem->code,
        'content' => $mappingItem->content,
    ]);
    $this->assertDatabaseMissing('mapping_items', [
        'code' => $mappingItem->code,
        'content' => $data['mapping_item_content'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/processes-parts/{$processPart->id}/mapping-items/{$mappingItem->id}/edit")->put("processes-parts/{$processPart->id}/mapping-items/{$mappingItem->id}", $data);

    // Assert
    // 自画面にリダイレクトしていること
    $res->assertRedirect("/processes-parts/{$processPart->id}/mapping-items/{$mappingItem->id}/edit");
    // DBに更新されていないこと
    $this->assertDatabaseHas('mapping_items', [
        'code' => $mappingItem->code,
        'content' => $mappingItem->content,
    ]);
    $this->assertDatabaseMissing('mapping_items', [
        'code' => $mappingItem->code,
        'content' => $data['mapping_item_content'],
    ]);
});

test('マッピング項目管理 削除処理_正常', function () {
    // Arrange
    $part = Part::factory()->has(Process::factory())->create();
    $processPart = $part->processes->first()->processPart;
    $mappingItem = MappingItem::factory()->for($processPart)->create();

    // Act
    // POST元URIをセットしてからDELETE
    $res = $this->from("/processes-parts/{$processPart->id}/mapping-items/{$mappingItem->id}/edit")->delete("processes-parts/{$processPart->id}/mapping-items/{$mappingItem->id}");

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect("/processes-parts/{$processPart->id}/mapping-items");
    // DBに更新されていること
    $this->assertDatabaseMissing('mapping_items', [
        'id' => $mappingItem->id,
    ]);
});

// test('マッピング項目管理 削除処理_異常(DB整合性)', function () {
//     // Arrange
//     $specification = MappingItem::factory()->create();
//     $this->assertDatabaseHas('mapping_items', [
//         'id' => $specification->id,
//     ]);

//     // Act
//     // POST元URIをセットしてからPOST
//     // $res = $this->from("/mapping-items/{$specification->id}/edit")->delete("/mapping-items/{$specification->id}");

//     // Assert
//     // 一覧画面にリダイレクトしていること
//     // $res->assertRedirect("/mapping-items");
//     // DBに更新されていないこと
//     $this->assertDatabaseHas('mapping_items', [
//         'id' => $specification->id,
//     ]);
// });

// test('マッピング項目管理 品目一覧', function () {
//     // Arrange
//     $specification = MappingItem::factory()->create();
//     $specifications = MappingItem::factory()->count(5)->create();
//     //品目-マッピング項目中間テーブル生成
//     $specificationIds = $specifications->pluck('id')->toArray();
//     $specification->specifications()->attach($specificationIds);
//     $specification->refresh();

//     // Act
//     $res = $this->get("/specifications/{$specification->id}/specifications");

//     // Assert
//     $res->assertStatus(200);
// });
