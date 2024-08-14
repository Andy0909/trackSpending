<?php 

namespace App\Services;

use Illuminate\Database\Eloquent\Collection;

class GetSpendListService
{
    /** @var MemberService */
    private $memberService;

    /**
     * construct
     * @param MemberService $memberService
     */
    public function __construct(MemberService $memberService) 
    {
        $this->memberService = $memberService;
    }

    /**
     * formatItems
     * @param Collection $items
     * @return array $itemInformation
     */
    public function formatItems(Collection $items): array
    {
        $itemId = 0;
        $itemInformationKey = -1;
        $itemInformation = [];

        foreach ($items as $item) {
            if ($item['item_id'] != $itemId) {
                $shareMember = [];
                $itemInformationKey += 1;
                $itemInformation[$itemInformationKey]['itemKey'] = $item['id'];
                $itemInformation[$itemInformationKey]['itemId'] = $item['item_id'];
                $itemInformation[$itemInformationKey]['eventId'] = $item['event_id'];
                $itemInformation[$itemInformationKey]['itemName'] = $item['item_name'];
                $itemInformation[$itemInformationKey]['price'] = $item['price'];
                $payer = $this->memberService->getMemberById($item['payer'])['name'];
                $itemInformation[$itemInformationKey]['payer'] = $payer;
            }

            array_push($shareMember, $this->memberService->getMemberById($item['share_member'])['name']);
            $itemInformation[$itemInformationKey]['shareMember'] = $shareMember;
            $itemId = $item['item_id'];
        }

        return $itemInformation;
    }
}