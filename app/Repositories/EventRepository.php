<?php

namespace App\Repositories;

use App\Interfaces\EventRepositoryInterface;
use App\Models\Event;

class EventRepository implements EventRepositoryInterface 
{
    /** @var Event */
    private $eventModel;

    /**
     * construct
     * @param Event $eventModel
     */
    public function __construct(Event $eventModel) 
    {
        $this->eventModel = $eventModel;
    }

    /**
     * 利用 id 取得 event 資料
     * @param int $eventId
     * @return Event
     */
    public function getEventById($eventId): Event
    {
        return $this->eventModel
            ->newQuery()
            ->where('id', $eventId)
            ->with('member')
            ->with('item')
            ->first();
    }

    /**
     * 利用 user id 取得 event 資料
     * @param int $userId
     * @return Event[]
     */
    public function getEventByUserId(int $userId): array
    {
        return $this->eventModel
            ->newQuery()
            ->where('user_id', $userId)
            ->get()
            ->all();
    }

    /**
     * 新增 event 資料
     * @param array $eventData
     * @return Event
     */
    public function createEvent(array $eventData): Event
    {
        return $this->eventModel
            ->newQuery()
            ->create($eventData);
    }
}