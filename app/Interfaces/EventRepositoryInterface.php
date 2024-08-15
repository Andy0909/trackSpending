<?php

namespace App\Interfaces;

use App\Models\Event;

interface EventRepositoryInterface 
{
    /**
     * 利用 id 取得 event 資料
     * @param int $eventId
     * @return Event
     */
    public function getEventById(int $eventId): Event;

    /**
     * 利用 user id 取得 event 資料
     * @param int $userId
     * @return Event[]
     */
    public function getEventByUserId(int $userId): array;

    /**
     * 新增 event 資料
     * @param array $eventData
     * @return Event
     */
    public function createEvent(array $eventData): Event;
}