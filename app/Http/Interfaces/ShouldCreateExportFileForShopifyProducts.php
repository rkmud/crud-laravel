<?php

declare(strict_types=1);

namespace App\Http\Interfaces;

use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Collection;
use App\DTOs\ProductDTO;

interface ShouldCreateExportFileForShopifyProducts
{
    /**
     *  @param Collection<int, ProductDTO> $products
     *  @return Response
    */
    public function export(Collection $products): Response;
}
