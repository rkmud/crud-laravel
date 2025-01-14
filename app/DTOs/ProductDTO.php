<?php

declare(strict_types=1);

namespace App\DTOs;

use Spatie\DataTransferObject\DataTransferObject;

final class ProductDTO extends DataTransferObject
{
    public string $id;
    public string $title;
    public string $description;
    public string $price;
    public string $image;
}
