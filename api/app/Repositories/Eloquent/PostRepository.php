<?php

namespace App\Repositories\Eloquent;

use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;

class PostRepository implements PostRepositoryInterface
{
    public function all()
    {
        return Post::with(['tags', 'user'])->get();
    }

    public function create(array $data)
    {
        return Post::create($data);
    }

    public function find(Post $post)
    {
        return $post->load(['tags', 'user']);
    }

    public function update(Post $post, array $data)
    {
        $post->update($data);
        return $post;
    }

    public function delete(Post $post)
    {
        return $post->delete();
    }

    public function syncTags(Post $post, array $tags)
    {
        $post->tags()->sync($tags);
        return $post;
    }
}
