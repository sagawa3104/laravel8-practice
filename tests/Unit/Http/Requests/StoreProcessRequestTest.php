<?php

use App\Http\Requests\StoreProcessRequest;
use App\Models\Process;
use Illuminate\Support\Facades\Validator;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('部位コードの必須違反', function () {

    // Arrange
    $data = [
        'process_code' => '',
    ];
    $request = new StoreProcessRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('process_code');
    expect($validator->failed()['process_code'])->toHaveKey('Required');
});

test('部位コードの最大文字列長違反', function () {

    // Arrange
    $data = [
        'process_code' => str_repeat('a', 33),
    ];
    $request = new StoreProcessRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('process_code');
    expect($validator->failed()['process_code'])->toHaveKey('Max');

});

test('部位コードのDBユニーク違反', function () {

    // Arrange
    $data = [
        'process_code' => Process::factory()->create()->code,
    ];
    $request = new StoreProcessRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('process_code');
    expect($validator->failed()['process_code'])->toHaveKey('Unique');

});

test('部位名称の必須違反', function () {

    // Arrange
    $data = [
        'process_name' => '',
    ];
    $request = new StoreProcessRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('process_name');
    expect($validator->failed()['process_name'])->toHaveKey('Required');

});

test('部位名称の最大文字列長違反', function () {

    // Arrange
    $data = [
        'process_name' => str_repeat('a', 256),
    ];
    $request = new StoreProcessRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('process_name');
    expect($validator->failed()['process_name'])->toHaveKey('Max');

});

test('部位コード・名称の正常データ', function () {

    // Arrange
    $data = [
        'process_code' => str_repeat('a', 32),
        'process_name' => str_repeat('a', 255),
    ];
    $request = new StoreProcessRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeFalse();

});


