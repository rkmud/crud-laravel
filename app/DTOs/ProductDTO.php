<?php

declare(strict_types=1);

namespace App\DTOs;

use Spatie\DataTransferObject\DataTransferObject;
use Illuminate\Support\Collection;

final class ProductDTO extends DataTransferObject
{
    public string $id;
    public string $title;
    public string $description;
    public string $price;
    public string $image;

    /**
     * @param array $products
     * @return Collection<ProductDTO>
     */
    public static function collect(array $products): Collection
    {
        return new Collection(
            array_map(fn($product) => new self(
                id: (string)$product['id'],
                title: $product['title'],
                description: strip_tags($product['body_html'] ?? ''),
                price: (string)($product['variants'][0]['price'] ?? '0'),
                image: $product['image']['src'] ?? ''
            ), $products)
        );
    }
}
