<?php

namespace App\Providers;

use App\Models\User;
use App\Policies\UserPolicy;

class AuthServiceProvider
{
    protected $policies = [
        User::class => UserPolicy::class,
    ];

}
