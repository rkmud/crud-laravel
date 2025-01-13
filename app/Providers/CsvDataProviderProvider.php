<?php

namespace App\Providers;

use App\Http\Interfaces\DataProviderInterface;
use \Symfony\Component\HttpFoundation\BinaryFileResponse;

class CsvDataProviderProvider implements DataProviderInterface
{
    public function transformData(array $products): BinaryFileResponse
    {
        $csvFilePath = $this->getFilePath();

        $this->writeData($csvFilePath, $products);

        return response()->download($csvFilePath);
    }

    private function getFilePath(): string
    {
        $csvFilePath = storage_path('app/products.csv');

        if (!file_exists(storage_path('app'))) {
            mkdir(storage_path('app'), 0775, true);
        }

        if (!file_exists($csvFilePath)) {
            touch($csvFilePath);
        }

        return $csvFilePath;
    }

    private function writeData(string $csvFilePath, array $products): void
    {
        $file = fopen($csvFilePath, 'w');

        fputcsv($file, ['id', 'title', 'description', 'price', 'image']);

        foreach ($products['products'] as $product) {
            $id = $product['id'];
            $title = $product['title'];
            $description = strip_tags($product['body_html']) ?? '';
            $price = $product['variants'][0]['price'];
            $image = $product['image']['src'] ?? null;

            fputcsv($file, [$id, $title, $description, $price, $image]);
        }

        fclose($file);
    }
}
