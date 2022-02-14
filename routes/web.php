<?php

use App\Http\Controllers\InspectingFormController;
use App\Http\Controllers\InspectionController;
use App\Http\Controllers\MappingItemController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\ProcessController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductPartController;
use App\Http\Controllers\RecordedProductController;
use App\Http\Controllers\SpecificationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});
Route::get('/home', function () {
    return view('home');
})->middleware(['auth'])->name('home');

Route::resource('processes', ProcessController::class);

Route::resource('products', ProductController::class);

Route::get('products/{product}/parts', [ProductPartController::class, 'index'])->name('products.parts.index');

Route::post('products/{product}/parts', [ProductController::class, 'attachParts'])->name('products.parts.attach');

Route::get('parts/{part}/processes', [PartController::class, 'indexProcesses'])->name('parts.processes.index');
Route::get('parts/{part}/processes/{process}', [PartController::class, 'indexProcesses'])->name('parts.processes.edit');
Route::resource('parts', PartController::class);
Route::resource('processes-parts/{process_part}/mapping-items', MappingItemController::class);

Route::resource('specifications', SpecificationController::class);

Route::resource('recorded-products', RecordedProductController::class);

Route::resource('inspecting-forms', InspectingFormController::class);

Route::resource('inspections', InspectionController::class);
