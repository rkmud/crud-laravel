<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Interfaces\ShouldInteractWithShopify;
use GuzzleHttp\Client;
use Illuminate\Support\Collection;
use App\DTOs\ProductDTO;

final class BasicShopifyInteractor implements ShouldInteractWithShopify
{
    private Client $client;

    public function __construct(string $shopDomain, string $apiVersion, string $accessToken)
    {
        $this->client = new Client([
            'base_uri' => "https://{$shopDomain}/admin/api/{$apiVersion}/",
            'headers' => [
                'X-Shopify-Access-Token' => $accessToken,
            ],
        ]);
    }

    public function fetchProducts(): Collection
    {
        $response = $this->client->get('products.json');
        $products = json_decode($response->getBody()->getContents(), true)['products'] ?? [];

        return ProductDTO::collect($products);
    }
}
