<?php

namespace App\Interfaces;

interface EventRepositoryInterface 
{
    public function getEventById(int $eventId);
    public function getEventByUserId(int $userId);
    public function createEvent(array $eventData);
    public function updateEvent(int $eventId, array $newEventData);
}