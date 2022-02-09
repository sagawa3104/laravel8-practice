<?php

use App\Models\Product;
use App\Models\RecordedProduct;
use Illuminate\Database\Eloquent\Factories\Sequence;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('生産実績管理 一覧', function () {
    // Arrange
    $product = Product::factory()->create();
    $count = 16;
    RecordedProduct::factory()->count($count)->for($product)->create();

    // Act
    $res = $this->get('/recorded-products');
    $data = $res->getOriginalContent()->getData();
    $recordedProducts = $data['recordedProducts'];

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    // 取得データの確認
    expect($recordedProducts->total())->toBe($count);
    expect($recordedProducts->lastPage())->toBe(2);
});

test('生産実績管理 登録画面', function () {
    // Arrange
    $Products = Product::factory()->count(20)->create();

    // Act
    $res = $this->get('/recorded-products/create');
    $data = $res->getOriginalContent()->getData();
    $viewProducts = $data['products'];

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    expect($viewProducts)->toHaveCount($Products->count());
});

test('生産実績管理 登録処理_正常', function () {
    $product = Product::factory()->create();
    // Arrange
    $data = [
        'recorded_number' => 'RN_TEST',
        'product' => (String)$product->id,
    ];
    $this->assertDatabaseMissing('recorded_products', [
        'recorded_number' => $data['recorded_number'],
        'product_id' => (Integer)$data['product'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from('/recorded-products/create')->post('/recorded-products', $data);

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/recorded-products');
    // DBに登録されていること
    $this->assertDatabaseHas('recorded_products', [
        'recorded_number' => $data['recorded_number'],
        'product_id' => (Integer)$data['product'],
    ]);
});

test('生産実績管理 登録処理_異常(バリデーション)', function () {
    // Arrange
    $data = [
        'recorded_number' => 'RN_TEST',
        'product' => (String)0,
    ];
    $this->assertDatabaseMissing('recorded_products', [
        'recorded_number' => $data['recorded_number'],
        'product_id' => (Integer)$data['product'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from('/recorded-products/create')->post('/recorded-products', $data);

    // Assert
    // 自画面にリダイレクトしていること
    $res->assertRedirect('/recorded-products/create');
    // DBに登録されていないこと
    $this->assertDatabaseMissing('recorded_products', [
        'recorded_number' => $data['recorded_number'],
        'product_id' => (Integer)$data['product'],
    ]);
});

test('生産実績管理 更新画面', function () {
    // Arrange
    $recordedProduct = RecordedProduct::factory()->for(Product::factory()->create())->create();
    // Act
    $res = $this->get("/recorded-products/{$recordedProduct->id}/edit");

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    $res->assertViewHas('recordedProduct', function(RecordedProduct $viewRecordedProduct) use($recordedProduct){
        return $viewRecordedProduct->id === $recordedProduct->id;
    });
});

test('生産実績管理 更新処理_正常', function () {
    // Arrange
    $products = Product::factory()->count(2)->state(new Sequence(function($sequence){
        $num = $sequence->index +1;
        return [
            'code' => ($num%2 == 1)? 'before':'after'
        ];
    }))->create();

    $beforeProduct = $products->where('code', '=', 'before')->first();
    $recordedProduct = RecordedProduct::factory()->for($beforeProduct)->create([
    ]);
    $data = [
        'product' => (String)$products->where('code', '=', 'after')->first()->id,
    ];
    $this->assertDatabaseHas('recorded_products', [
        'recorded_number' => $recordedProduct->recorded_number,
        'product_id' => $recordedProduct->product_id,
    ]);
    $this->assertDatabaseMissing('recorded_products', [
        'recorded_number' => $recordedProduct->recorded_number,
        'product_id' => (Integer)$data['product'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/recorded-products/{$recordedProduct->id}/edit")->put("/recorded-products/{$recordedProduct->id}", $data);

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/recorded-products');
    // DBに更新されていること
    $this->assertDatabaseMissing('recorded_products', [
        'recorded_number' => $recordedProduct->recorded_number,
        'product_id' => $beforeProduct->id,
    ]);
    $this->assertDatabaseHas('recorded_products', [
        'recorded_number' => $recordedProduct->recorded_number,
        'product_id' => (Integer)$data['product'],
    ]);
});

test('生産実績管理 更新処理_異常(バリデーション)', function () {
    // Arrange
    $products = Product::factory()->count(2)->state(new Sequence(function($sequence){
        $num = $sequence->index +1;
        return [
            'code' => ($num%2 == 1)? 'before':'after'
        ];
    }))->create();

    $beforeProduct = $products->where('code', '=', 'before')->first();
    $recordedProduct = RecordedProduct::factory()->for($beforeProduct)->create([
    ]);
    $data = [
        'product' => (String)$products->where('code', '=', 'after')->first()->id+1,
    ];
    $this->assertDatabaseHas('recorded_products', [
        'recorded_number' => $recordedProduct->recorded_number,
        'product_id' => $recordedProduct->product_id,
    ]);
    $this->assertDatabaseMissing('recorded_products', [
        'recorded_number' => $recordedProduct->recorded_number,
        'product_id' => (Integer)$data['product'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/recorded-products/{$recordedProduct->id}/edit")->put("/recorded-products/{$recordedProduct->id}", $data);

    // Assert
    // 編集画面にリダイレクトしていること
    $res->assertRedirect("/recorded-products/{$recordedProduct->id}/edit");
    // DBに更新されていないこと
    $this->assertDatabaseHas('recorded_products', [
        'recorded_number' => $recordedProduct->recorded_number,
        'product_id' => $recordedProduct->product_id,
    ]);
    $this->assertDatabaseMissing('recorded_products', [
        'recorded_number' => $recordedProduct->recorded_number,
        'product_id' => (Integer)$data['product'],
    ]);
});

test('生産実績管理 削除処理_正常', function () {
    // Arrange
    $recordedProduct = RecordedProduct::factory()->for(Product::factory()->create())->create();
    $this->assertDatabaseHas('recorded_products', [
        'id' => $recordedProduct->id,
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/recorded-products/{$recordedProduct->id}/edit")->delete("/recorded-products/{$recordedProduct->id}");

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect("/recorded-products");
    // DBに更新されていること
    $this->assertDatabaseMissing('recorded_products', [
        'id' => $recordedProduct->id,
    ]);
});

