<?php

namespace App\Services\Settings\Commercial;

use App\DTOs\Settings\Commercial\Marketplaces\RuleDto;
use App\Exception\RuleSaveException;
use App\Models\GMP014;

class RuleService
{
    public function __construct(
       public GMP014 $rules
    )
    {}

    /**
     * @throws RuleSaveException
     */
    public function store(RuleDto $rule)
    {
        try {
            return $this->rules->query()->create($rule->withArray());

        } catch (\Throwable $e) {

            throw new RuleSaveException('Erro ao salvar regra, favor contatar o tecnico! ', 500, $e);
        }
    }
}
