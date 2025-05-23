<?php

namespace App\Services\CRM\Orders;

use App\Models\GMP033;
use Illuminate\Support\Collection;
use JetBrains\PhpStorm\ArrayShape;

class DemonstrativeService
{
    public function __construct()
    {}

    /**
     * @param string $start
     * @param string $end
     * @param string $comparasion
     * @return array
     * @throws \DateMalformedStringException
     */
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
    #[ArrayShape(['value' => "float", 'is_negative' => "bool"])]
    private function calculateVariation($current, $previous, bool $is_ipv = false, $is_variation = false): array
    {
        return [
            'value' => $this->getValuePercentage($current, $previous, $is_ipv, $is_variation),
            'is_negative' => $this->getValuePercentage($current, $previous,$is_ipv, $is_variation) < 0 ? false : true,
        ];
    }

    /**
     * @param float|null $firstValue
     * @param float|null $secondValue
     * @param bool $is_ipv
     * @param $is_variation
     * @return float
     */
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

    /**
     * @param string $start
     * @param string $end
     * @param string $comparasion
     * @return array
     * @throws \DateMalformedPeriodStringException
     * @throws \DateMalformedStringException
     */
    public function getDataChart(string $start, string $end, string $comparasion = 'year'): array
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

    /**
     * @param string $start
     * @param string $end
     * @param $isGrouped
     * @return array
     * @throws \DateMalformedStringException
     */
    public function getDataTable(string $start, string $end, $isGrouped = false): array
    {
        $isGrouped = $isGrouped == "true" ? true : false;

        $currentStart = new \DateTime($start);
        $currentEnd = new \DateTime($end);

        $array = [];

        $data = $this->getData($currentStart->format('Y-m-d'), $currentEnd->format('Y-m-d'));

        foreach ($data as $key => $item) {

            if($isGrouped){

                $index = array_search($item->GMP033_Data_Emissao, array_column($array, 'data_emissao'));

                $array = $this->makeDataGrouped($index, $key, $item, $array);

            }else{
                $array = $this->makeDataBase($key, $item, $array);
            }

        }
        return  $array;

    }

    /**
     * @param false|int|string $index
     * @param int|string|null $key
     * @param mixed $item
     * @param array $array
     * @return array
     */
    private function makeDataGrouped(false|int|string $index, int|string|null $key, mixed $item, array $array): array
    {
        if ($index === false) {
            $array[] = [
                'id' => $key,
                'data_emissao' => $item->GMP033_Data_Emissao,
                'cod_order' => $item->GMP033_T005_Id,
                'cod_product' => $item->D001_Codigo_Produto,
                'id_product'=>$item->GMP033_T006_Id,
                'name'=> $item->T006_Descricao_Produto,
                'total_sales' => $item->GMP033_Venda_Total,
                'cost_total' => $item->GMP033_Custo_Total,
                'profit' => $item->GMP033_Lucro,
                'margin' => ($item->GMP033_Venda_Total != 0) ? ($item->GMP033_Lucro / $item->GMP033_Venda_Total) * 100 : 0,
                'ipv' => ($item->GMP033_Custo_Total != 0) ? ($item->GMP033_Venda_Total / $item->GMP033_Custo_Total) : 0,
                'resume' => [
                    [
                        'total_sales' => $item->GMP033_Venda_Total,
                        'cod_order' => $item->GMP033_T005_Id,
                        'cod_product' => $item->D001_Codigo_Produto,
                        'id_product'=>$item->GMP033_T006_Id,
                        'name'=> $item->T006_Descricao_Produto,
                        'cost_total' => $item->GMP033_Custo_Total,
                        'profit' => $item->GMP033_Lucro,
                        'margin' => ($item->GMP033_Venda_Total != 0) ? ($item->GMP033_Lucro / $item->GMP033_Venda_Total) * 100 : 0,
                        'ipv' => ($item->GMP033_Custo_Total != 0) ? ($item->GMP033_Venda_Total / $item->GMP033_Custo_Total) : 0,
                    ]
                ]
            ];
        } else {
            $array[$index]['total_sales'] += $item->GMP033_Venda_Total;
            $array[$index]['cost_total'] += $item->GMP033_Custo_Total;
            $array[$index]['profit'] += $item->GMP033_Lucro;
            $array[$index]['margin'] = ($array[$index]['total_sales'] != 0) ? ($array[$index]['profit'] / $array[$index]['total_sales']) * 100 : 0;
            $array[$index]['ipv'] = ($array[$index]['cost_total'] != 0) ? ($array[$index]['total_sales'] / $array[$index]['cost_total']) : 0;
            $array[$index]['resume'][] = [
                'total_sales' => $array[$index]['total_sales'],
                'cost_total' => $array[$index]['cost_total'],
                'profit' => $array[$index]['profit'],
                'margin' => ($array[$index]['total_sales'] != 0) ? ($array[$index]['profit'] / $array[$index]['total_sales']) * 100 : 0,
                'ipv' => ($array[$index]['cost_total'] != 0) ? ($array[$index]['total_sales'] / $array[$index]['cost_total']) : 0,
            ];
        }
        return $array;
    }

    /**
     * @param int|string|null $key
     * @param mixed $item
     * @param array $array
     * @return array
     */
    private function makeDataBase(int|string|null $key, mixed $item, array $array): array
    {
        $array[] = [
            'id' => $key,
            'data_emissao' => $item->GMP033_Data_Emissao,
            'cod_order' => $item->GMP033_T005_Id,
            'cod_product' => $item->D001_Codigo_Produto,
            'id_product'=>$item->GMP033_T006_Id,
            'name'=> $item->T006_Descricao_Produto,
            'total_sales' => $item->GMP033_Venda_Total,
            'cost_total' => $item->GMP033_Custo_Total,
            'profit' => $item->GMP033_Lucro,
            'margin' => ($item->GMP033_Venda_Total != 0) ? ($item->GMP033_Lucro / $item->GMP033_Venda_Total) * 100 : 0,
            'ipv' => ($item->GMP033_Custo_Total != 0) ? ($item->GMP033_Venda_Total / $item->GMP033_Custo_Total) : 0,
        ];
        return $array;
    }

    /**
     * @param string $start
     * @param string $end
     * @return Collection
     */
    private function getData(string $start, string $end): Collection
    {
        return GMP033::query()
            ->select('gmp033.*', 'T005_T005_Id_Agrupado', 'T005_Canal_Vendas_Ecommerce','T005_Nome_Status','D001_Codigo_Produto','T005_Canal_Vendas_Ecommerce','T006_Descricao_Produto')
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
            ->leftJoin('T006', 'T006_Id', '=', 'GMP033_T006_Id')
            ->leftJoin('D009', 'D009_Id', '=', 'T006_D009_Id')
            ->leftJoin('D049', 'D049_Id', '=', 'D009_D049_Id')
            ->leftJoin('D082', 'D082_Id', '=', 'D049_D082_Id')
            ->leftJoin('D001', 'D001_Id', '=', 'D049_D001_Id')
            ->leftJoin('D001A', 'D001A_D001_Id', '=', 'D001_Id')
            ->get();
    }


}
