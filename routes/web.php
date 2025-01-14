<?php

declare(strict_types=1);

use App\Providers\TxtDataProviderProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ShopifyController;
use App\Providers\CsvDataProviderProvider;
use App\Exceptions\RouteNotFoundException;
use App\Services\BasicShopifyInteractor;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');

Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');

Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

Route::get('/products/{format}', function(string $format) {
    $shopify = new BasicShopifyInteractor(
        config('shopify-app.shop_domain'),
        config('shopify-app.api_version'),
        config('shopify-app.access_token')
    );
    $formatter = match ($format) {
        'csv' => new CsvDataProviderProvider(),
        'txt' => new TxtDataProviderProvider(),
        default => throw new RouteNotFoundException('Route not found: ' . $format),
    };

    $controller = new ShopifyController($shopify);

    return $controller->showProduct($formatter);
});
