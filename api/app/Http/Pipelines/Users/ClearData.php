<?php

namespace App\Http\Pipelines\Users;

use Closure;

class ClearData
{
    public function handle(array $data, Closure $next)
    {
        $allowedFields = ['name', 'email', 'password', 'active'];
        $cleanData = [];

        if (isset($data['name'])) {
            $cleanData['name'] = trim($data['name']);
        }

        if (isset($data['email'])) {
            $cleanData['email'] = strtolower(trim($data['email']));
        }

        if (isset($data['password'])) {
            $cleanData['password'] = $data['password'];
        }

        if (isset($data['active'])) {
            $cleanData['active'] = (bool)$data['active'];
        }

        $cleanData = array_intersect_key($cleanData, array_flip($allowedFields));

        return $next($cleanData);
    }
}
