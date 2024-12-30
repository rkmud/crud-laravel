<?php

declare(strict_types=1);

namespace App\Http\Interfaces;

use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;

interface PostServiceInterface
{
    public function getById(string $id): Post | null;

    public function getAll(): Collection;

    public function create(string $title, string $content);

    public function update(array $values): mixed;

    public function delete(string $id): mixed;
}
