<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Interfaces\DataProviderInterface;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Interfaces\ShouldInteractWithShopify;

final class ShopifyController extends Controller
{
    public function __construct(
        private readonly ShouldInteractWithShopify $shopify
    ) {
    }

   public function showProduct(DataProviderInterface $exporter): Response
   {
       return $exporter->export($this->shopify->fetchProducts());
   }
}
