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
     * deleteItemByItemName
     * @param int $eventId
     * @param string $itemName
     * @return void
     */
    public function deleteItemByItemName(int $eventId, string $itemName) 
    {
        return Item::where('event_id', '=', $eventId)->where('item_name', '=', $itemName)->delete();
    }
}