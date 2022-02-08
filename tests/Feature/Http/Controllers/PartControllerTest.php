<?php

use App\Models\Part;

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

// test('部位管理 登録画面', function () {
//     // Arrange

//     // Act
//     $res = $this->get('/products/create');

//     // Assert
//     // httpステータスコードの確認
//     $res->assertStatus(200);
// });

// test('部位管理 登録処理_正常', function () {
//     // Arrange
//     $data = [
//         'product_code' => 'test_code',
//         'product_name' => 'test_name'
//     ];
//     $this->assertDatabaseMissing('products', [
//         'code' => $data['product_code'],
//         'name' => $data['product_name'],
//     ]);

//     // Act
//     // POST元URIをセットしてからPOST
//     $res = $this->from('/products/create')->post('/products', $data);

//     // Assert
//     // 一覧画面にリダイレクトしていること
//     $res->assertRedirect('/products');
//     // DBに登録されていること
//     $this->assertDatabaseHas('products', [
//         'code' => $data['product_code'],
//         'name' => $data['product_name'],
//     ]);
// });

// test('部位管理 登録処理_異常(バリデーション)', function () {
//     // Arrange
//     $data = [
//         'product_code' => 'test_code',
//         'product_name' => ''
//     ];
//     $this->assertDatabaseMissing('products', [
//         'code' => $data['product_code'],
//         'name' => $data['product_name'],
//     ]);

//     // Act
//     // POST元URIをセットしてからPOST
//     $res = $this->from('/products/create')->post('/products', $data);

//     // Assert
//     // 自画面をリダイレクトしていること
//     $res->assertRedirect('/products/create');
//     // DBに登録されていないこと
//     $this->assertDatabaseMissing('products', [
//         'code' => $data['product_code'],
//         'name' => $data['product_name'],
//     ]);
// });

// test('部位管理 更新画面', function () {
//     // Arrange
//     $product = Product::factory()->create();
//     // Act
//     $res = $this->get("/products/{$product->id}/edit");

//     // Assert
//     // httpステータスコードの確認
//     $res->assertStatus(200);
//     $res->assertViewHas('product', function(Product $viewProduct) use($product){
//         return $viewProduct->id === $product->id;
//     });
// });

// test('部位管理 更新処理_正常', function () {
//     // Arrange
//     $product = Product::factory()->create([
//         'name' => 'before_test'
//     ]);
//     $data = [
//         'product_name' => 'after_test'
//     ];
//     $this->assertDatabaseHas('products', [
//         'code' => $product->code,
//         'name' => $product->name,
//     ]);
//     $this->assertDatabaseMissing('products', [
//         'code' => $product->code,
//         'name' => $data['product_name'],
//     ]);

//     // Act
//     // POST元URIをセットしてからPOST
//     $res = $this->from("/products/{$product->id}/edit")->put("/products/{$product->id}", $data);

//     // Assert
//     // 一覧画面にリダイレクトしていること
//     $res->assertRedirect('/products');
//     // DBに更新されていること
//     $this->assertDatabaseMissing('products', [
//         'code' => $product->code,
//         'name' => $product->name,
//     ]);
//     $this->assertDatabaseHas('products', [
//         'code' => $product->code,
//         'name' => $data['product_name'],
//     ]);
// });

// test('部位管理 更新処理_異常(バリデーション)', function () {
//     // Arrange
//     $product = Product::factory()->create([
//         'name' => 'before_test'
//     ]);
//     $data = [
//         'product_name' => ''
//     ];
//     $this->assertDatabaseHas('products', [
//         'code' => $product->code,
//         'name' => $product->name,
//     ]);
//     $this->assertDatabaseMissing('products', [
//         'code' => $product->code,
//         'name' => $data['product_name'],
//     ]);

//     // Act
//     // POST元URIをセットしてからPOST
//     $res = $this->from("/products/{$product->id}/edit")->put("/products/{$product->id}", $data);

//     // Assert
//     // 編集画面にリダイレクトしていること
//     $res->assertRedirect("/products/{$product->id}/edit");
//     // DBに更新されていないこと
//     $this->assertDatabaseHas('products', [
//         'code' => $product->code,
//         'name' => $product->name,
//     ]);
//     $this->assertDatabaseMissing('products', [
//         'code' => $product->code,
//         'name' => $data['product_name'],
//     ]);
// });

// test('部位管理 削除処理_正常', function () {
//     // Arrange
//     $product = Product::factory()->create();
//     $this->assertDatabaseHas('products', [
//         'id' => $product->id,
//     ]);

//     // Act
//     // POST元URIをセットしてからPOST
//     $res = $this->from("/products/{$product->id}/edit")->delete("/products/{$product->id}");

//     // Assert
//     // 一覧画面にリダイレクトしていること
//     $res->assertRedirect("/products");
//     // DBに更新されていること
//     $this->assertDatabaseMissing('products', [
//         'id' => $product->id,
//     ]);
// });

// test('部位管理 削除処理_異常(DB整合性)', function () {
//     // Arrange
//     $product = Product::factory()->create();
//     $this->assertDatabaseHas('products', [
//         'id' => $product->id,
//     ]);

//     // Act
//     // POST元URIをセットしてからPOST
//     // $res = $this->from("/products/{$product->id}/edit")->delete("/products/{$product->id}");

//     // Assert
//     // 一覧画面にリダイレクトしていること
//     // $res->assertRedirect("/products");
//     // DBに更新されていないこと
//     $this->assertDatabaseHas('products', [
//         'id' => $product->id,
//     ]);
// });

// test('部位管理 品目一覧', function () {
//     // Arrange
//     $product = Product::factory()->create();
//     $parts = Part::factory()->count(5)->create();
//     //品目-部位中間テーブル生成
//     $partIds = $parts->pluck('id')->toArray();
//     $product->parts()->attach($partIds);
//     $product->refresh();

//     // Act
//     $res = $this->get("/products/{$product->id}/parts");

//     // Assert
//     $res->assertStatus(200);
// });
