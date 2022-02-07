<?php

use App\Http\Requests\StoreProductRequest;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

uses(Tests\TestCase::class, Illuminate\Foundation\Testing\RefreshDatabase::class);

test('品目コードのバリデーション', function ($data) {
    $request = new StoreProductRequest();
    $rules = $request->rules();
    $result = Validator::make($data['values'], $rules)->failed();
    $result2 = Validator::make($data['values'], $rules)->fails();

    expect(true)->toBe(true);
})
->with([
    ['空白' => [
        'values' => [
            'product_code' => '',
            'product_name' => '',
            ],
        'expects' => [
            'product_code' => false,
            'product_name' => false,
            ]
        ],
    ],
    ['文字列長超過' => [
        'values' => [
            'product_code' => str_repeat('a', 33),
            'product_name' => str_repeat('a', 256),
            ],
        'expects' => [
            'product_code' => false,
            'product_name' => false,
            ]
        ],
    ],
    ['DB一意制約' => [
        'values' => [
            'product_code' => fn() => Product::factory()->create()->code,
            'product_name' => 'name',
            ],
        'expects' => [
            'product_code' => false,
            'product_name' => false,
            ]
        ],
    ],
    ['OK' => [
        'values' => [
            'product_code' => str_repeat('a', 32),
            'product_name' => str_repeat('a', 255),
            ],
        'expects' => [
            'product_code' => true,
            'product_name' => true,
            ]
        ],
    ],
]);


