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
     * 利用 id 取得 item 資料
     * @param int $itemId
     * @return Item[]
     */
    public function getItemById(int $itemId): array
    {
        return $this->itemRepository->getItemById($itemId);
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
     * 更新 item 資料
     * @param int $itemId
     * @param array $newItemData
     */
    public function updateItem(int $itemId, array $newItemData)
    {
        return $this->itemRepository->updateItem($itemId, $newItemData);
    }

    /**
     * 刪除 item 資料
     * @param int $eventId
     * @param int $itemId
     */
    public function deleteItemByEventIdAndItemId(int $eventId, int $itemId)
    {
        return $this->itemRepository->deleteItemByEventIdAndItemId($eventId, $itemId);
    }
}