<?php

declare(strict_types=1);

use App\Providers\TxtDataProviderProvider;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ShopifyController;
use App\Providers\CsvDataProviderProvider;
use \App\Exceptions\RouteNotFoundException;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/posts', [PostController::class, 'index'])->name('posts.index');

Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');

Route::post('/posts', [PostController::class, 'store'])->name('posts.store');

Route::get('/posts/{id}', [PostController::class, 'show'])->name('posts.show');

Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

Route::get('/products', [ShopifyController::class, 'getProducts']);

Route::get('/products/{format}', function(string $format, ShopifyController $controller) {
    $formatter = match ($format) {
        'csv' => new CsvDataProviderProvider(),
        'txt' => new TxtDataProviderProvider(),
        default => throw new RouteNotFoundException('Route not found: '.$format),
    };

    return $controller->showProduct($formatter);
});
