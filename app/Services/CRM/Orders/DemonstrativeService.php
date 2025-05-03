<?php

namespace App\Services\CRM\Orders;

use App\Models\GMP033;
use Illuminate\Support\Collection;

class DemonstrativeService
{
    public function __construct()
    {}
    public function getDataIndicators(string $start, string $end, string $comparasion = 'year'): array
    {
        $currentStart = new \DateTime($start);
        $currentEnd = new \DateTime($end);

        $currentData = $this->getData($currentStart->format('Y-m-d'), $currentEnd->format('Y-m-d'));
        $previousData = $this->getData((clone $currentStart)->modify("-1 {$comparasion}")->format('Y-m-d'), (clone $currentEnd)->modify("-1 {$comparasion}")->format('Y-m-d'));

        $currentSales = $currentData->sum('GMP033_Venda_Total');
        $currentCost = $currentData->sum('GMP033_Custo_Total');
        $currentProfit = $currentData->sum('GMP033_Lucro');
        $currentMargin = $this->getValuePercentage($currentProfit, $currentSales, false, true);
        $currentIpv = $this->getValuePercentage($currentSales, $currentCost, true);

        $previousSales = $previousData->sum('GMP033_Venda_Total');
        $previousCost = $previousData->sum('GMP033_Custo_Total');
        $previousProfit = $previousData->sum('GMP033_Lucro');
        $previousMargin = $this->getValuePercentage($previousProfit, $previousSales, false, true);
        $previousIpv = $this->getValuePercentage($previousSales, $previousCost, true);


        return [

            'total_sales' => $currentSales,
            'cost_total' => $currentCost,
            'profit' => $currentProfit,
            'margin' => $currentMargin,
            'ipv' => $currentIpv,

            'total_sales_last' => $previousSales,
            'cost_total_last' => $previousCost,
            'profit_last' => $previousProfit,
            'margin_last' => $previousMargin,
            'ipv_last' => $previousIpv,

            'variation_sales' => $this->calculateVariation($currentSales, $previousSales)['value'],
            'variation_sales_is_negative' => $this->calculateVariation($currentSales, $previousSales)['is_negative'],
            'variation_cost' => $this->calculateVariation($currentCost, $previousCost)['value'],
            'variation_cost_is_negative' => $this->calculateVariation($currentCost, $previousCost)['is_negative'],
            'variation_profit' => $this->calculateVariation($currentProfit, $previousProfit)['value'],
            'variation_profit_is_negative' => $this->calculateVariation($currentProfit, $previousProfit)['is_negative'],
            'variation_margin' => $this->calculateVariation($currentMargin, $previousMargin, )['value'],
            'variation_margin_is_negative' => $this->calculateVariation($currentMargin, $previousMargin,)['is_negative'],
            'variation_ipv' => $this->calculateVariation($currentIpv, $previousIpv)['value'],
            'variation_ipv_is_negative' => $this->calculateVariation($currentIpv, $previousIpv)['is_negative'],
        ];
    }
    private function calculateVariation($current, $previous,bool $is_ipv = false, $is_variation = false): array
    {
        return [
            'value' => $this->getValuePercentage($current, $previous, $is_ipv, $is_variation),
            'is_negative' => $this->getValuePercentage($current, $previous,$is_ipv, $is_variation) < 0 ? false : true,
        ];
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

    public function getDataChart(string $start, string $end,string $comparasion = 'year'): array
    {


        $currentStart = new \DateTime($start);
        $currentEnd = new \DateTime($end);

        $currentData = $this->getData($currentStart->format('Y-m-d'), $currentEnd->format('Y-m-d'));
        $previousData = $this->getData((clone $currentStart)->modify("-1 {$comparasion}")->format('Y-m-d'), (clone $currentEnd)->modify("-1 {$comparasion}")->format('Y-m-d'));

        $isGrouped = $currentStart->diff($currentEnd)->days > 31;

        $groupFormat = $isGrouped ? 'Y-m' : 'Y-m-d';
        $groupKey = $isGrouped ? 'month' : 'day';

        $results = [];

        $interval = new \DateInterval('P1D');
        $dateRange = new \DatePeriod($currentStart, $interval, $currentEnd->modify('+1 day'));

        foreach ($dateRange as $date) {

            $currentPeriod = $date->format($groupFormat);
            $previousPeriod = (clone $date)->modify("-1 {$comparasion}")->format($groupFormat);

            if (isset($results[$currentPeriod])) {
                continue;
            }

            $currentFilter = function($item) use ($currentPeriod, $groupFormat) {
                return (new \DateTime($item->GMP033_Data_Emissao))->format($groupFormat) === $currentPeriod;
            };

            $previousFilter = function($item) use ($previousPeriod, $groupFormat) {
                return (new \DateTime($item->GMP033_Data_Emissao))->format($groupFormat) === $previousPeriod;
            };

            $currentSales = $currentData->filter($currentFilter)->sum('GMP033_Venda_Total');
            $currentCost = $currentData->filter($currentFilter)->sum('GMP033_Custo_Total');
            $currentProfit = $currentData->filter($currentFilter)->sum('GMP033_Lucro');
            $currentMargin = $currentSales ? ($currentProfit / $currentSales) * 100 : 0;
            $currentIpv = $currentCost ? ($currentSales / $currentCost) * 100 : 0;

            $previousSales = $previousData->filter($previousFilter)->sum('GMP033_Venda_Total');
            $previousCost = $previousData->filter($previousFilter)->sum('GMP033_Custo_Total');
            $previousProfit = $previousData->filter($previousFilter)->sum('GMP033_Lucro');
            $previousMargin = $previousSales ? ($previousProfit / $previousSales) * 100 : 0;
            $previousIpv = $previousCost ? ($previousSales / $previousCost) * 100 : 0;


            // Adiciona ao array de resultados
            $results[$currentPeriod] = [
                $groupKey => $currentPeriod,
                'total_sales' => $currentSales,
                'cost_total' => $currentCost,
                'profit' => $currentProfit,
                'margin' => round($currentMargin, 2),
                'ipv' => round($currentIpv, 2),
                'total_sales_last' => $previousSales,
                'cost_total_last' => $previousCost,
                'profit_last' => $previousProfit,
                'margin_last' => round($previousMargin, 2),
                'ipv_last' => round($previousIpv, 2),
                'sales_variation' => $previousSales ? round((($currentSales - $previousSales) / $previousSales) * 100, 2) : 0,
                'margin_variation' => $previousMargin ? round((($currentMargin - $previousMargin) / $previousMargin) * 100, 2) : 0,
                'ipv_variation' => $previousIpv ? round((($currentIpv - $previousIpv) / $previousIpv) * 100, 2) : 0,
            ];
        }

        return array_values($results);
    }
    private function getData(string $start, string $end): Collection
    {
        return GMP033::query()
            ->select('gmp033.*', 'T005_T005_Id_Agrupado', 'T005_Canal_Vendas_Ecommerce','T005_Nome_Status') // Ou especifique apenas as colunas que precisa
            ->whereBetween('GMP033_Data_Emissao', [$start, $end])
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
