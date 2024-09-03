<?php

namespace Tests\Unit\Services;

use App\Models\Item;
use App\Repositories\ItemRepository;
use App\Services\ItemService;
use PHPUnit\Framework\TestCase;
use Mockery;

class ItemServiceTest extends TestCase
{
    /** @const int 活動編號 */
    private const EVENT_ID = 1;

    /** @const int 項目編號 */
    private const ITEM_ID = 1;

    /** @var \Mockery\MockInterface|ItemRepository $itemRepository */
    protected $itemRepository;

    protected function setUp(): void
    {
        parent::setUp();

        $this->itemRepository = Mockery::mock(ItemRepository::class);
    }

    /**
     * @return void
     */
    public function test_getItemByEventId(): void
    {
        // arrange
        $this->itemRepository
            ->shouldReceive('getItemByEventId')
            ->with(self::EVENT_ID)
            ->once()
            ->andReturn($this->getExpectedData());

        $itemService = new ItemService($this->itemRepository);

        // act
        $items = $itemService->getItemByEventId(self::EVENT_ID);

        // assert
        $this->assertEquals($this->getExpectedData(), $items);
    }

    /**
     * @return Item[]
     */
    private function getExpectedData(): array
    {
        return [
            new Item([
                'id'           => 1,
                'eventId'      => self::EVENT_ID,
                'item_name'    => '測試',
                'price'        => '100',
                'payer'        => '1',
                'share_member' => '1',
                'item_id'      => self::ITEM_ID,
            ]),
            new Item([
                'id'           => 2,
                'eventId'      => self::EVENT_ID,
                'item_name'    => '測試',
                'price'        => '100',
                'payer'        => '1',
                'share_member' => '2',
                'item_id'      => self::ITEM_ID,
            ]),
        ];
    }

    /**
     * @return void
     */
    public function test_createItem(): void
    {
        // arrange
        $this->itemRepository
            ->shouldReceive('createItem')
            ->with($this->getCreatedItemData())
            ->once()
            ->andReturn(new Item($this->getCreatedItemData()));

        $itemService = new ItemService($this->itemRepository);

        // act
        $item = $itemService->createItem($this->getCreatedItemData());

        // assert
        $this->assertEquals(new Item($this->getCreatedItemData()), $item);
    }

    /**
     * @return array
     */
    private function getCreatedItemData(): array
    {
        return [
            'eventId'      => self::EVENT_ID,
            'item_name'    => '測試',
            'price'        => '100',
            'payer'        => '1',
            'share_member' => '1',
            'item_id'      => self::ITEM_ID,
        ];
    }

    /**
     * @return void
     */
    public function test_deleteItemByEventIdAndItemId(): void
    {
        // arrange
        $expectedAffectedRows = 1;

        $this->itemRepository
            ->shouldReceive('deleteItemByEventIdAndItemId')
            ->with(self::EVENT_ID, self::ITEM_ID)
            ->once()
            ->andReturn($expectedAffectedRows);

        $itemService = new ItemService($this->itemRepository);

        // act
        $affectedRows = $itemService->deleteItemByEventIdAndItemId(self::EVENT_ID, self::ITEM_ID);

        // assert
        $this->assertEquals($expectedAffectedRows, $affectedRows);
    }
}
