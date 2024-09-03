<?php

namespace Tests\Unit;

use App\Services\ItemsFormatService;
use App\Services\MemberService;
use App\Models\Item;
use App\Models\Member;
use Illuminate\Database\Eloquent\Collection;
use PHPUnit\Framework\TestCase;
use Mockery;

class ItemsFormatServiceTest extends TestCase
{
    /** @var \Mockery\MockInterface|MemberService $memberService */
    private $memberService;

    protected function setUp(): void
    {
        parent::setUp();

        // 創建 MemberService 的 mock 物件
        $this->memberService = Mockery::mock(MemberService::class);
    }

    /**
     * @return void
     */
    public function test_formatItems(): void
    {
        // Arrange
        $items = new Collection([
            new Item([
                'event_id'     => 1,
                'item_id'      => 1,
                'item_name'    => '車費',
                'price'        => 100,
                'payer'        => 1,
                'share_member' => 1,
            ]),
            new Item([
                'event_id'     => 1,
                'item_id'      => 1,
                'item_name'    => '車費',
                'price'        => 100,
                'payer'        => 1,
                'share_member' => 2,
            ]),
        ]);

        // 設定 Mock 行為
        $this->memberService
            ->shouldReceive('getMemberById')
            ->with(1)
            ->andReturn(new Member(['name' => 'Andy']));

        $this->memberService
            ->shouldReceive('getMemberById')
            ->with(2)
            ->andReturn(new Member(['name' => 'Diane']));

        $itemsFormatService = new ItemsFormatService($this->memberService);

        // Act
        $formattedItems = $itemsFormatService->formatItems($items);

        // Assert
        $expected = [
        1 => [
                'eventId'     => 1,
                'itemId'      => 1,
                'itemName'    => '車費',
                'price'       => 100,
                'payer'       => 'Andy',
                'shareMember' => ['Andy', 'Diane',],
            ],
        ];

        $this->assertEquals($expected, $formattedItems);
    }
}
