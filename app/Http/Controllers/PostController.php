<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\PostRequest;
use Illuminate\Http\Response;
use App\Services\PostService;

final class PostController extends Controller
{
    public function __construct(private PostService $service) {}

    public function index(): Response
    {
        $posts = $this->service->getAll();

        return response()->view('posts.index', compact('posts'));
    }

    public function show(string $id): Response
    {
        $post = $this->service->getByID($id);

        return response()->view('posts.show', compact('post'));
    }

    public function create(): Response
    {
        return response()->view('posts.create');
    }

    public function store(PostRequest $request): Response
    {
        $validated = $request->validated();
        $post = $this->service->create($validated['title'], $validated['content']);

        return response()->view('posts.show', compact('post'));
    }

    public function update(PostRequest $request): Response
    {
        $validated = $request->validated();
        $post = $this->service->update($validated);

        return response()->view('posts.show', compact('post'));
    }

    public function destroy(string $id): Response
    {
        $this->service->delete($id);
        $posts = $this->service->getAll();

        return response()->view('posts.index', [
            'posts' => $posts,
            'message' => 'Post deleted successfully'
        ]);
    }
}
