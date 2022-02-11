<?php

use App\Models\InspectingForm;
use App\Models\Process;
use App\Models\Product;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('検査方式管理 一覧', function () {
    // Arrange
    $processes = Process::factory()->count(3)->create();
    $processes->each(function($process, $index){
        $products = Product::factory()->count(6)->hasAttached($process, [
            'form' => ($index+1)%2 == 1? 'MAPPING':'CHECKLIST'
            ])->create();
    });

    // Act
    $res = $this->get('/inspecting-forms');
    $data = $res->getOriginalContent()->getData();
    $inspectingForms = $data['inspectingForms'];

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    // 取得データの確認
    expect($inspectingForms->total())->toBe(18);
    expect($inspectingForms->lastPage())->toBe(2);
});

test('検査方式管理 更新画面', function () {
    // Arrange
    $processes = Process::factory()->create();
    $processes->each(function ($process) {
        $products = Product::factory()->hasAttached($process, [
            'form' => 'MAPPING'
        ])->create();
    });
    $inspectingForm = InspectingForm::first();
    // Act
    $res = $this->get("/inspecting-forms/{$inspectingForm->id}/edit");

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    $res->assertViewHas('inspectingForm', function (InspectingForm $viewInspectingForm) use ($inspectingForm) {
        return $viewInspectingForm->id === $inspectingForm->id;
    });
});

test('検査方式管理 更新処理_正常', function () {
    // Arrange
    $processes = Process::factory()->create();
    $processes->each(function ($process) {
        $products = Product::factory()->hasAttached($process, [
            'form' => 'CHECKLIST'
        ])->create();
    });
    $inspectingForm = InspectingForm::first();

    $data = [
        'form' => 'MAPPING'
    ];
    $this->assertDatabaseHas('inspecting_forms', [
        'id' => $inspectingForm->id,
        'form' => $inspectingForm->form,
    ]);
    $this->assertDatabaseMissing('inspecting_forms', [
        'id' => $inspectingForm->id,
        'form' => $data['form'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/inspecting-forms/{$inspectingForm->id}/edit")->put("/inspecting-forms/{$inspectingForm->id}", $data);

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect('/inspecting-forms');
    // DBに更新されていること
    $this->assertDatabaseMissing('inspecting_forms', [
        'id' => $inspectingForm->id,
        'form' => $inspectingForm->form,
    ]);
    $this->assertDatabaseHas('inspecting_forms', [
        'id' => $inspectingForm->id,
        'form' => $data['form'],
    ]);
});

test('検査方式管理 更新処理_異常(バリデーション)', function () {
    // Arrange
    $processes = Process::factory()->create();
    $processes->each(function ($process) {
        $products = Product::factory()->hasAttached($process, [
            'form' => 'CHECKLIST'
        ])->create();
    });
    $inspectingForm = InspectingForm::first();

    $data = [
        'form' => 'fail'
    ];
    $this->assertDatabaseHas('inspecting_forms', [
        'id' => $inspectingForm->id,
        'form' => $inspectingForm->form,
    ]);
    $this->assertDatabaseMissing('inspecting_forms', [
        'id' => $inspectingForm->id,
        'form' => $data['form'],
    ]);

    // Act
    // POST元URIをセットしてからPOST
    $res = $this->from("/inspecting-forms/{$inspectingForm->id}/edit")->put("/inspecting-forms/{$inspectingForm->id}", $data);

    // Assert
    // 一覧画面にリダイレクトしていること
    $res->assertRedirect("/inspecting-forms/{$inspectingForm->id}/edit");
    // DBに更新されていないこと
    $this->assertDatabaseHas('inspecting_forms', [
        'id' => $inspectingForm->id,
        'form' => $inspectingForm->form,
    ]);
    $this->assertDatabaseMissing('inspecting_forms', [
        'id' => $inspectingForm->id,
        'form' => $data['form'],
    ]);
});

