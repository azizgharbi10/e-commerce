<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\CategoryController as AdminCategoryController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Shop\CategoryController as ShopCategoryController;
use App\Http\Controllers\Shop\ProductController as ShopProductController;
use App\Http\Controllers\Shop\CartController as ShopCartController;
use App\Http\Controllers\Shop\OrderController as ShopOrderController;
use App\Http\Controllers\Shop\AccountController as ShopAccountController;

// Page d'accueil - Redirige vers login pour les utilisateurs non authentifiés
Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('shop.products.index');
    }
    return redirect()->route('login');
})->name('home');

// AUTHENTIFICATION
Route::get('/login', [AuthController::class, 'showLogin'])->name('login')->middleware('guest');
Route::post('/login', [AuthController::class, 'login'])->middleware('guest');
Route::get('/register', [AuthController::class, 'showRegister'])->name('register')->middleware('guest');
Route::post('/register', [AuthController::class, 'register'])->middleware('guest');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout')->middleware('auth');

// ZONE ADMINISTRATION (/admin)
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'checkAdmin'])
    ->group(function () {
        
        // Gestion des catégories
        Route::prefix('categories')
            ->name('categories.')
            ->group(function () {
                Route::get('/', [AdminCategoryController::class, 'index'])->name('index');
                Route::get('/create', [AdminCategoryController::class, 'create'])->name('create');
                Route::post('/', [AdminCategoryController::class, 'store'])->name('store');
                Route::get('/{category}/edit', [AdminCategoryController::class, 'edit'])->name('edit');
                Route::put('/{category}', [AdminCategoryController::class, 'update'])->name('update');
                Route::delete('/{category}', [AdminCategoryController::class, 'destroy'])->name('destroy');
            });

        // Gestion des produits
        Route::prefix('products')
            ->name('products.')
            ->group(function () {
                Route::get('/', [AdminProductController::class, 'index'])->name('index');
                Route::get('/create', [AdminProductController::class, 'create'])->name('create');
                Route::post('/', [AdminProductController::class, 'store'])->name('store');
                Route::get('/{product}/edit', [AdminProductController::class, 'edit'])->name('edit');
                Route::put('/{product}', [AdminProductController::class, 'update'])->name('update');
                Route::delete('/{product}', [AdminProductController::class, 'destroy'])->name('destroy');
            });

        // Gestion des commandes
        Route::prefix('orders')
            ->name('orders.')
            ->group(function () {
                Route::get('/', [AdminOrderController::class, 'index'])->name('index');
                Route::get('/{order}', [AdminOrderController::class, 'show'])->name('show');
                Route::put('/{order}/status', [AdminOrderController::class, 'updateStatus'])->name('updateStatus');
            });
    });

// ZONE SHOP CLIENT (/shop) - Protégée par authentification
Route::prefix('shop')
    ->name('shop.')
    ->middleware('auth')
    ->group(function () {
        
        // Catalogue produits
        Route::get('/', [ShopProductController::class, 'index'])->name('products.index');
        Route::get('/products/{product}', [ShopProductController::class, 'show'])->name('products.show');
        
        // Navigation par catégories
        Route::get('/categories', [ShopCategoryController::class, 'index'])->name('categories.index');
        Route::get('/categories/{category}', [ShopCategoryController::class, 'show'])->name('categories.show');
        
        // Panier
        Route::prefix('cart')->name('cart.')->group(function () {
            Route::get('/', [ShopCartController::class, 'index'])->name('index');
            Route::post('/add/{product}', [ShopCartController::class, 'add'])->name('add');
            Route::put('/update/{productId}', [ShopCartController::class, 'update'])->name('update');
            Route::delete('/remove/{productId}', [ShopCartController::class, 'remove'])->name('remove');
            Route::delete('/clear', [ShopCartController::class, 'clear'])->name('clear');
        });

        // Commandes
        Route::get('/checkout', [ShopOrderController::class, 'checkout'])->name('checkout');
        Route::post('/orders', [ShopOrderController::class, 'store'])->name('orders.store');
        Route::get('/orders/{orderNumber}', [ShopOrderController::class, 'confirmation'])->name('orders.confirmation');

        // Compte client
        Route::prefix('account')->name('account.')->group(function () {
            Route::get('/profile', [ShopAccountController::class, 'profile'])->name('profile');
            Route::get('/orders', [ShopAccountController::class, 'orders'])->name('orders');
            Route::get('/orders/{orderNumber}', [ShopAccountController::class, 'orderDetail'])->name('orderDetail');
        });
    });

