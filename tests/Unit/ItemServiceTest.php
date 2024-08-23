<?php

namespace Tests\Unit;

use App\Services\ItemService;
use App\Repositories\ItemRepository;
use App\Models\Item;
use Carbon\Carbon;
use PHPUnit\Framework\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ItemServiceTest extends TestCase
{
    /** @var ItemRepository */
    private $itemRepository;

    /** @var ItemService */
    private $itemService;

    protected function setUp(): void
    {
        parent::setUp();

        // 創建 ItemRepository 的 mock 物件
        $this->itemRepository = $this->createMock(ItemRepository::class);

        // 將 mock 物件注入到 ItemService 中
        $this->itemService = new ItemService($this->itemRepository);
    }

    public function testGetItemByEventId()
    {
        $eventId = '1';

        $expectedItems = [
            new Item([
                'id'           => 1,
                'eventId'      => $eventId,
                'item_name'    => '測試',
                'price'        => '100',
                'payer'        => '1',
                'share_member' => '1',
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
                'item_id'      => 1,
            ]),
            new Item([
                'id'           => 2,
                'eventId'      => $eventId,
                'item_name'    => '測試',
                'price'        => '100',
                'payer'        => '1',
                'share_member' => '2',
                'created_at'   => Carbon::now(),
                'updated_at'   => Carbon::now(),
                'item_id'      => 1,
            ]),
        ];

        // 設定 Mock 行為
        $this->itemRepository
            ->expects($this->once())
            ->method('getItemByEventId')
            ->with($eventId)
            ->willReturn($expectedItems);

        // 呼叫 Service 方法並斷言結果
        $items = $this->itemService->getItemByEventId($eventId);
        $this->assertEquals($expectedItems, $items);
    }

    public function testCreateItem()
    {
        $itemData = [
            'eventId'      => '1',
            'item_name'    => '測試',
            'price'        => '100',
            'payer'        => '1',
            'share_member' => '1',
            'item_id'      => 1,
        ];

        $createdItem = new Item($itemData);

        // 設定 Mock 行為
        $this->itemRepository->expects($this->once())
            ->method('createItem')
            ->with($itemData)
            ->willReturn($createdItem);

        // 呼叫 Service 方法並斷言結果
        $item = $this->itemService->createItem($itemData);

        $this->assertEquals($createdItem, $item);
    }

    public function testDeleteItemByEventIdAndItemId()
    {
        $eventId = 1;
        $itemId = 1;
        $expectedAffectedRows = 1;

        // 模擬 repository 返回的結果
        $this->itemRepository
            ->method('deleteItemByEventIdAndItemId')
            ->with($eventId, $itemId)
            ->willReturn($expectedAffectedRows);

        // 驗證 service 的返回值
        $affectedRows = $this->itemService->deleteItemByEventIdAndItemId($eventId, $itemId);

        $this->assertEquals($expectedAffectedRows, $affectedRows);
    }
}
