<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>All Posts</title>
</head>

<body>
    <h1>All Posts</h1>
    @foreach ($posts as $post)
        <div>
            <h2>{{ $post->title }}</h2>
            <p>{{ $post->content }}</p>
            <a href="{{ route('posts.show', $post->id) }}">View Post</a>
        </div>
    @endforeach
    <br>
    <a href="{{ route('posts.create') }}">Create New Post</a>
</body>

</html>
