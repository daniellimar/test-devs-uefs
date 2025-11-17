<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Http\Resources\PostResource;
use App\Models\Post;
use App\Services\PostService;

class PostController extends Controller
{
    public function __construct(
        protected PostService $service
    )
    {
    }

    public function index()
    {
        return PostResource::collection(
            $this->service->list()
        );
    }

    public function store(PostRequest $request)
    {
        $post = $this->service->create($request->validated());
        return new PostResource($post);
    }

    public function show(Post $post)
    {
        return new PostResource(
            $this->service->show($post)
        );
    }

    public function update(PostRequest $request, Post $post)
    {
        $post = $this->service->update($post, $request->validated());
        return new PostResource($post);
    }

    public function destroy(Post $post)
    {
        $this->service->delete($post);
        return response()->noContent();
    }
}
