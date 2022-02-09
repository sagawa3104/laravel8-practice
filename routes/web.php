<?php

use App\Http\Controllers\InspectingFormController;
use App\Http\Controllers\PartController;
use App\Http\Controllers\ProcessController;
use App\Http\Controllers\ProductController;
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

Route::get('products/{product}/parts', [ProductController::class, 'indexParts'])->name('products.parts');

Route::post('products/{product}/parts', [ProductController::class, 'attachParts'])->name('products.parts.attach');

Route::resource('parts', PartController::class);

Route::resource('specifications', SpecificationController::class);

Route::resource('recorded-products', RecordedProductController::class);

Route::get('inspecting-forms', [InspectingFormController::class, 'index'])->name('inspecting-forms.index');
