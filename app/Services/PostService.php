<?php

declare(strict_types=1);

namespace App\Services;

use App\Http\Interfaces\PostServiceInterface;
use App\Models\Post;
use Illuminate\Database\Eloquent\Collection;
use App\Exceptions\PostNotFoundException;

final class PostService implements PostServiceInterface
{
    public function getById(string $id): Post
    {
        $post = Post::find($id);

        if (!$post) {
            throw new PostNotFoundException("Post with ID {$id} not found.");
        }

        return $post;
    }
    public function getAll(): Collection
    {
        return Post::all();
    }

    public function create(string $title, string $content): Post
    {
        return Post::query()->create(['title' => $title, 'content' => $content]);
    }

    public function update(array $values): mixed
    {
        $post = Post::query()->whereKey($values['id'])->firstOrFail();

        return $post->update(['title' => $values['title'], 'content' => $values['content']]);
    }

    public function delete(string $id): mixed
    {
        $post = Post::query()->whereKey($id)->firstOrFail();

        return $post->delete();
    }
}
