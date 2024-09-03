<?php

namespace Tests\Unit\Services;

use App\Models\Event;
use App\Repositories\EventRepository;
use App\Services\CacheService;
use App\Services\EventService;
use PHPUnit\Framework\TestCase;
use Mockery;

class EventServiceTest extends TestCase
{
    /** @var \Mockery\MockInterface|EventRepository $eventRepository */
    protected $eventRepository;

    /** @var \Mockery\MockInterface|CacheService $cacheService */
    protected $cacheService;

    protected function setUp(): void
    {
        parent::setUp();

        $this->eventRepository = Mockery::mock(EventRepository::class);
        $this->cacheService = Mockery::mock(CacheService::class);
    }

    /**
     * @return void
     */
    public function test_getEventById(): void
    {
        // arrange
        $eventId = 1;
        $event = new Event(['id' => $eventId]);

        $this->cacheService
            ->shouldReceive('rememberCache')
            ->with('event_' . $eventId, 3600, Mockery::on(function ($callback) use ($event) {
                return $callback() === $event;
            }))
            ->once()
            ->andReturn($event);

        $this->eventRepository
            ->shouldReceive('getEventById')
            ->with($eventId)
            ->once()
            ->andReturn($event);

        $eventService = new EventService($this->eventRepository, $this->cacheService);

        // act
        $result = $eventService->getEventById($eventId);

        // assert
        $this->assertEquals($event, $result);
    }

    /**
     * @return void
     */
    public function test_getEventByUserId(): void
    {
        // arrange
        $userId = 1;
        $events = [
            new Event(['id' => 1, 'user_id' => $userId]),
            new Event(['id' => 2, 'user_id' => $userId]),
        ];

        $this->eventRepository
            ->shouldReceive('getEventByUserId')
            ->with($userId)
            ->once()
            ->andReturn($events);

        $eventService = new EventService($this->eventRepository, $this->cacheService);

        // act
        $result = $eventService->getEventByUserId($userId);

        // assert
        $this->assertEquals($events, $result);
    }

    /**
     * @return void
     */
    public function test_createEvent(): void
    {
        // arrange
        $eventData = ['name' => 'New Event'];
        $event = new Event($eventData);

        $this->eventRepository
            ->shouldReceive('createEvent')
            ->with($eventData)
            ->once()
            ->andReturn($event);

        $eventService = new EventService($this->eventRepository, $this->cacheService);

        // act
        $result = $eventService->createEvent($eventData);

        // assert
        $this->assertEquals($event, $result);
    }

    /**
     * @return void
     */
    public function test_updateEvent(): void
    {
        // arrange
        $eventId = 1;
        $eventData = ['name' => 'Updated Event'];
        $affectedRows = 1;

        $this->eventRepository
            ->shouldReceive('updateEvent')
            ->with($eventId, $eventData)
            ->once()
            ->andReturn($affectedRows);

        $eventService = new EventService($this->eventRepository, $this->cacheService);

        // act
        $result = $eventService->updateEvent($eventId, $eventData);

        // assert
        $this->assertEquals($affectedRows, $result);
    }

    /**
     * @return void
     */
    public function test_deleteOverOneYearEvents(): void
    {
        // arrange
        $affectedRows = 10;

        $this->eventRepository
            ->shouldReceive('deleteOverOneYearEvents')
            ->once()
            ->andReturn($affectedRows);

        $eventService = new EventService($this->eventRepository, $this->cacheService);

        // act
        $result = $eventService->deleteOverOneYearEvents();

        // assert
        $this->assertEquals($affectedRows, $result);
    }
}
