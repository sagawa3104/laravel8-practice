<?php

use App\Http\Requests\StoreRecordedProductRequest;
use App\Models\Product;
use App\Models\RecordedProduct;
use Illuminate\Support\Facades\Validator;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('製造番号の必須違反', function () {

    // Arrange
    $data = [
        'recorded_number' => '',
    ];
    $request = new StoreRecordedProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('recorded_number');
    expect($validator->failed()['recorded_number'])->toHaveKey('Required');
});

test('製造番号の最大文字列長違反', function () {

    // Arrange
    $data = [
        'recorded_number' => str_repeat('a', 33),
    ];
    $request = new StoreRecordedProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('recorded_number');
    expect($validator->failed()['recorded_number'])->toHaveKey('Max');

});

test('製造番号のDBユニーク違反', function () {

    // Arrange
    $data = [
        'recorded_number' => RecordedProduct::factory()->for(Product::factory()->create())->create()->recorded_number,
    ];
    $request = new StoreRecordedProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('recorded_number');
    expect($validator->failed()['recorded_number'])->toHaveKey('Unique');

});

test('品目IDの必須違反', function () {

    // Arrange
    $data = [
        'product' => '',
    ];
    $request = new StoreRecordedProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('product');
    expect($validator->failed()['product'])->toHaveKey('Required');

});

test('品目IDが存在していない', function () {

    // Arrange
    $data = [
        'product' => '0',
    ];
    $request = new StoreRecordedProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('product');
    expect($validator->failed()['product'])->toHaveKey('Exists');

});

test('製造番号・品目IDの正常データ', function () {

    // Arrange
    $data = [
        'recorded_number' => str_repeat('a', 32),
        'product' => (String)Product::factory()->create()->id,
    ];
    $request = new StoreRecordedProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeFalse();

});


