<?php

namespace App\Interfaces;

use App\Models\Item;

interface ItemRepositoryInterface 
{
    /**
     * 利用 event id 取得 item 資料
     * @param int $eventId
     * @return Item[]
     */
    public function getItemByEventId(int $eventId): array;

    /**
     * 取得最後一個 item 的 id
     * @return int
     */
    public function getLastItemId(): int;

    /**
     * 新增 item
     * @param array $itemData
     * @return Item
     */
    public function createItem(array $itemData): Item;

    /**
     * 刪除 item
     * @param int $eventId
     * @param int $itemId
     * @return int
     */
    public function deleteItemByEventIdAndItemId(int $eventId, int $itemId): int;
}