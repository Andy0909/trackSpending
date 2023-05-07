<?php 

namespace App\Services;

class CalculateAveragePrice
{
    /**
     * calculateAveragePrice
     * @param array $spendList
     * @return array $result
     */
    public function calculateAveragePrice(array $spendList): array
    {
        $result = [];

        foreach ($spendList as $key => $value) {
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

    private function simplifyResult($result)
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