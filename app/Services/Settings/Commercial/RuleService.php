<?php

namespace App\Services\Settings\Commercial;

use App\DTOs\Settings\Commercial\Marketplaces\RuleDto;
use App\Models\GMP014;

class RuleService
{
    public function __construct(
       public GMP014 $rules
    )
    {}
    public function store(RuleDto $rule)
    {
        try {
            return $this->rules->query()->create($rule->withArray());

        } catch (\Throwable $e) {

            throw new \RuntimeException('Erro ao salvar regra: ' . $e->getMessage(), 500, $e);
        }
    }
}
