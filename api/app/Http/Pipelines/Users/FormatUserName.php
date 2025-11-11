<?php

namespace App\Http\Pipelines\Users;

use Closure;

class FormatUserName
{
    public function handle(array $data, Closure $next)
    {
        if (isset($data['name'])) {
            $data['name'] = ucwords(strtolower($data['name']));
        }

        return $next($data);
    }
}
