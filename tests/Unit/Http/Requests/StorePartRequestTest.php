<?php

use App\Http\Requests\StorePartRequest;
use App\Models\Part;
use Illuminate\Support\Facades\Validator;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('部位コードの必須違反', function () {

    // Arrange
    $data = [
        'part_code' => '',
    ];
    $request = new StorePartRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('part_code');
    expect($validator->failed()['part_code'])->toHaveKey('Required');
});

test('部位コードの最大文字列長違反', function () {

    // Arrange
    $data = [
        'part_code' => str_repeat('a', 33),
    ];
    $request = new StorePartRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('part_code');
    expect($validator->failed()['part_code'])->toHaveKey('Max');

});

test('部位コードのDBユニーク違反', function () {

    // Arrange
    $data = [
        'part_code' => Part::factory()->create()->code,
    ];
    $request = new StorePartRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('part_code');
    expect($validator->failed()['part_code'])->toHaveKey('Unique');

});

test('部位名称の必須違反', function () {

    // Arrange
    $data = [
        'part_name' => '',
    ];
    $request = new StorePartRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('part_name');
    expect($validator->failed()['part_name'])->toHaveKey('Required');

});

test('部位名称の最大文字列長違反', function () {

    // Arrange
    $data = [
        'part_name' => str_repeat('a', 256),
    ];
    $request = new StorePartRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('part_name');
    expect($validator->failed()['part_name'])->toHaveKey('Max');

});

test('部位コード・名称の正常データ', function () {

    // Arrange
    $data = [
        'part_code' => str_repeat('a', 32),
        'part_name' => str_repeat('a', 255),
    ];
    $request = new StorePartRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeFalse();

});


