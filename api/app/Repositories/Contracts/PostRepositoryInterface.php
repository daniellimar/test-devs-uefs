<?php

namespace App\Repositories\Contracts;

use App\Models\Post;

interface PostRepositoryInterface
{
    public function all();

    public function create(array $data);

    public function find(Post $post);

    public function update(Post $post, array $data);

    public function delete(Post $post);

    public function syncTags(Post $post, array $tags);
}
