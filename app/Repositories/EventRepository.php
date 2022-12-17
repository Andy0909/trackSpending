<?php

namespace App\Repositories;

use App\Interfaces\EventRepositoryInterface;
use App\Models\Event;

class EventRepository implements EventRepositoryInterface 
{
    public function getEventById($eventId) 
    {
        return Event::where('id', '=', $eventId)->with('member')->with('item')->get();
    }

    public function getEventByUserId($userId) 
    {
        return Event::where('user_id', '=', $userId)->get();
    }

    public function createEvent(array $eventData) 
    {
        return Event::create($eventData);
    }

    public function updateEvent($eventId, array $newEventData) 
    {
        return Event::whereId($eventId)->update($newEventData);
    }
}