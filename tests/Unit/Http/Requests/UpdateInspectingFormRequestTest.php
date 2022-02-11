<?php

use App\Http\Requests\UpdateInspectingFormRequest;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('検査方式の必須違反', function () {

    // Arrange
    $data = [
        'form' => '',
    ];
    $request = new UpdateInspectingFormRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('form');
    expect($validator->failed()['form'])->toHaveKey('Required');
});

test('検査方式の違反データ', function ($form) {

    // Arrange
    $data = [
        'form' => (String)$form,
    ];
    $request = new UpdateInspectingFormRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeTrue();
    expect($validator->failed())->toHaveKey('form');
    expect($validator->failed()['form'])->toHaveKey('In');
})->with([
    'fail',
    '失敗',
    0,
]);

test('検査方式の正常データ', function ($form) {

    // Arrange
    $data = [
        'form' => $form,
    ];
    $request = new UpdateInspectingFormRequest();
    $rules = $request->rules();
    $validator = Validator::make($data, $rules);

    // Act
    $isFail = $validator->fails();

    // Assert
    expect($isFail)->toBeFalse();
})->with([
    'CHECKLIST',
    'MAPPING'
]);
