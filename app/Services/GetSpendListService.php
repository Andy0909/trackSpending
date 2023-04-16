<?php 

namespace App\Services;

use App\Repositories\MemberRepository;

class GetSpendListService
{
    /**
     * formatItems
     * @param object $items
     * @return array $itemInformation
     */
    public function formatItems(object $items): array
    {
        $memberRepository = new MemberRepository;
        $itemName = '';
        $itemInformationKey = -1;
        $itemInformation = [];

        foreach ($items as $item) {
            if ($item['item_name'] != $itemName) {
                $shareMember = [];
                $itemInformationKey += 1;
                $itemInformation[$itemInformationKey]['itemKey'] = $item['id'];
                $itemInformation[$itemInformationKey]['eventId'] = $item['event_id'];
                $itemInformation[$itemInformationKey]['itemName'] = $item['item_name'];
                $itemInformation[$itemInformationKey]['price'] = $item['price'];
                $payer = $memberRepository->getMemberById($item['payer'])['name'];
                $itemInformation[$itemInformationKey]['payer'] = $payer;
            }

            array_push($shareMember, $memberRepository->getMemberById($item['share_member'])['name']);
            $itemInformation[$itemInformationKey]['shareMember'] = $shareMember;
            $itemName = $item['item_name'];
        }

        return $itemInformation;
    }
}