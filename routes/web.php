<?php

use App\Http\Controllers\BookController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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
Route::prefix('products')->group(function(){
    Route::get('/',[ProductController::class,'index'])->name('products.index');
    Route::get('/{id}/addToCart',[ProductController::class,'addToCart'])->name('products.addToCart');
    Route::get('/{id}/removeItem',[ProductController::class,'removeItem'])->name('products.removeItem');
    Route::get('/{id}/updateItem/{quantity}',[ProductController::class,'updateItem'])->name('products.updateItem');
    Route::get('/cart',[ProductController::class,'showCart'])->name('products.cart');

});
Route::get('/admin/login', [LoginController::class, 'showFormLogin'])->name('login.showFormLogin');
Route::post('/login', [LoginController::class, 'login'])->name('login');

Route::prefix('admin')->group(function () {
    Route::get('/dashboard', [HomeController::class, 'index'])->name('home.index');
    Route::prefix('users')->group(function () {
        Route::get('', [UserController::class, 'index'])->name('users.index');
        Route::get('/create', [UserController::class, 'create'])->name('users.create');
        Route::post('/create', [UserController::class, 'store'])->name('users.store');
        Route::get('/{id}', [UserController::class, 'detail'])->whereNumber('id')->name('users.detail');
        Route::get('/{id}/comments/{id_comment?}', [UserController::class, 'getComment'])->name('users.getComment');
        Route::get('{id}/edit', [UserController::class, 'edit'])->name('users.edit');
        Route::post('{id}/edit', [UserController::class, 'update'])->name('users.update');
        Route::get('{id}/destroy', [UserController::class, 'destroy'])->name('users.destroy');
        Route::get('/search', [UserController::class, 'search'])->name('users.search');
    });
    Route::prefix('books')->group(function () {
        Route::get('', [BookController::class, 'index'])->name('books.index');
        Route::get('/create', [BookController::class, 'create'])->name('books.create');
        Route::post('/create', [BookController::class, 'store'])->name('books.store');
        Route::get('{id}/edit', [BookController::class, 'edit'])->name('books.edit');
        Route::post('{id}/edit', [BookController::class, 'update'])->name('books.update');
        Route::get('{id}/destroy', [BookController::class, 'destroy'])->name('books.destroy');
    });
    Route::prefix('categories')->group(function () {
        Route::get('', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('/create', [CategoryController::class, 'create'])->name('categories.create');
        Route::post('/create', [CategoryController::class, 'store'])->name('categories.store');
        Route::get('{id}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
        Route::post('{id}/edit', [CategoryController::class, 'update'])->name('categories.update');
        Route::get('{id}/destroy', [CategoryController::class, 'destroy'])->name('categories.destroy');
    });
    Route::prefix('posts')->group(function () {
    });
});






/*
 * Route::method('uri', 'action')
 *
 * - method: GET - lấy tài nguyên
 *           POST - them moi
 *           PUT - cap nhat
 *           DELETE - Xoa
 *
 * - action: - function x
 *           - array [Controller::class, 'method'] -> nen su dung
 *           - string - 'App\Http\Controllers@method' x
 *
 */
