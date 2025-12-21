<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Customer\VegetasController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;
use App\Http\Controllers\Customer\WishlistController;
use App\Http\Controllers\Customer\PaymentController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\UserController;


/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// Trang chủ – TỰ ĐỘNG ĐIỀU HƯỚNG THEO ROLE
Route::get('/', function () {
    if (auth()->check()) {
        if (in_array(auth()->user()->role_id, [2, 3])) {
            return redirect()->route('admin.dashboard');
        }
        return redirect()->route('dashboard'); // Customer
    }
    return app(VegetasController::class)->welcome();
})->name('home');

// Dashboard (chỉ user đã đăng nhập)
Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/dashboard', [VegetasController::class, 'dashboard'])->name('dashboard');
    
    
    // Profile routes
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
});

// ================= Admin routes =================
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])
            ->name('dashboard');

        // === PRODUCTS – CHỈ DÙNG 1 DÒNG NÀY LÀ ĐỦ ===
        Route::resource('products', ProductController::class)
             ->parameters(['products' => 'product'])
             ->except(['show']);

        
        Route::resource('categories', CategoryController::class)
    ->parameters(['categories' => 'category'])
    ->except(['show']);


        Route::resource('orders', OrderController::class)
    ->parameters(['orders' => 'order'])
    ->only(['index', 'show']);
    Route::post('orders/{order}/approve', [OrderController::class, 'approve'])
    ->name('orders.approve');

 

        Route::resource('users', UserController::class)
    ->parameters(['users' => 'user'])
    ->except(['show']);


        Route::view('/posts', 'admin.posts.index')->name('posts.index');
});

// ================= User dashboard =================
Route::middleware(['auth'])->get('/dashboard', [VegetasController::class, 'dashboard'])
    ->name('dashboard');

    Route::middleware('auth')->group(function () {
    Route::get('/wishlist', [WishlistController::class, 'index'])->name('wishlist.index');
    Route::post('/wishlist/toggle', [WishlistController::class, 'toggle'])->name('wishlist.toggle');
    Route::get('/payments', [PaymentController::class, 'index'])->name('payments.index');
    Route::get('/payments/{payment}', [PaymentController::class, 'show'])->name('payments.show');


});

// ==================== GIỎ HÀNG – HOÀN CHỈNH 100% ====================
Route::middleware('auth')->group(function () {
    // Thêm sản phẩm vào giỏ
    Route::post('/cart/add/{id}', [CartController::class, 'add'])
        ->name('cart.add');

    // Xem giỏ hàng 
    Route::get('/gio-hang', [CartController::class, 'index'])
        ->name('cart.index');

    // Cập nhật số lượng
    Route::put('/cart/update/{id}', [CartController::class, 'update'])
        ->name('cart.update');

    // Xóa sản phẩm khỏi giỏ
    Route::delete('/cart/remove/{id}', [CartController::class, 'remove'])
        ->name('cart.remove');

    Route::post('/cart/add2/{id}', [CartController::class, 'add2'])->name('cart.add2');
});

Route::get('/test-cart', function () {
    $user = App\Models\User::find(1); 
    dd(
        $user->cartItems()->with('product')->get()->toArray()
    );
});

    Route::get('/san-pham/{id}', [App\Http\Controllers\Customer\ProductController::class, 'show'])
     -> name('product.detail');

Route::post('/checkout', [CheckoutController::class, 'process'])
    ->name('checkout.process');

    //Lịch sử mua hàng
    Route::get('/cart/history', [CartController::class, 'history'])->name('cart.history');


Route::get('/tim-kiem', [VegetasController::class, 'search'])->name('products.search');


// Auth routes (login, register, forgot password...)
require __DIR__.'/auth.php';