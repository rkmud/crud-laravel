<?php

declare(strict_types=1);

namespace App\Providers;

use App\Http\Interfaces\DataProviderInterface;
use Illuminate\Support\Collection;
use \Symfony\Component\HttpFoundation\BinaryFileResponse;

final class TxtDataProviderProvider implements DataProviderInterface
{
    public function export(Collection $products): BinaryFileResponse
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

    private function writeData(string $filePath, Collection $products): void
    {
        $file = fopen($filePath, 'w');

        if($products->isEmpty()){
            fwrite($file, "No products found in the data.\n");
        }

        foreach ($products as $product) {
            $line = sprintf(
                "Title: %s\nDescription: %s\nImage: %s\nPrice: %s\n\n",
                $product->title,
                strip_tags($product->description),
                $product->image ?? 'N/A',
                $product->price
            );
            fwrite($file, $line);
        }
        fclose($file);
    }
}
