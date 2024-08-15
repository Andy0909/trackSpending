<?php 

namespace App\Services;

use App\Repositories\MemberRepository;
use App\Models\Member;

class MemberService
{
    /** @var MemberRepository */
    private $memberRepository;

    /**
     * construct
     * @param MemberRepository $memberRepository
     */
    public function __construct(MemberRepository $memberRepository) 
    {
        $this->memberRepository = $memberRepository;
    }

    /**
     * 利用 id 取得 member 資料
     * @param int $memberId
     * @return Member
     */
    public function getMemberById(int $memberId): Member
    {
        return $this->memberRepository->getMemberById($memberId);
    }

    /**
     * 建立 member 資料
     * @param array $memberData
     * @return Member
     */
    public function createMember(array $memberData): Member
    {
        return $this->memberRepository->createMember($memberData);
    }
}