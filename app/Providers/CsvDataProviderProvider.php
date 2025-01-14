<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Interfaces\DataProviderInterface;
use Illuminate\Support\Collection;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

final class CsvDataProviderProvider implements DataProviderInterface
{
    public function export(Collection $products): BinaryFileResponse
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

    private function writeData(string $csvFilePath, Collection $products): void
    {
        $file = fopen($csvFilePath, 'w');

        fputcsv($file, ['id', 'title', 'description', 'price', 'image']);

        foreach ($products as $product) {
            fputcsv($file, [
                $product->id,
                $product->title,
                $product->description,
                $product->price,
                $product->image,
            ]);
        }

        fclose($file);
    }
}
