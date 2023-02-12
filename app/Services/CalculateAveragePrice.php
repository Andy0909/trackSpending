<?php 

namespace App\Services;

use App\Repositories\MemberRepository;

class CalculateAveragePrice
{
    public function getAveragePriceResult($items)
    {
        $memberRepository = new MemberRepository;
        $itemName = '';
        $itemInformationKey = -1;

        foreach ($items as $item) {
            if ($item['item_name'] != $itemName) {
                $shareMember = [];
                $itemInformationKey += 1;
                $itemInformation[$itemInformationKey]['itemName'] = $item['item_name'];
                $itemInformation[$itemInformationKey]['price'] = $item['price'];
                $payer = $memberRepository->getMemberById($item['payer'])['name'];
                $itemInformation[$itemInformationKey]['payer'] = $payer;
            }

            array_push($shareMember, $memberRepository->getMemberById($item['share_member'])['name']);
            $itemInformation[$itemInformationKey]['shareMember'] = $shareMember;
            $itemName = $item['item_name'];
        }

        return $this->calculateAveragePrice($itemInformation);
    }

    public function calculateAveragePrice($itemInformation)
    {
        $result = [];

        foreach ($itemInformation as $key => $value) {
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