<?php

use App\Http\Requests\StoreMappingItemRequest;
use App\Models\MappingItem;
use App\Models\Part;
use App\Models\Process;
use Illuminate\Support\Facades\Validator;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('マッピング項目コードの必須違反', function () {

    // Arrange
    $data = [
        'mapping_item_code' => '',
    ];
    $request = new StoreMappingItemRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('mapping_item_code');
    expect($validator->failed()['mapping_item_code'])->toHaveKey('Required');
});

test('マッピング項目コードの最大文字列長違反', function () {

    // Arrange
    $data = [
        'mapping_item_code' => str_repeat('a', 33),
    ];
    $request = new StoreMappingItemRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('mapping_item_code');
    expect($validator->failed()['mapping_item_code'])->toHaveKey('Max');

});

test('マッピング項目コードのDBユニーク違反', function () {
    // Arrange
    $part = Part::factory()->has(Process::factory())->create();
    $processPart = $part->processes->first()->processPart;
    $data = [
        'mapping_item_code' => MappingItem::factory()->for($processPart)->create()->code,
    ];
    $request = new StoreMappingItemRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('mapping_item_code');
    expect($validator->failed()['mapping_item_code'])->toHaveKey('Unique');

});

test('マッピング項目名称の必須違反', function () {

    // Arrange
    $data = [
        'mapping_item_content' => '',
    ];
    $request = new StoreMappingItemRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('mapping_item_content');
    expect($validator->failed()['mapping_item_content'])->toHaveKey('Required');

});

test('マッピング項目名称の最大文字列長違反', function () {

    // Arrange
    $data = [
        'mapping_item_content' => str_repeat('a', 256),
    ];
    $request = new StoreMappingItemRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('mapping_item_content');
    expect($validator->failed()['mapping_item_content'])->toHaveKey('Max');

});

test('マッピング項目コード・名称の正常データ', function () {

    // Arrange
    $data = [
        'mapping_item_code' => str_repeat('a', 32),
        'mapping_item_content' => str_repeat('a', 255),
    ];
    $request = new StoreMappingItemRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeFalse();

});


