<?php

namespace App\Repositories;

use App\Interfaces\EventRepositoryInterface;
use App\Models\Event;
use Carbon\Carbon;

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
            ->where('status', 1)
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
            ->where('status', 1)
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

    /**
     * 刪除超過一年的 event 資料
     * @return int
     */
    public function deleteOverOneYearEvents(): int
    {
        $oneYearAgoDate = Carbon::now()->subYear();
    
        return $this->eventModel
            ->newQuery()
            ->where('created_at', '<', $oneYearAgoDate)
            ->update(['status' => 0,]);
    }
}