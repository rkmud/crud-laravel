<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Interfaces\ShouldCreateExportFileForShopifyProducts;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Collection;

final class  TxtShopifyProductsExportFileCreator implements ShouldCreateExportFileForShopifyProducts
{
    public function export(Collection $products): Response
    {
        $fd = fopen('php://temp', 'r+');
        $this->writeData($fd, $products);
        rewind($fd);
        $content = stream_get_contents($fd);
        fclose($fd);

        return new Response(
            $content,
            200,
            [
                'Content-Type' => 'text/plain',
                'Content-Disposition' => 'attachment; filename="products.txt"',
            ]
        );
    }

    private function writeData($fd, Collection $products): void
    {
        if($products->isEmpty()){
            fwrite($fd, "No products found in the data.\n");
            return;
        }

        foreach ($products as $product) {
            $line = sprintf(
                "Title: %s\nDescription: %s\nImage: %s\nPrice: %s\n\n",
                $product->title,
                strip_tags($product->description),
                $product->image ?? 'N/A',
                $product->price
            );
            fwrite($fd, $line);
        }
    }
}
