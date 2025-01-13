<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Interfaces\DataProviderInterface;
use GuzzleHttp\Client;
use Psr\Http\Message\ResponseInterface;
use \Symfony\Component\HttpFoundation\Response;

class ShopifyController extends Controller
{
    public function getProducts(): array
    {
        $response = $this->fetchShopifyProducts();

        return json_decode($response->getBody()->getContents(),true);
    }

   public function showProduct(DataProviderInterface $printData): Response
   {
       return $printData->transformData($this->getProducts());
   }

   private function fetchShopifyProducts(): ResponseInterface
   {
       $shopDomain = config('shopify-app.shop_domain');
       $apiVersion = config('shopify-app.api_version');
       $accessToken = config('shopify-app.access_token');

       $url = "https://{$shopDomain}/admin/api/{$apiVersion}/products.json";

       $client = new Client();
       return $client->get($url, [
           'headers' => [
               'X-Shopify-Access-Token' => $accessToken,
           ],
       ]);
   }
}
