<?php 

namespace App\Services;

class CalculateAveragePriceService
{
    /**
     * 計算分攤金額
     * @param array $formattedItems
     * @return array $result
     */
    public function calculateAveragePrice(array $formattedItems): array
    {
        $averageResult = [];

        collect($formattedItems)->each(function ($item) use (&$averageResult) {
            $totalPrice = $item['price'];
            $payer = $item['payer'];
            $shareMembers = $item['shareMember'];
            $averagePrice = round($totalPrice / count($shareMembers), 2); // 每個人分攤的金額

            foreach ($shareMembers as $member) {
                if ($member !== $payer) {
                    if (isset($averageResult[$payer][$member])) {
                        $averageResult[$payer][$member] = $averageResult[$payer][$member] + $averagePrice;
                    } elseif (isset($averageResult[$member][$payer])) {
                        $averageResult[$member][$payer] = $averageResult[$member][$payer] - $averagePrice;
                    } else {
                        $averageResult[$payer][$member] = $averagePrice;
                    }
                }
            }
        });

        $count = 0;
        $maxItemKey = '';

        foreach ($averageResult as $key => $item) {
            if (count($item) > $count) {
                $count = count($item);
                $maxItemKey = $key;
            }
        }

        foreach ($averageResult as $key => $item) {

            foreach ($item as $itemKey => $value) {

                if ($key !== $maxItemKey) {
                    if (isset($averageResult[$maxItemKey][$key]) && isset($averageResult[$maxItemKey][$itemKey])) {
                        $averageResult[$maxItemKey][$key] -= $value;
                        $averageResult[$maxItemKey][$itemKey] += $value;
                        unset($averageResult[$key][$itemKey]);
                    }
                }
            }
        }

        return $averageResult;
    }
}