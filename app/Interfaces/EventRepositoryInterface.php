<?php

namespace App\Interfaces;

interface EventRepositoryInterface 
{
    public function getEventById($eventId);
    public function createEvent(array $eventData);
    public function updateEvent($eventId, array $newEventData);
}