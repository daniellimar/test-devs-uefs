<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\UserService;

class UserController extends Controller
{
    public function __construct(protected UserService $service)
    {
    }

    public function index()
    {
        return UserResource::collection($this->service->listAll());
    }

    public function store(UserRequest $request)
    {
        $user = $this->service->create($request->validated());
        return new UserResource($user);
    }

    public function update(UserRequest $request, User $user)
    {
        $this->service->update($user, $request->validated());
        return new UserResource($user);
    }

    public function destroy(User $user)
    {
        $this->service->delete($user);
        return response()->noContent();
    }
}
