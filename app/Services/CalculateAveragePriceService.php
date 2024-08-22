<?php 

namespace App\Services;

class CalculateAveragePriceService
{
    /**
     * 計算分攤金額
     * @param array $formattedItems
     * @return array
     */
    public function calculateAveragePrice(array $formattedItems): array
    {
        $averageResult = [];

        collect($formattedItems)->each(function ($item) use (&$averageResult) {
            $totalPrice = $item['price'];
            $payer = $item['payer'];
            $shareMembers = $item['shareMember'];
            $averagePrice = round($totalPrice / count($shareMembers), 2); // 每個人分攤的金額

            // 計算成員間的欠款
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

        if (count($averageResult) > 1) {

            // 取得最多成員參與的分攤項目的 key
            $maxItemKey = $this->getMaxItemKey($averageResult);

            // 調整金額 (若有可相互抵消之項目)
            $offsetAverageResult = $this->offsetAverage($averageResult, $maxItemKey);

            return $offsetAverageResult;
        }

        return $averageResult;
    }

    /**
     * 取得最多成員參與的分攤項目的 key
     * @param array $averageResult
     * @return string
     */
    private function getMaxItemKey(array $averageResult): string
    {
        $maxItemKey = collect($averageResult)
            ->keys()
            ->reduce(function ($carry, $key) use ($averageResult) {
                return count($averageResult[$key]) > (isset($averageResult[$carry]) ? count($averageResult[$carry]) : 0)
                    ? $key : $carry;
            }, '');

        return $maxItemKey;
    }

    /**
     * 調整金額 (若有可相互抵消之項目)
     * @param array $averageResult
     * @param string $maxItemKey
     * @return array
     */
    private function offsetAverage(array $averageResult, string $maxItemKey): array
    {
        collect($averageResult)->each(function ($item, $key) use (&$averageResult, $maxItemKey) {

            if ($key !== $maxItemKey) {

                collect($item)->each(function ($value, $itemKey) use (&$averageResult, $key, $maxItemKey) {

                    if (isset($averageResult[$maxItemKey][$key]) && isset($averageResult[$maxItemKey][$itemKey])) {
                        $averageResult[$maxItemKey][$key] -= $value;
                        $averageResult[$maxItemKey][$itemKey] += $value;
                        unset($averageResult[$key][$itemKey]);
        
                        if ($averageResult[$maxItemKey][$key] == 0) {
                            unset($averageResult[$maxItemKey][$key]);
                        }
        
                        if ($averageResult[$maxItemKey][$itemKey] == 0) {
                            unset($averageResult[$maxItemKey][$itemKey]);
                        }
                    }
                });
            }
        });

        return $averageResult;
    }
}