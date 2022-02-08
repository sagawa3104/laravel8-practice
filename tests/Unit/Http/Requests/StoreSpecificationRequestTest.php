<?php

use App\Http\Requests\StoreSpecificationRequest;
use App\Models\Specification;
use Illuminate\Support\Facades\Validator;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('仕様コードの必須違反', function () {

    // Arrange
    $data = [
        'specification_code' => '',
    ];
    $request = new StoreSpecificationRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('specification_code');
    expect($validator->failed()['specification_code'])->toHaveKey('Required');
});

test('仕様コードの最大文字列長違反', function () {

    // Arrange
    $data = [
        'specification_code' => str_repeat('a', 33),
    ];
    $request = new StoreSpecificationRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('specification_code');
    expect($validator->failed()['specification_code'])->toHaveKey('Max');

});

test('仕様コードのDBユニーク違反', function () {

    // Arrange
    $data = [
        'specification_code' => Specification::factory()->create()->code,
    ];
    $request = new StoreSpecificationRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('specification_code');
    expect($validator->failed()['specification_code'])->toHaveKey('Unique');

});

test('仕様名称の必須違反', function () {

    // Arrange
    $data = [
        'specification_content' => '',
    ];
    $request = new StoreSpecificationRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('specification_content');
    expect($validator->failed()['specification_content'])->toHaveKey('Required');

});

test('仕様名称の最大文字列長違反', function () {

    // Arrange
    $data = [
        'specification_content' => str_repeat('a', 256),
    ];
    $request = new StoreSpecificationRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('specification_content');
    expect($validator->failed()['specification_content'])->toHaveKey('Max');

});

test('仕様コード・名称の正常データ', function () {

    // Arrange
    $data = [
        'specification_code' => str_repeat('a', 32),
        'specification_content' => str_repeat('a', 255),
    ];
    $request = new StoreSpecificationRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeFalse();

});


