<?php

namespace App\Repositories;

use App\Interfaces\ItemRepositoryInterface;
use App\Models\Item;

class ItemRepository implements ItemRepositoryInterface 
{
    /**
     * getItemById
     * @param int $itemId
     * @return object
     */
    public function getItemById(int $itemId) 
    {
        return Item::where('id', '=', $itemId)->with('member')->with('item')->get();
    }

    /**
     * getItemByEventId
     * @param int $eventId
     * @return object
     */
    public function getItemByEventId(int $eventId) 
    {
        return Item::where('event_id', '=', $eventId)->get();
    }

    public function getLastItemId()
    {
        return Item::latest('item_id')->first() ?? 0;
    }

    /**
     * createItem
     * @param array $itemData
     * @return void
     */
    public function createItem(array $itemData) 
    {
        return Item::create($itemData);
    }

    /**
     * updateItem
     * @param int $itemId
     * @param array $newItemData
     * @return void
     */
    public function updateItem(int $itemId, array $newItemData) 
    {
        return Item::where('id', '=', $itemId)->update($newItemData);
    }

    /**
     * deleteItemByEventIdAndItemId
     * @param int $eventId
     * @param int $itemId
     * @return void
     */
    public function deleteItemByEventIdAndItemId(int $eventId, int $itemId) 
    {
        return Item::where('event_id', '=', $eventId)->where('item_id', '=', $itemId)->delete();
    }
}