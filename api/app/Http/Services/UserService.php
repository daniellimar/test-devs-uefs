<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\Contracts\UserRepositoryInterface;
use Illuminate\Pipeline\Pipeline;
use App\Http\Pipelines\Users\{
    ClearData,
    FormatUserName,
    ValidateCorporateEmail,
    HashPasswordIfPresent,
    SetDefaultActiveFlag
};

class UserService
{
    public function __construct(protected UserRepositoryInterface $users)
    {
    }

    public function listAll()
    {
        return $this->users->all();
    }

    public function create(array $data): User
    {
        $processed = app(Pipeline::class)
            ->send($data)
            ->through([
                ClearData::class,
                FormatUserName::class,
                ValidateCorporateEmail::class,
                HashPasswordIfPresent::class,
                SetDefaultActiveFlag::class,
            ])
            ->thenReturn();

        return $this->users->create($processed);
    }

    public function update(User $user, array $data)
    {
        $processed = app(Pipeline::class)
            ->send($data)
            ->through([
                ClearData::class,
                FormatUserName::class,
                ValidateCorporateEmail::class,
                HashPasswordIfPresent::class,
                SetDefaultActiveFlag::class,
            ])
            ->thenReturn();

        return $this->users->update($user, $processed);
    }

    public function delete(User $user)
    {
        return $this->users->delete($user);
    }
}
