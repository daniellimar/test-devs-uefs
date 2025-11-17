<?php

namespace App\Services;

use App\Models\Tag;
use App\Repositories\Contracts\TagRepositoryInterface;

class TagService
{
    public function __construct(
        protected TagRepositoryInterface $repository
    )
    {
    }

    public function listAll()
    {
        return $this->repository->all();
    }

    public function create(array $data)
    {
        return $this->repository->create($data);
    }

    public function update(Tag $tag, array $data)
    {
        return $this->repository->update($tag, $data);
    }

    public function delete(Tag $tag)
    {
        return $this->repository->delete($tag);
    }
}
