<?php

namespace App\Services\CRM\Orders;

use App\Models\GMP033;
use Illuminate\Support\Collection;

class DemonstrativeService
{
    public function __construct(
        public string $start,
        public string $end,
    )
    {}
    public function getDataIndicators(): array
    {
        $payload = $this->getData();
        $payload_last = $this->getData(true);
        $data = [
            'total_sales' =>  $payload->sum('GMP033_Venda_Total'),
            'cost_total' =>  $payload->sum('GMP033_Custo_Total'),
            'profit' => $payload->sum('GMP033_Lucro'),
            'margin' => $this->getValuePercentage($payload->sum('GMP033_Lucro'),$payload->sum('GMP033_Venda_Total'), false, true),
            'ipv' => $this->getValuePercentage($payload->sum('GMP033_Venda_Total'),$payload->sum('GMP033_Custo_Total'),true),
            'total_sales_last' => $payload_last->sum('GMP033_Venda_Total'),
            'cost_total_last' => $payload_last->sum('GMP033_Custo_Total'),
            'profit_last' => $payload_last->sum('GMP033_Lucro'),
            'margin_last' => $this->getValuePercentage($payload_last->sum('GMP033_Lucro'),$payload_last->sum('GMP033_Venda_Total'), false, true),
            'ipv_last' => $this->getValuePercentage($payload_last->sum('GMP033_Venda_Total'),$payload_last->sum('GMP033_Custo_Total'),true),
            'variation_sales' => 0,
            'variation_sales_is_negative' => false,
            'variation_cost' => 0,
            'variation_cost_is_negative' => false,
            'variation_profit' => 0,
            'variation_profit_is_negative' => false,
            'variation_margin' => 0,
            'variation_margin_is_negative' => false,
            'variation_ipv' => 0,
            'variation_ipv_is_negative' => false,
        ];

        $data['variation_sales'] = $this->getValuePercentage($data['total_sales'], $data['total_sales_last']);
        $data['variation_sales_is_negative'] = $data['variation_sales'] > 0 ? true : false;
        $data['variation_cost'] = $this->getValuePercentage($data['cost_total'], $data['cost_total_last']);
        $data['variation_cost_is_negative'] = $data['variation_cost'] >0 ? true : false;
        $data['variation_profit'] = $this->getValuePercentage($data['profit'], $data['profit_last']);
        $data['variation_profit_is_negative'] = $data['variation_profit'] >0 ? true : false;
        $data['variation_margin'] = $this->getValuePercentage($data['margin'], $data['margin_last']);
        $data['variation_margin_is_negative'] = $data['variation_margin'] >0 ? true : false;
        $data['variation_ipv'] = $this->getValuePercentage($data['ipv'], $data['ipv_last'], true);
        $data['variation_ipv_is_negative'] = $data['variation_ipv'] >0 ? true : false;

        return  $data;
    }
    private function getValuePercentage(?float $firstValue = 0, ?float $secondValue = 0, bool $is_ipv = false, $is_variation = false): float
    {
        if($is_ipv){

            return ($firstValue != 0) ? $firstValue/$secondValue : 0;
        }
        if($is_variation){

            return ($firstValue != 0) ? ($firstValue/$secondValue) * 100 : 0;
        }
        return ($firstValue != 0) ? (($firstValue/$secondValue)-1) * 100 : 0;
    }

    public function getDataChart($start, $end)
    {
        $payload = $this->getData();
        $payload_last = $this->getData(true);
//        dd($payload_last[1]);
        $start = new \DateTime($start);
        $end = (new \DateTime($end));

        $is_grouped = $start->diff($end)->days > 31 ? true : false;

        $interval = new \DateInterval('P1D');
        $dateranger = new \DatePeriod($start, $interval, $end);

        $arr = [];

        $type_index = $is_grouped ? 'month' : 'days';

        foreach ($dateranger as $range){

            $search = $is_grouped ?  'Y-m' : 'Y-m-d';

            $index = array_search($range->format($search), array_column($arr, $type_index));

            if($index === false){

                $arr[] =[
                    $type_index =>  $range->format($search),
                    'total_sales' =>  $payload->filter(fn($p) => (new \DateTime($p->GMP033_Data_Emissao))->format($search) == $range->format($search))->sum('GMP033_Venda_Total'),
                    'cost_total' => $payload->filter(fn($p) => (new \DateTime($p->GMP033_Data_Emissao))->format($search) == $range->format($search))->sum('GMP033_Custo_Total'),
                    'profit' => $payload->filter(fn($p) => (new \DateTime($p->GMP033_Data_Emissao))->format($search) == $range->format($search))->sum('GMP033_Lucro'),
                    'margin' => 0,
                    'ipv' => 0,
                    'total_sales_last' => $payload_last->filter(fn($p) => (new \DateTime($p->GMP033_Data_Emissao))->format($search) == $range->modify('-1 months')->format($search))->sum('GMP033_Venda_Total'),
                    'cost_total_last' => $payload_last->filter(fn($p) => (new \DateTime($p->GMP033_Data_Emissao))->format($search) == $range->modify('-1 months')->format($search))->sum('GMP033_Custo_Total'),
                    'profit_last' => $payload_last->filter(fn($p) => (new \DateTime($p->GMP033_Data_Emissao))->format($search) == $range->modify('-1 months')->format($search))->sum('GMP033_Lucro'),
                    'margin_last' => 0,
                    'ipv_last' => 0,
                ];
            }
        }

        return $arr;
    }
    private function getData(bool $periods_comparison = false, string $type = 'months', int $quanity = 1): Collection
    {
        if($periods_comparison){

            $this->start = (new \DateTime($this->start))->modify("-{$quanity} {$type}")->format('Y-m-d');
            $this->end = (new \DateTime($this->end))->modify("-{$quanity} {$type}")->modify("+1 days")->format('Y-m-d');
        }

        return GMP033::query()
            ->select('gmp033.*', 'T005_T005_Id_Agrupado', 'T005_Canal_Vendas_Ecommerce','T005_Nome_Status') // Ou especifique apenas as colunas que precisa
            ->whereBetween('GMP033_Data_Emissao', [$this->start, $this->end])
            ->join('T005', function($join) {
                $join->on('T005.T005_Id', '=', 'gmp033.GMP033_T005_Id')
                    ->where('T005.T005_Nome_Status', '!=', 'Cancelado')
                    ->where('gmp033.GMP033_Flag_Orcamento', 'N')
                    ->where('T005.T005_Canal_Vendas_Ecommerce', 'not like', '%SAC%')
                    ->where(function($q) {
                        $q->where('T005.T005_T005_Id_Agrupado', '<=', 1)
                            ->orWhereNull('T005.T005_T005_Id_Agrupado');
                    });
            })
            ->get();
    }

}
