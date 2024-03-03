<?php

namespace App\Repositories;

use App\Interfaces\ItemRepositoryInterface;
use App\Models\Item;

class ItemRepository implements ItemRepositoryInterface 
{
    /**
     * getItemById
     * @param string $itemId
     */
    public function getItemById(string $itemId)
    {
        return Item::where('id', '=', $itemId)->with('member')->with('item')->get();
    }

    /**
     * getItemByEventId
     * @param string $eventId
     */
    public function getItemByEventId(string $eventId)
    {
        return Item::where('event_id', '=', $eventId)->get();
    }

    /**
     * getLastItemId
     */
    public function getLastItemId()
    {
        return Item::latest('item_id')->first() ?? '0';
    }

    /**
     * createItem
     * @param array $itemData
     */
    public function createItem(array $itemData)
    {
        return Item::create($itemData);
    }

    /**
     * updateItem
     * @param string $itemId
     * @param array $newItemData
     */
    public function updateItem(string $itemId, array $newItemData) 
    {
        return Item::where('id', '=', $itemId)->update($newItemData);
    }

    /**
     * deleteItemByEventIdAndItemId
     * @param string $eventId
     * @param string $itemId
     */
    public function deleteItemByEventIdAndItemId(string $eventId, string $itemId) 
    {
        return Item::where('event_id', '=', $eventId)->where('item_id', '=', $itemId)->delete();
    }
}