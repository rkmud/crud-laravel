<?php

declare(strict_types=1);

namespace App\Http\Interfaces;

use Illuminate\Support\Collection;
use App\DTOs\ProductDTO;

interface ShouldInteractWithShopify
{
    /** @return Collection<int, ProductDTO> **/
    public function fetchProducts(): Collection;
}
