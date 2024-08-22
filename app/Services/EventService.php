<?php

namespace App\Services;

use App\Models\Event;
use App\Repositories\EventRepository;
use App\Services\CacheService;

class EventService
{
    /** @var EventRepository */
    private $eventRepository;

    /** @var CacheService */
    private $cacheService;

    /**
     * construct
     * @param EventRepository $eventRepository
     * @param CacheService $cacheService
     */
    public function __construct(EventRepository $eventRepository, CacheService $cacheService)
    {
        $this->eventRepository = $eventRepository;
        $this->cacheService = $cacheService;
    }

    /**
     * 利用 id 取得 event 資料
     * @param int $eventId
     * @return Event
     */
    public function getEventById(int $eventId): Event
    {
        $cacheKey = 'event_' . $eventId;

        return $this->cacheService->rememberCache($cacheKey, 3600, function () use ($eventId) {
            return $this->eventRepository->getEventById($eventId);
        });
    }

    /**
     * 利用 user id 取得 event 資料
     * @param int $userId
     * @return Event[]
     */
    public function getEventByUserId($userId): array
    {
        return $this->eventRepository->getEventByUserId($userId);
    }

    /**
     * 新增 event 資料
     * @param array $eventData
     * @return Event
     */
    public function createEvent(array $eventData): Event
    {
        return $this->eventRepository->createEvent($eventData);
    }

    /**
     * 更新 event 資料
     * @param int $eventId
     * @param array $eventData
     * @return int
     */
    public function updateEvent(int $eventId, array $eventData): int
    {
        return $this->eventRepository->updateEvent($eventId, $eventData);
    }

    /**
     * 刪除超過一年的 event 資料
     * @return int
     */
    public function deleteOverOneYearEvents(): int
    {
        return $this->eventRepository->deleteOverOneYearEvents();
    }
}
