<?php

namespace App\Repositories;

use App\Interfaces\ItemRepositoryInterface;
use App\Models\Item;

class ItemRepository implements ItemRepositoryInterface 
{
    public function getItemById($itemId) 
    {
        return Item::where('id', '=', $itemId)->with('member')->with('item')->get();
    }

    public function getItemByEventId($eventId) 
    {
        return Item::where('user_id', '=', $eventId)->get();
    }

    public function createItem(array $itemData) 
    {
        return Item::create($itemData);
    }

    public function updateItem($itemId, array $newItemData) 
    {
        return Item::whereId($itemId)->update($newItemData);
    }
}