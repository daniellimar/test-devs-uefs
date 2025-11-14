<?php

namespace App\Policies;

use App\Models\User;

class UserPolicy
{
    public function viewAny(User $authUser): bool
    {
        return true;
    }

    public function view(User $authUser, User $model): bool
    {
        return $authUser->id === $model->id;
    }

    public function create(User $authUser): bool
    {
        return true;
    }

    public function update(User $authUser, User $model): bool
    {
        return $authUser->id === $model->id;
    }

    public function delete(User $authUser, User $model): bool
    {
        return $authUser->id === $model->id;
    }
}
