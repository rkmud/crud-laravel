<?php

namespace App\Providers;

use App\Http\Interfaces\DataProviderInterface;
use \Symfony\Component\HttpFoundation\BinaryFileResponse;

class TxtDataProviderProvider implements DataProviderInterface
{
    public function transformData(array $products): BinaryFileResponse
    {
        $txtFilePath = $this->getFilePath();

        $this->writeData($txtFilePath, $products);

        return response()->download($txtFilePath);
    }

    private function getFilePath(): string
    {
        $txtFilePath = storage_path('app/products.txt');

        if (!file_exists(storage_path('app'))) {
            mkdir(storage_path('app'), 0777, true);
        }

        if (!file_exists($txtFilePath)) {
            touch($txtFilePath);
        }

        return $txtFilePath;
    }

    private function writeData(string $filePath, array $products): void
    {
        $file = fopen($filePath, 'w');

        if(!isset($products)){
            fwrite($file, "No products found in the data.\n");
        }

        foreach ($products['products'] as $product) {
            $title = $product['title'] ?? 'N/A';
            $description = strip_tags($product['body_html'] ?? '');
            $image = $product['image']['src'] ?? 'N/A';
            $price = $product['variants'][0]['price'] ?? 'N/A';
            $line = "Title: $title\nDescription: $description\nImage: $image\nPrice: $price\n\n";
            fwrite($file, $line);
        }

        fclose($file);
    }
}
