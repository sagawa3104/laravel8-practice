<?php

use App\Http\Controllers\ProductController;
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
})->middleware(['auth']);

Route::resource('products', ProductController::class);

Route::get('products/{product}/parts', [ProductController::class, 'indexParts'])->name('products.parts');

Route::post('products/{product}/parts', [ProductController::class, 'attachParts'])->name('products.parts.attach');
