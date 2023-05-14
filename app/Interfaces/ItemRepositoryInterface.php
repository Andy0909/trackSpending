<?php

namespace App\Interfaces;

interface ItemRepositoryInterface 
{
    public function getItemById(int $itemId);
    public function getItemByEventId(int $eventId);
    public function getLastItemId();
    public function createItem(array $itemData);
    public function updateItem(int $itemId, array $newItemData);
    public function deleteItemByEventIdAndItemId(int $eventId, int $itemId);
}