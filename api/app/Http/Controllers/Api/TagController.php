<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\TagRequest;
use App\Http\Resources\TagResource;
use App\Models\Tag;
use App\Services\TagService;

class TagController extends Controller
{
    public function __construct(protected TagService $service)
    {
//        $this->authorizeResource(Tag::class, 'tag');
    }

    public function index()
    {
        return TagResource::collection($this->service->listAll());
    }

    public function store(TagRequest $request)
    {
        $tag = $this->service->create($request->validated());
        return new TagResource($tag);
    }

    public function update(TagRequest $request, Tag $tag)
    {
        $this->service->update($tag, $request->validated());
        return new TagResource($tag);
    }

    public function destroy(Tag $tag)
    {
        $this->service->delete($tag);
        return response()->noContent();
    }
}
