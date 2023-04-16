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
            foreach ($value['shareMember'] as $member) {
                if ($member != $value['payer']) {
                    if (count($result) > 0) {
                        if (isset($result[$member])) {
                            if (isset($result[$member][$value['payer']])) {
                                $result[$member][$value['payer']] -= $average;
                            } 
                            else {
                                $result[$member][$value['payer']] = -$average;
                            }
                        } 
                        elseif (isset($result[$value['payer']][$member])) {
                            $result[$value['payer']][$member] += $average;
                        }  
                        else {
                            $result[$value['payer']][$member] = $average;
                        }
                    } 
                    else {
                        $result[$value['payer']][$member] = $average;
                    }
                }
            }
        }

        return $result;
    }
}