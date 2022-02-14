<?php

use App\Models\Inspection;
use App\Models\MappingItem;
use App\Models\Part;
use App\Models\Process;
use App\Models\Product;
use App\Models\RecordedProduct;
use Illuminate\Database\Eloquent\Collection;

uses(Illuminate\Foundation\Testing\RefreshDatabase::class);

test('検査実績管理 一覧', function () {
    // Arrange
    $process = Process::factory()->create();
    $product = Product::factory()->create();
    $recordedProducts = RecordedProduct::factory()->count(16)->for($product)->create();
    $process->products()->attach($product->id, ['form' => 'MAPPING']);
    $recordedProducts->each(function($recordedProduct) use($process) {
        $recordedProduct->processes()->attach($process->id);
    });

    // Act
    $res = $this->get('/inspections');

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    // 取得データの確認
    $res->assertViewHas('inspections', function($inspections){

        expect($inspections->total())->toBe(16);
        return $inspections->lastPage() == 2;
    });
});

test('検査方式管理 更新画面', function () {
    // Arrange
    $process = Process::factory()->create();
    $product = Product::factory()->create();
    $parts = Part::factory()->count(3)->create();
    $parts->each(function($part) use($process, $product){
        $part->processes()->attach($process->id);
        MappingItem::factory()->count(3)->for($part->processes()->find($process->id)->processPart)->create();

        $part->products()->attach($product->id);
    });
    $recordedProduct = RecordedProduct::factory()->for($product)->create();
    $process->products()->attach($product->id, ['form' => 'MAPPING']);
    $recordedProduct->processes()->attach($process->id);
    $inspection = $recordedProduct->processes()->find($process->id)->inspection;

    // Act
    $res = $this->get("/inspections/{$inspection->id}/edit");

    // Assert
    // httpステータスコードの確認
    $res->assertStatus(200);
    $res->assertViewHas('inspection', function (Inspection $viewInspection) use ($inspection) {
        return $viewInspection->id === $inspection->id;
    });
    $res->assertViewHas('parts', function (Collection $viewParts) use ($parts) {
        expect($viewParts->count())->toBe($parts->count());
        expect($viewParts)->each(function($viewPart){
            $viewPart->mapping_items->toHaveCount(3);
        });
        return true;
    });
});

// test('検査方式管理 更新処理_正常', function () {
//     // Arrange
//     $processes = Process::factory()->create();
//     $processes->each(function ($process) {
//         $products = Product::factory()->hasAttached($process, [
//             'form' => 'CHECKLIST'
//         ])->create();
//     });
//     $inspectingForm = InspectingForm::first();

//     $data = [
//         'form' => 'MAPPING'
//     ];
//     $this->assertDatabaseHas('inspecting_forms', [
//         'id' => $inspectingForm->id,
//         'form' => $inspectingForm->form,
//     ]);
//     $this->assertDatabaseMissing('inspecting_forms', [
//         'id' => $inspectingForm->id,
//         'form' => $data['form'],
//     ]);

//     // Act
//     // POST元URIをセットしてからPOST
//     $res = $this->from("/inspecting-forms/{$inspectingForm->id}/edit")->put("/inspecting-forms/{$inspectingForm->id}", $data);

//     // Assert
//     // 一覧画面にリダイレクトしていること
//     $res->assertRedirect('/inspecting-forms');
//     // DBに更新されていること
//     $this->assertDatabaseMissing('inspecting_forms', [
//         'id' => $inspectingForm->id,
//         'form' => $inspectingForm->form,
//     ]);
//     $this->assertDatabaseHas('inspecting_forms', [
//         'id' => $inspectingForm->id,
//         'form' => $data['form'],
//     ]);
// });

// test('検査方式管理 更新処理_異常(バリデーション)', function () {
//     // Arrange
//     $processes = Process::factory()->create();
//     $processes->each(function ($process) {
//         $products = Product::factory()->hasAttached($process, [
//             'form' => 'CHECKLIST'
//         ])->create();
//     });
//     $inspectingForm = InspectingForm::first();

//     $data = [
//         'form' => 'fail'
//     ];
//     $this->assertDatabaseHas('inspecting_forms', [
//         'id' => $inspectingForm->id,
//         'form' => $inspectingForm->form,
//     ]);
//     $this->assertDatabaseMissing('inspecting_forms', [
//         'id' => $inspectingForm->id,
//         'form' => $data['form'],
//     ]);

//     // Act
//     // POST元URIをセットしてからPOST
//     $res = $this->from("/inspecting-forms/{$inspectingForm->id}/edit")->put("/inspecting-forms/{$inspectingForm->id}", $data);

//     // Assert
//     // 一覧画面にリダイレクトしていること
//     $res->assertRedirect("/inspecting-forms/{$inspectingForm->id}/edit");
//     // DBに更新されていないこと
//     $this->assertDatabaseHas('inspecting_forms', [
//         'id' => $inspectingForm->id,
//         'form' => $inspectingForm->form,
//     ]);
//     $this->assertDatabaseMissing('inspecting_forms', [
//         'id' => $inspectingForm->id,
//         'form' => $data['form'],
//     ]);
// });

