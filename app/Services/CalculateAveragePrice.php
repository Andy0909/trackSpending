<?php 

namespace App\Services;

class CalculateAveragePrice
{
    /**
     * 計算分攤金額
     * @param array $spendList
     * @return array $result
     */
    public function calculateAveragePrice(array $formattedItems): array
    {
        $result = [];

        foreach ($formattedItems as $key => $value) {
            $average = round($value['price'] / count($value['shareMember']), 2);
            $payer = $value['payer'];

            foreach ($value['shareMember'] as $member) {
                if ($member != $payer) {
                    if (!isset($result[$member])) {
                        $result[$member] = [];
                    }

                    if (!isset($result[$member][$payer])) {
                        $result[$member][$payer] = 0;
                    }

                    $result[$member][$payer] -= $average;
                    $result[$payer][$member] = ($result[$payer][$member] ?? 0) + $average;
                }
            }
        }

        return $this->simplifyResult($result);
    }

    /**
     * 簡化回傳資料
     * @param array $result
     * @return array
     */
    private function simplifyResult(array $result): array
    {
        $simplifyResult = [];

        foreach ($result as $payer => $members) {
            foreach ($members as $member => $price) {
                if (!isset($simplifyResult[$member][$payer])) {
                    $simplifyResult[$payer][$member] = $price;
                }
            }
        }

        return $simplifyResult;
    }
}