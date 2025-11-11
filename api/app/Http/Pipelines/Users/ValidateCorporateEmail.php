<?php

namespace App\Http\Pipelines\Users;

use Closure;
use Exception;

class ValidateCorporateEmail
{
    private string $corporateDomain;

    public function __construct()
    {
        $this->corporateDomain = config('corporate.domain', 'postflow.com');
    }

    /**
     * @throws Exception
     */
    public function handle(array $data, Closure $next)
    {
        if (!isset($data['email'])) {
            throw new Exception("O e-mail é obrigatório.");
        }

        $domain = strtolower(substr(strrchr($data['email'], "@"), 1));

        if ($domain !== $this->corporateDomain) {
            throw new Exception("O e-mail '{$data['email']}' não pertence ao domínio corporativo '{$this->corporateDomain}'.");
        }

        return $next($data);
    }
}
