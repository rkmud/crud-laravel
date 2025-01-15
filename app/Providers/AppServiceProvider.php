<?php

namespace App\Providers;

use App\Http\Interfaces\ShouldInteractWithShopify;
use App\Services\BasicShopifyInteractor;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
       $this->app->bind(
           ShouldInteractWithShopify::class,
           fn() =>  new BasicShopifyInteractor(
               config('shopify-app.shop_domain'),
               config('shopify-app.api_version'),
               config('shopify-app.access_token')
           )
       );
    }

    public function boot(): void {}
}
