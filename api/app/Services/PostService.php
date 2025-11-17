<?php

namespace App\Services;

use App\Models\Post;
use App\Repositories\Contracts\PostRepositoryInterface;

class PostService
{
    public function __construct(
        protected PostRepositoryInterface $repository
    )
    {
    }

    public function list()
    {
        return $this->repository->all();
    }

    public function create(array $data)
    {
        $post = $this->repository->create($data);

        if (!empty($data['tags'])) {
            $this->repository->syncTags($post, $data['tags']);
        }

        return $this->repository->find($post);
    }

    public function show(Post $post)
    {
        return $this->repository->find($post);
    }

    public function update(Post $post, array $data)
    {
        $post = $this->repository->update($post, $data);

        if (!empty($data['tags'])) {
            $this->repository->syncTags($post, $data['tags']);
        }

        return $this->repository->find($post);
    }

    public function delete(Post $post)
    {
        return $this->repository->delete($post);
    }
}
