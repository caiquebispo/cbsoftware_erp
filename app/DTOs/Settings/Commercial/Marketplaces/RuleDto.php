<?php

namespace App\DTOs\Settings\Commercial\Marketplaces;

final readonly class RuleDto
{
  public  function __construct(
      public int $canal,
      public ?float $comissao = 0.00,
      public ?float $custoSac = 0.00,
      public ?bool $comissaoFrete = false,
      public ?bool $multiplicarQt = false,

  )
  {}
    public function withArray(): array
    {
        return [
            'GMP014_GMP015_Id' => $this->canal,
            'GMP014_Comissao' => $this->comissao ?? 0,
            'GMP014_Custo_Sac' => $this->custoSac ?? 0,
            'GMP014_Comissao_Sobre_Frete' => $this->comissaoFrete ? 'S' : 'N',
            'GMP014_Multiplicar_Pela_Quantidade' => $this->multiplicarQt ? 'S' : 'N',
        ];
    }
}
