<?php

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('品目コードの必須違反', function () {

    // Arrange
    $data = [
        'product_code' => '',
    ];
    $request = new StoreProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('product_code');
    expect($validator->failed()['product_code'])->toHaveKey('Required');
});

test('品目コードの最大文字列長違反', function () {

    // Arrange
    $data = [
        'product_code' => str_repeat('a', 33),
    ];
    $request = new StoreProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('product_code');
    expect($validator->failed()['product_code'])->toHaveKey('Max');

});

test('品目コードのDBユニーク違反', function () {

    // Arrange
    $data = [
        'product_code' => Product::factory()->create()->code,
    ];
    $request = new StoreProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('product_code');
    expect($validator->failed()['product_code'])->toHaveKey('Unique');

});

test('品目名称の必須違反', function () {

    // Arrange
    $data = [
        'product_name' => '',
    ];
    $request = new StoreProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('product_name');
    expect($validator->failed()['product_name'])->toHaveKey('Required');

});

test('品目名称の最大文字列長違反', function () {

    // Arrange
    $data = [
        'product_name' => str_repeat('a', 256),
    ];
    $request = new StoreProductRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('product_name');
    expect($validator->failed()['product_name'])->toHaveKey('Max');

});


