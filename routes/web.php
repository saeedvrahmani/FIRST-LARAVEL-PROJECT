<?php

use App\Http\Controllers\Admin\AttributeController;
use App\Http\Controllers\admin\BannerController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\BrandController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController as AdminCommentController;
use App\Http\Controllers\Admin\CouponController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\ProductImageController;
use App\Http\Controllers\admin\tagController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\home\CartController;
use App\Http\Controllers\home\CategoryController as HomeCategoryController;
use App\Http\Controllers\home\CommentController;
use App\Http\Controllers\home\CompareController;
use App\Http\Controllers\home\HomeController;
use App\Http\Controllers\home\ProductController as HomeProductController;
use App\Http\Controllers\home\UserProfileController;
use App\Http\Controllers\home\WishlistController;

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

Route::get('/admin-panel/dashboard', function () {
    return view('admin.dashboard');
})->name('dashboard');

Route::prefix('admin-panel/management')->name('admin.')->group(function () {

    Route::resource('brands', BrandController::class);
    Route::resource('attributes', AttributeController::class);
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', tagController::class);
    Route::resource('products', ProductController::class);
    Route::resource('comments', AdminCommentController::class);
    Route::resource('coupons', CouponController::class);
    // CHANGE APPROVE COMMENT
    Route::get('/comments/{comment}/change-approve', [AdminCommentController::class, 'changeApprove'])->name('comments.change-approve');

    // BANNER ROUTE
    Route::resource('banners', BannerController::class);
    //get category atrribute
    Route::get('/category-attributes/{category}', [CategoryController::class, 'getCategoryAttributes']);


    // EDIT PRODUCT IMAGE ROUTE

    Route::get('/products/{product}/images-edit', [ProductImageController::class, 'edit'])->name('products.images.edit');
    Route::delete('/products/{product}/images-destroy', [ProductImageController::class, 'destroy'])->name('products.images.destroy');
    Route::put('/products/{product}/images-set-primary', [ProductImageController::class, 'setprimary'])->name('products.images.set_primary');
    Route::post('/products/{product}/images-add', [ProductImageController::class, 'add'])->name('products.images.add');



    // EDIT PRODUCT CATEGORY ROUTE 

    Route::get('/products/{product}/category-edit', [ProductController::class, 'editCategory'])->name('products.category.edit');
    Route::put('/products/{product}/category-UPDATE', [ProductController::class, 'updateCategory'])->name('products.category.update');
});

Route::get('/', [HomeController::class, 'index'])->name('home.index');
Route::get('/categories/{category:slug}', [HomeCategoryController::class, 'show'])->name('home.categories.show');
Route::get('/products/{product:slug}', [HomeProductController::class, 'show'])->name('home.products.show');
Route::get('/login/{provider}', [AuthController::class, "redirectToprovider"])->name('provider.login');
Route::get('/login/{provider}/callback', [AuthController::class, "handleProvidercallback"]);
Route::post('/comment/{product}', [CommentController::class, 'store'])->name('home.comments.store');
Route::get('/add-to-whishlist/{product}', [WishlistController::class, 'add'])->name('home.wishlist.add');
Route::get('/remove-from-whishlist/{product}', [WishlistController::class, 'remove'])->name('home.wishlist.remove');
Route::get('/add-to-compare/{product}', [CompareController::class, 'add'])->name('home.compare.add');
Route::get('/remove-from-compare/{product}', [CompareController::class, 'remove'])->name('home.compare.remove');
Route::get('/compare', [CompareController::class, 'index'])->name('home.compare.index');


Route::get('/cart', [CartController::class, 'index'])->name('home.cart.index');
Route::post('/add-to-cart', [CartController::class, 'add'])->name('home.cart.add');
Route::put('/cart', [CartController::class, 'update'])->name('home.cart.update');
Route::get('/remove-from-cart/{rowId}', [CartController::class, 'remove'])->name('home.cart.remove');
Route::put('/cart-clear', [CartController::class, 'clear'])->name('home.cart.clear');
Route::post('/cart-checkcoupon', [CartController::class, 'checkcoupon'])->name('home.cart.checkcoupon');

Route::get('/test', function () {
    // auth()->logout();
    // session()->get('compareProducts');
    // dd(session()->get('compareProducts'));
    \Cart::clear();
});

Route::prefix('profile')->name('home.')->group(function () {
    Route::get('/', [UserProfileController::class, 'index'])->name('user-profile.index');
    Route::get('/wishlist', [WishlistController::class, 'usersProfileIndex'])->name('wishlist.users_profile.index');
    Route::get('/comments', [CommentController::class, 'usersProfileIndex'])->name('comments.users_profile.index');
});
