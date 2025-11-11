<?php

namespace App\Http\Pipelines\Users;

use Closure;

class SetDefaultActiveFlag
{
    public function handle(array $data, Closure $next)
    {
        if (!isset($data['active'])) {
            $data['active'] = true;
        }

        return $next($data);
    }
}
