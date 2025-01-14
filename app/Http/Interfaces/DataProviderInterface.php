<?php

declare(strict_types=1);

namespace App\Http\Interfaces;

use Symfony\Component\HttpFoundation\BinaryFileResponse;
use Illuminate\Support\Collection;

interface DataProviderInterface
{
    public function export(Collection $products): BinaryFileResponse;
}

