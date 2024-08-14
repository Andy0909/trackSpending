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
     * 利用 id 取得 item 資料
     * @param int $itemId
     * @return Item[]
     */
    public function getItemById(int $itemId): array
    {
        return $this->itemModel
            ->newQuery()
            ->where('id', $itemId)
            ->with('member')
            ->with('item')
            ->get()
            ->all();
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
     */
    public function createItem(array $itemData)
    {
        return $this->itemModel
            ->newQuery()
            ->create($itemData);
    }

    /**
     * 更新 item
     * @param int $itemId
     * @param array $newItemData
     */
    public function updateItem(int $itemId, array $newItemData) 
    {
        return $this->itemModel
            ->newQuery()
            ->where('id', $itemId)
            ->update($newItemData);
    }

    /**
     * 刪除 item
     * @param int $eventId
     * @param int $itemId
     */
    public function deleteItemByEventIdAndItemId(int $eventId, int $itemId) 
    {
        return $this->itemModel
            ->newQuery()
            ->where('event_id', $eventId)
            ->where('item_id', $itemId)
            ->delete();
    }
}