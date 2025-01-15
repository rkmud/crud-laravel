<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Interfaces\ShouldCreateExportFileForShopifyProducts;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\Response;

final class CsvShopifyProductsExportFileCreator implements ShouldCreateExportFileForShopifyProducts
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
                'Content-Disposition' => 'attachment; filename="products.csv"',
            ]
        );
    }

    /**
     * @param resource $fd
     */
    private function writeData($fd, Collection $products): void
    {
        fputcsv($fd, ['id', 'title', 'description', 'price', 'image']);

        foreach ($products as $product) {
            fputcsv($fd, [
                $product->id,
                $product->title,
                $product->description,
                $product->price,
                $product->image,
            ]);
        }
    }
}
