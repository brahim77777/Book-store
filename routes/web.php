<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GalleryController;

use App\Http\Controllers\BooksController;
use App\Http\Controllers\CategoriesController;
use App\Http\Controllers\PublishersController;
use App\Http\Controllers\AuthorsController;
use App\Http\Controllers\AdminsController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\PurchaseController;
use App\Http\Controllers\UsersController;

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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::middleware(['auth:sanctum', 'verified'])->get('/dashboard', function () {
    return view('layouts.main');
})->name('dashboard');


// Route::get('/' , function(){
//     return view('layouts.main');
// })->name('dashboard');

Route::get('/' , [GalleryController::class , 'index'])->name('gallery.index');
Route::get('search' , [GalleryController::class , 'search'])->name('search');
Route::get('books/{book}' , [BooksController::class , 'details'])->name('book.details');
Route::post('books/{book}/rate' , [BooksController::class , 'rate'])->name('book.rate');

Route::get('/category/{category}' , [CategoriesController::class , 'result'])->name('gallery.category.show');
Route::get('/categories' ,[CategoriesController::class , 'list'])->name('gallery.category.index');
Route::get('/categories/search' , [CategoriesController::class ,'search'])->name('gallery.category.search');


// publishers Routes


Route::get('/publisher/{publisher}' , [PublishersController::class , 'result'])->name('gallery.publisher.show');
Route::get('/publishers' ,[PublishersController::class , 'list'])->name('gallery.publisher.index');
Route::get('/publishers/search' , [PublishersController::class ,'search'])->name('gallery.publisher.search');

// Authors Routes
Route::get('/authors/search' , [AuthorsController::class ,'search'])->name('gallery.author.search');
Route::get('/authors/{author}' , [AuthorsController::class , 'result'])->name('gallery.author.show');
Route::get('/authors' ,[AuthorsController::class , 'list'])->name('gallery.author.index');

//Dashboard




// CRUD BOOKS

Route::get('admin/books'  , [BooksController::class , 'index'])->name('books.index')->middleware('can:update-books');
// With some refactoring we can make replace the below routes to Route::resource('/admin/books' , BooksController::class);
Route::get('admin/books/create' , [BooksController::class , 'create'])->name('books.create')->middleware('can:update-books');
Route::post('admin/Books' , [BooksController::class , 'store'])->name('books.store')->middleware('can:update-books');

Route::get('admin/books/{book}' , [BooksController::class , 'show'])->name('admin.books.show')->middleware('can:update-books');
Route::get('admin/books/{book}/edit' , [BooksController::class , 'edit'])->name('books.edit')->middleware('can:update-books');

Route::patch('/admin/books/{book}' , [BooksController::class , 'update'])->name('books.update')->middleware('can:update-books');
Route::delete('/admin/books/{book}' , [BooksController::class , 'destroy'])->name('books.destroy')->middleware('can:update-books');

//End.



// Authentication

Route::prefix('/admin')->middleware('can:update-books')->group(function(){
    Route::get('/' , [AdminsController::class , 'index'])->name('admin.index');

    Route::resource('/categories' , CategoriesController::class);
    Route::resource('/publishers' , PublishersController::class);
    Route::resource('/authors' , AuthorsController::class);
});

Route::resource('/admin/users' , UsersController::class)->middleware('can:update-users');
Route::get('/admin/allproduct'  ,[PurchaseController::class , 'allProduct'])->name('all.product')->middleware('can:update-users');


Route::post('/cart' , [CartController::class , 'addToCart'])->name('cart.add');
Route::get('/cart' , [CartController::class , 'viewCart'])->name('cart.view');
Route::post('/removeOne/{book}' , [CartController::class , 'removeOne'])->name('cart.remove_one');
Route::post('/removeAll/{book}' , [CartController::class , 'removeAll'])->name('cart.remove_all');


//Payments

//Testing ;

//CreditCard

Route::get('/checkout' , [PurchaseController::class , 'creditCheckout'])->name('credit.checkout');
Route::post('/purchase' , [PurchaseController::class , 'purchase'])->name('products.purchase');


// test => // مشترياتي
Route::get('/myproduct' , [PurchaseController::class , 'myProduct'])->name('my.product');



