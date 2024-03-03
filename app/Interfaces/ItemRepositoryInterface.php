<?php

namespace App\Interfaces;

interface ItemRepositoryInterface 
{
    public function getItemById(string $itemId);
    public function getItemByEventId(string $eventId);
    public function getLastItemId();
    public function createItem(array $itemData);
    public function updateItem(string $itemId, array $newItemData);
    public function deleteItemByEventIdAndItemId(string $eventId, string $itemId);
}