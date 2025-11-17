<?php

namespace App\Repositories\Eloquent;

use App\Models\Tag;
use App\Repositories\Contracts\TagRepositoryInterface;

class TagRepository implements TagRepositoryInterface
{
    public function all()
    {
        return Tag::all();
    }

    public function create(array $data)
    {
        return Tag::create($data);
    }

    public function update(Tag $tag, array $data)
    {
        $tag->update($data);
        return $tag;
    }

    public function delete(Tag $tag)
    {
        return $tag->delete();
    }
}
