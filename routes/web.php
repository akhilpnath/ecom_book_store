<?php

use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\AdminProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\AdminProductController;
use App\Http\Controllers\AdminOrderController;
use App\Http\Controllers\AdminUserController;
use App\Http\Controllers\AdminMessageController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UserProductController;
use App\Http\Controllers\UserOrderController;
use App\Http\Controllers\UserWishlistController;
use App\Http\Controllers\UserCartController;
use App\Http\Controllers\UserMessageController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// Authentication Routes
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// User Routes
Route::middleware(['auth', 'user'])->group(function () {
    // Home
    Route::get('/', [UserController::class, 'home'])->name('user.home');

    // Products
    Route::get('/shop', [UserProductController::class, 'shop'])->name('user.shop');
    Route::get('/category/{category}', [UserProductController::class, 'category'])->name('user.category');
    Route::get('/product/{id}', [UserProductController::class, 'view'])->name('user.product.view');

    // Cart
    Route::get('/cart', [UserCartController::class, 'index'])->name('user.cart');
    Route::post('/cart/add', [UserCartController::class, 'add'])->name('user.cart.add');
    Route::post('/cart/update', [UserCartController::class, 'update'])->name('user.cart.update');
    Route::delete('/cart/delete/{id}', [UserCartController::class, 'delete'])->name('user.cart.delete');
    Route::delete('/cart/delete-all', [UserCartController::class, 'deleteAll'])->name('user.cart.deleteAll');

    // Wishlist
    Route::get('/wishlist', [UserWishlistController::class, 'index'])->name('user.wishlist');
    Route::post('/wishlist/add', [UserWishlistController::class, 'add'])->name('user.wishlist.add');
    Route::delete('/wishlist/delete/{id}', [UserWishlistController::class, 'delete'])->name('user.wishlist.delete');
    Route::delete('/wishlist/delete-all', [UserWishlistController::class, 'deleteAll'])->name('user.wishlist.deleteAll');

    // Orders
    Route::get('/orders', [UserOrderController::class, 'index'])->name('user.orders');
    Route::post('/checkout', [UserOrderController::class, 'checkout'])->name('user.checkout');

    // Messages
    Route::get('/contact', [UserMessageController::class, 'index'])->name('user.contact');
    Route::post('/contact/send', [UserMessageController::class, 'send'])->name('user.contact.send');
});

// Admin Routes
Route::middleware(['auth', 'admin'])->group(function () {
    // Admin Dashboard
    Route::get('/admin', [AdminDashboardController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/profile', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('/admin/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');

    // Products Routes
    Route::get('/admin/products', [AdminProductController::class, 'index'])->name('admin.products.index');
    Route::get('/admin/products/create', [AdminProductController::class, 'create'])->name('admin.products.create');
    Route::post('/admin/products', [AdminProductController::class, 'store'])->name('admin.products.store');
    Route::get('/admin/products/{product}/edit', [AdminProductController::class, 'edit'])->name('admin.products.edit');
    Route::put('/admin/products/{product}', [AdminProductController::class, 'update'])->name('admin.products.update');
    Route::delete('/admin/products/{product}', [AdminProductController::class, 'destroy'])->name('admin.products.destroy');

    // Orders Routes
    Route::get('/admin/orders', [AdminOrderController::class, 'index'])->name('admin.orders.index');
    Route::put('/admin/orders/{order}', [AdminOrderController::class, 'update'])->name('admin.orders.update');
    Route::delete('/admin/orders/{order}', [AdminOrderController::class, 'destroy'])->name('admin.orders.destroy');

    // Users Routes
    Route::get('/admin/users', [AdminUserController::class, 'index'])->name('admin.users.index');
    Route::delete('/admin/users/{user}', [AdminUserController::class, 'destroy'])->name('admin.users.destroy');

    // Messages Routes
    Route::get('/admin/messages', [AdminMessageController::class, 'index'])->name('admin.messages.index');
    Route::delete('/admin/messages/{message}', [AdminMessageController::class, 'destroy'])->name('admin.messages.destroy');
});

Route::prefix('admin')->group(function () {
    Route::get('/books/search', [BookController::class, 'searchForm'])->name('admin.books.search');
    Route::get('/books/search/results', [BookController::class, 'search'])->name('admin.books.search.results');
    Route::post('/books/import/{volumeId}', [BookController::class, 'import'])->name('admin.books.import');
});