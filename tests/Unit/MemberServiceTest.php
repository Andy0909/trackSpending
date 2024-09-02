<?php

namespace Tests\Unit;

use App\Services\MemberService;
use App\Repositories\MemberRepository;
use App\Models\Member;
use Mockery;
use PHPUnit\Framework\TestCase;

class MemberServiceTest extends TestCase
{
    /** @const int 成員編號 */
    private const MEMBER_ID = 1;

    /** @const string 活動編號 */
    private const EVENT_ID = '1';

    /** @const string 成員姓名 */
    private const MEMBER_NAME = 'Andy';

    /** @var Mockery\MockInterface|MemberRepository */
    private $memberRepository;

    protected function setUp(): void
    {
        parent::setUp();

        // 使用 Mockery 創建 MemberRepository 的 mock 物件
        $this->memberRepository = Mockery::mock(MemberRepository::class);
    }

    public function test_getMemberById()
    {
        // arrange
        $expectedMember = $this->getExpectedMemberData();

        $this->memberRepository
            ->shouldReceive('getMemberById')
            ->once()
            ->with(self::MEMBER_ID)
            ->andReturn($expectedMember);

        $memberService = new MemberService($this->memberRepository);

        // act
        $member = $memberService->getMemberById(self::MEMBER_ID);

        // assert
        $this->assertEquals($expectedMember, $member);
    }

    public function test_createMember()
    {
        // arrange
        $memberData = $this->getCreateMemberData();
        $expectedMember = new Member($memberData);

        $this->memberRepository
            ->shouldReceive('createMember')
            ->once()
            ->with($memberData)
            ->andReturn($expectedMember);

        $memberService = new MemberService($this->memberRepository);

        // act
        $member = $memberService->createMember($memberData);

        // assert
        $this->assertEquals($expectedMember, $member);
    }

    private function getExpectedMemberData(): Member
    {
        return new Member([
            'id'      => self::MEMBER_ID,
            'eventId' => self::EVENT_ID,
            'name'    => self::MEMBER_NAME,
        ]);
    }

    private function getCreateMemberData(): array
    {
        return [
            'id'       => self::MEMBER_ID,
            'event_id' => self::EVENT_ID,
            'name'     => self::MEMBER_NAME,
        ];
    }
}
