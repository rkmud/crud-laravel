<?php

namespace App\Http\Interfaces;
use \Symfony\Component\HttpFoundation\BinaryFileResponse;

interface DataProviderInterface
{
    public function transformData(array $products): BinaryFileResponse;
}
