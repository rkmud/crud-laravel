<?php

declare(strict_types=1);

namespace App\Http\Interfaces;

use Illuminate\Support\Collection;

interface ShouldInteractWithShopify
{
    public function fetchProducts(): Collection;
}
