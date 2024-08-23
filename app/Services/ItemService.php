<?php 

namespace App\Services;

use App\Repositories\ItemRepository;
use App\Models\Item;

class ItemService
{
    /** @var ItemRepository */
    private $itemRepository;

    /**
     * construct
     * @param ItemRepository $itemRepository
     */
    public function __construct(ItemRepository $itemRepository) 
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * 利用 event id 取得 event 資料
     * @param int $eventId
     * @return Item[]
     */
    public function getItemByEventId(int $eventId): array
    {
        return $this->itemRepository->getItemByEventId($eventId);
    }

    /**
     * 取得最後一個項目的 id
     * @return int
     */
    public function getLastItemId(): int
    {
        return $this->itemRepository->getLastItemId();
    }
    
    /**
     * 新增 item 資料
     * @param array $itemData
     * @return Item
     */
    public function createItem(array $itemData): Item
    {
        return $this->itemRepository->createItem($itemData);
    }

    /**
     * 刪除 item
     * @param int $eventId
     * @param int $itemId
     * @return int
     */
    public function deleteItemByEventIdAndItemId(int $eventId, int $itemId): int
    {
        return $this->itemRepository->deleteItemByEventIdAndItemId($eventId, $itemId);
    }
}