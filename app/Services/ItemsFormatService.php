<?php 

namespace App\Services;

use App\Models\Item;
use Illuminate\Database\Eloquent\Collection;

class ItemsFormatService
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
     * @return array $processedItems
     */
    public function formatItems(Collection $items): array
    {
        $grouped = $items->groupBy('item_id');

        $formattedItems = $grouped->map(function (Collection $items) {

            $item = $items->first();

            return [
                'eventId'     => $item->event_id,
                'itemId'      => $item->item_id,
                'itemName'    => $item->item_name,
                'price'       => $item->price,
                'payer'       => $this->memberService->getMemberById($item->payer)['name'],
                'shareMember' => $items->map(function(Item $item) {
                    return $this->memberService->getMemberById($item->share_member)['name'];
                })->all(),
            ];

        })->toArray();

        return $formattedItems;
    }
}