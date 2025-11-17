<?php

namespace App\Repositories\Contracts;

use App\Models\Tag;

interface TagRepositoryInterface
{
    public function all();

    public function create(array $data);

    public function update(Tag $tag, array $data);

    public function delete(Tag $tag);
}
