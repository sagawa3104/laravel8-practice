<?php

use App\Models\Part;
use App\Models\Product;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('品目管理 一覧', function () {
    // Arrange
    $count = 16;
    Product::factory()->count($count)->create();

    // Act
    $res = $this->get('/products');
    $data = $res->getOriginalContent()->getData();
    $products = $data['products'];

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    // 取得データの確認
    expect($products->total())->toBe($count);
    expect($products->lastPage())->toBe(2);
});

test('品目管理 登録画面', function () {
    // Arrange

    // Act
    $res = $this->get('/products/create');

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
});

test('品目管理 登録処理_正常', function () {
    // Arrange
    $data = [
        'product_code' => 'test_code',
        'product_name' => 'test_name'
    ];
    $this->assertDatabaseMissing('products', [
        'code' => $data['product_code'],
        'name' => $data['product_name'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from('/products/create')->post('/products', $data);

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/products');
    // DBに登録されていること
    $this->assertDatabaseHas('products', [
        'code' => $data['product_code'],
        'name' => $data['product_name'],
    ]);
});

test('品目管理 登録処理_異常(バリデーション)', function () {
    // Arrange
    $data = [
        'product_code' => 'test_code',
        'product_name' => ''
    ];
    $this->assertDatabaseMissing('products', [
        'code' => $data['product_code'],
        'name' => $data['product_name'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from('/products/create')->post('/products', $data);

    // Assert
    // 自画面をリダイレクトしていること
    $res->assertRedirect('/products/create');
    // DBに登録されていないこと
    $this->assertDatabaseMissing('products', [
        'code' => $data['product_code'],
        'name' => $data['product_name'],
    ]);
});

test('品目管理 更新画面', function () {
    // Arrange
    $product = Product::factory()->create();
    // Act
    $res = $this->get("/products/{$product->id}/edit");

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
});

test('品目管理 更新処理_正常', function () {
    // Arrange
    $product = Product::factory()->create([
        'name' => 'before_test'
    ]);
    $data = [
        'product_name' => 'after_test'
    ];
    $this->assertDatabaseHas('products', [
        'code' => $product->code,
        'name' => $product->name,
    ]);
    $this->assertDatabaseMissing('products', [
        'code' => $product->code,
        'name' => $data['product_name'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/products/{$product->id}/edit")->put("/products/{$product->id}", $data);

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/products');
    // DBに更新されていること
    $this->assertDatabaseMissing('products', [
        'code' => $product->code,
        'name' => $product->name,
    ]);
    $this->assertDatabaseHas('products', [
        'code' => $product->code,
        'name' => $data['product_name'],
    ]);
});

test('品目管理 更新処理_異常(バリデーション)', function () {
    // Arrange
    $product = Product::factory()->create([
        'name' => 'before_test'
    ]);
    $data = [
        'product_name' => ''
    ];
    $this->assertDatabaseHas('products', [
        'code' => $product->code,
        'name' => $product->name,
    ]);
    $this->assertDatabaseMissing('products', [
        'code' => $product->code,
        'name' => $data['product_name'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/products/{$product->id}/edit")->put("/products/{$product->id}", $data);

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect("/products/{$product->id}/edit");
    // DBに更新されていないこと
    $this->assertDatabaseHas('products', [
        'code' => $product->code,
        'name' => $product->name,
    ]);
    $this->assertDatabaseMissing('products', [
        'code' => $product->code,
        'name' => $data['product_name'],
    ]);
});

test('品目管理 部位一覧', function () {
    // Arrange
    $product = Product::factory()->create();
    $parts = Part::factory()->count(5)->create();
    //品目-部位中間テーブル生成
    $partIds = $parts->pluck('id')->toArray();
    $product->parts()->attach($partIds);
    $product->refresh();

    // Act
    $res = $this->get("/products/{$product->id}/parts");

    // Assert
    $res->assertStatus(200);
});
