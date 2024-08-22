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

    /**
     * 更新 event 資料
     * @param int $eventId
     * @param array $eventData
     * @return int
     */
    public function updateEvent(int $eventId, array $eventData): int;

    /**
     * 刪除超過一年的 event 資料
     * @return int
     */
    public function deleteOverOneYearEvents(): int;
}
