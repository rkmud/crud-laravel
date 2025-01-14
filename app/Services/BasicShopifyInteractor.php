<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Interfaces\ShouldInteractWithShopify;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use App\DTOs\ProductDTO;

final class BasicShopifyInteractor implements ShouldInteractWithShopify
{
    private string $shopDomain;
    private string $apiVersion;
    private string $accessToken;

    public function __construct(string $shopDomain, string $apiVersion, string $accessToken)
    {
        $this->shopDomain = $shopDomain;
        $this->apiVersion = $apiVersion;
        $this->accessToken = $accessToken;
    }

    public function fetchProducts(): Collection
    {
        $url = "https://{$this->shopDomain}/admin/api/{$this->apiVersion}/products.json";

        $client = new Client();
        $response = $client->get($url, [
            'headers' => [
                'X-Shopify-Access-Token' => $this->accessToken,
            ],
        ]);
        $products = json_decode($response->getBody()->getContents(), true)['products'] ?? [];

        return collect($products)->map(fn($product) => new ProductDTO(
            id: (string)$product['id'],
            title: $product['title'],
            description: strip_tags($product['body_html'] ?? ''),
            price: (string)($product['variants'][0]['price'] ?? '0'),
            image: $product['image']['src'] ?? ''
        ));
    }
}
