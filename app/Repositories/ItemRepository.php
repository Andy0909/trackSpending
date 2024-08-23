<?php

namespace App\Repositories;

use App\Interfaces\ItemRepositoryInterface;
use App\Models\Item;

class ItemRepository implements ItemRepositoryInterface 
{
    /** @var Item */
    private $itemModel;

    /**
     * construct
     * @param Item $itemModel
     */
    public function __construct(Item $itemModel) 
    {
        $this->itemModel = $itemModel;
    }

    /**
     * 利用 event id 取得 item 資料
     * @param int $eventId
     * @return Item[]
     */
    public function getItemByEventId(int $eventId): array
    {
        return $this->itemModel
            ->newQuery()
            ->where('event_id', $eventId)
            ->get()
            ->all();
    }

    /**
     * 取得最後一個 item 的 id
     * @return int
     */
    public function getLastItemId(): int
    {
        $lastItem = $this->itemModel
            ->newQuery()
            ->latest('item_id')
            ->first();

        return $lastItem->item_id ?? 0;
    }

    /**
     * 新增 item
     * @param array $itemData
     * @return Item
     */
    public function createItem(array $itemData): Item
    {
        return $this->itemModel
            ->newQuery()
            ->create($itemData);
    }

    /**
     * 刪除 item
     * @param int $eventId
     * @param int $itemId
     * @return int
     */
    public function deleteItemByEventIdAndItemId(int $eventId, int $itemId): int
    {
        return $this->itemModel
            ->newQuery()
            ->where('event_id', $eventId)
            ->where('item_id', $itemId)
            ->delete();
    }
}