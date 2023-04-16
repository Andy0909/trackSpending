<?php

namespace App\Interfaces;

interface ItemRepositoryInterface 
{
    public function getItemById(int $itemId);
    public function getItemByEventId(int $eventId);
    public function createItem(array $itemData);
    public function updateItem(int $itemId, array $newItemData);
    public function deleteItemByItemName(int $eventId, string $itemName);
}