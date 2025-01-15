<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Interfaces\ShouldCreateExportFileForShopifyProducts;
use Symfony\Component\HttpFoundation\Response;
use App\Http\Interfaces\ShouldInteractWithShopify;
use App\Providers\CsvShopifyProductsExportFileCreator;
use App\Providers\TxtShopifyProductsExportFileCreator;
use App\Exceptions\RouteNotFoundException;

final class ShopifyController extends Controller
{
    public function __construct(
        private readonly ShouldInteractWithShopify $shopify
    ) {
    }

   public function showProduct(string $format): Response
   {
       try {
           $exporter = $this->getExporterByFormat($format);

           return $exporter->export($this->shopify->fetchProducts());
       } catch (RouteNotFoundException $exception) {
           return response($exception->getMessage());
       }
   }

    public function getExporterByFormat(string $format): ShouldCreateExportFileForShopifyProducts
    {
        return match ($format) {
            'csv' => new CsvShopifyProductsExportFileCreator(),
            'txt' => new TxtShopifyProductsExportFileCreator(),
            default => throw new RouteNotFoundException('Unsupported format: ' . $format),
        };
    }
}
