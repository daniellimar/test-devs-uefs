<?php

namespace App\Http\Pipelines\Users;

use Closure;
use Illuminate\Support\Facades\Hash;

class HashPasswordIfPresent
{
    public function handle(array $data, Closure $next)
    {
        if (isset($data['password']) && $data['password']) {
            $data['password'] = Hash::make($data['password']);
        }

        return $next($data);
    }
}
